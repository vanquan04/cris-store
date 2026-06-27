#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import os
import re
import csv
import pymysql
import ftfy

DB_HOST = '127.0.0.1'
DB_PORT = 3306
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'devchampion'
SUSPECT_PATTERN = re.compile(r'[├┬ÃßπÇ]')

CANDIDATE_FUNCS = [
    ('ftfy.fix_text', ftfy.fix_text),
    ('ftfy.fix_encoding', ftfy.fix_encoding),
    ('latin1->utf8', lambda s: s.encode('latin1', errors='ignore').decode('utf-8', errors='ignore')),
    ('utf8bytes->latin1', lambda s: s.encode('utf-8', errors='surrogateescape').decode('latin1', errors='ignore')),
]


def suspect_count(text):
    if text is None:
        return 0
    return len(SUSPECT_PATTERN.findall(text))


def score_text(text):
    if text is None:
        return -9999
    score = 0
    score -= suspect_count(text) * 100
    score += len(re.findall(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', text, re.I)) * 5
    score += len(re.findall(r'\b(và|của|cho|trên|dưới|này|đây|học|giày|cửa|hàng|khách|sản|phẩm)\b', text, re.I)) * 2
    score -= len(re.findall(r'\uFFFD', text)) * 50
    return score


def get_text_columns(conn):
    sql = "SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.columns WHERE table_schema=%s AND DATA_TYPE IN ('char','varchar','text','mediumtext','longtext')"
    with conn.cursor() as cur:
        cur.execute(sql, (DB_NAME,))
        return cur.fetchall()


def get_primary_key(conn, table):
    with conn.cursor() as cur:
        cur.execute("SELECT COLUMN_NAME FROM information_schema.key_column_usage WHERE table_schema=%s AND table_name=%s AND constraint_name='PRIMARY'", (DB_NAME, table))
        row = cur.fetchone()
        return row['COLUMN_NAME'] if row else None


def find_rows(conn, table, column):
    with conn.cursor() as cur:
        cur.execute(f"SELECT `{table}`.`{column}` AS value, `{pk}` AS pk FROM `{table}` WHERE `{column}` REGEXP %s LIMIT 1000", ('[├┬ÃßπÇ]',))
        return cur.fetchall()


def try_candidates(value):
    candidates = [('orig', value, score_text(value))]
    for name, func in CANDIDATE_FUNCS:
        try:
            cand = func(value)
        except Exception:
            continue
        if cand is None:
            continue
        candidates.append((name, cand, score_text(cand)))
    return max(candidates, key=lambda x: x[2])


def backup_rows(table, column, pk, rows):
    backup_dir = os.path.join('tools', 'backups')
    os.makedirs(backup_dir, exist_ok=True)
    backup_file = os.path.join(backup_dir, f'remaining_backup_{table}_{column}.csv')
    with open(backup_file, 'w', encoding='utf-8', newline='') as bf:
        writer = csv.writer(bf)
        writer.writerow([pk, column])
        for r in rows:
            writer.writerow([r[pk], r['value']])
    return backup_file


def process(conn):
    cols = get_text_columns(conn)
    total_updated = 0
    for row in cols:
        table = row['TABLE_NAME']
        column = row['COLUMN_NAME']
        global pk
        pk = get_primary_key(conn, table)
        if not pk:
            continue
        with conn.cursor() as cur:
            cur.execute(f"SELECT `{pk}`, `{column}` AS value FROM `{table}` WHERE `{column}` REGEXP %s LIMIT 1000", ('[├┬ÃßπÇ]',))
            rows = cur.fetchall()
        if not rows:
            continue
        backup_file = backup_rows(table, column, pk, rows)
        updated = 0
        with conn.cursor() as cur:
            for r in rows:
                orig = r['value']
                if orig is None:
                    continue
                best_name, best_text, best_score = try_candidates(orig)
                orig_score = score_text(orig)
                if best_text != orig and best_score > orig_score:
                    cur.execute(f"UPDATE `{table}` SET `{column}`=%s WHERE `{pk}`=%s", (best_text, r[pk]))
                    updated += 1
        if updated > 0:
            conn.commit()
            print(f'Updated {updated} rows in {table}.{column} (backup: {backup_file})')
        total_updated += updated
    print(f'Total updated rows: {total_updated}')

if __name__ == '__main__':
    conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
    try:
        process(conn)
    finally:
        conn.close()
