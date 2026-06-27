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
SUSPECT_PATTERN = re.compile(r'[ÃÂÄÅªÆÇÐÊËÌÏÑÒÓÔÕÖ×Øßàáâãäåçèéêëìíîïñòóôõöùúûüýÿ├┬]|ß╗|ß║|ß╝|ßº|ß¼|Â|Ã')
VIETNAMESE_ACCENT = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', re.I)

CANDIDATE_FUNCS = [
    ('ftfy.fix_text', ftfy.fix_text),
    ('ftfy.fix_encoding', ftfy.fix_encoding),
    ('latin1->utf8', lambda s: s.encode('latin1', errors='ignore').decode('utf-8', errors='ignore')),
    ('utf8bytes->latin1', lambda s: s.encode('utf-8', errors='surrogateescape').decode('latin1', errors='ignore')),
]


def score_text(text):
    if text is None:
        return -9999
    bad = len(SUSPECT_PATTERN.findall(text))
    good = len(VIETNAMESE_ACCENT.findall(text))
    common = len(re.findall(r'\b(gi|đi|của|và|những|thành|trên|dưới|trong|cho|của)\b', text, re.I))
    return good * 10 + common * 5 - bad * 20


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


def row_needs_fix(value):
    if value is None:
        return False
    return bool(SUSPECT_PATTERN.search(value))


def try_fix(value):
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


def backup_and_update(conn, table, column, pk, rows):
    backup_dir = os.path.join('tools', 'backups')
    os.makedirs(backup_dir, exist_ok=True)
    backup_file = os.path.join(backup_dir, f'strict_backup_{table}_{column}.csv')
    with open(backup_file, 'w', encoding='utf-8', newline='') as bf:
        writer = csv.writer(bf)
        writer.writerow([pk, column, 'original'])
        for r in rows:
            writer.writerow([r[pk], r[column]])
    print(f'Backed up {len(rows)} rows for {table}.{column} to {backup_file}')
    updated = 0
    with conn.cursor() as cur:
        for r in rows:
            orig = r[column]
            name, fixed, score = try_fix(orig)
            if fixed != orig and score > score_text(orig):
                cur.execute(f"UPDATE `{table}` SET `{column}`=%s WHERE `{pk}`=%s", (fixed, r[pk]))
                updated += 1
    if updated:
        conn.commit()
    return updated


def process(conn):
    cols = get_text_columns(conn)
    total_updated = 0
    for row in cols:
        table = row['TABLE_NAME']
        column = row['COLUMN_NAME']
        pk = get_primary_key(conn, table)
        if not pk:
            continue
        with conn.cursor() as cur:
            cur.execute(f"SELECT `{pk}`, `{column}` FROM `{table}` WHERE `{column}` REGEXP %s LIMIT 500", ('[ÃÂÄÅªÆÇÐÊËÌÏÑÒÓÔÕÖ×Øßàáâãäåçèéêëìíîïñòóôõöùúûüýÿ├┬]',))
            rows = cur.fetchall()
        rows = [r for r in rows if row_needs_fix(r[column])]
        if not rows:
            continue
        updated = backup_and_update(conn, table, column, pk, rows)
        if updated:
            print(f'Updated {updated} rows in {table}.{column}')
        total_updated += updated
    print(f'Total updated rows: {total_updated}')

if __name__ == '__main__':
    conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
    try:
        process(conn)
    finally:
        conn.close()
