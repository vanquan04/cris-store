#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import argparse
import csv
import os
import re
import pymysql
import ftfy

DB_HOST = '127.0.0.1'
DB_PORT = 3306
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'devchampion'

SUSPECT_PATTERN = re.compile(r'[ÃÂÄÅªÆÇÐÊËÌÏÑÒÓÔÕÖ×Øßπ├┬]|\uFFFD')
VIETNAMESE_PATTERN = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', re.I)
COMMON_WORDS = re.compile(r'\b(và|của|cho|trên|dưới|này|đây|hãy|đơn|giá|sản|phẩm|Khách|Cửa|hàng|thông|báo)\b', re.I)

CANDIDATES = [
    ('ftfy.fix_text', ftfy.fix_text),
    ('ftfy.fix_encoding', ftfy.fix_encoding),
    ('latin1->utf8', lambda s: s.encode('latin1', errors='replace').decode('utf-8', errors='replace')),
    ('cp1252->utf8', lambda s: s.encode('cp1252', errors='replace').decode('utf-8', errors='replace')),
    ('utf8->latin1->utf8', lambda s: s.encode('utf-8', errors='surrogateescape').decode('latin1', errors='replace')),
]


def score_text(text):
    if text is None:
        return -9999
    bad = len(SUSPECT_PATTERN.findall(text))
    good = len(VIETNAMESE_PATTERN.findall(text))
    common = len(COMMON_WORDS.findall(text))
    score = good * 20 + common * 6 - bad * 25
    if '�' in text:
        score -= 100
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


def backup_rows(table, column, pk, rows):
    backup_dir = os.path.join('tools', 'backups')
    os.makedirs(backup_dir, exist_ok=True)
    backup_file = os.path.join(backup_dir, f'verify_backup_{table}_{column}.csv')
    with open(backup_file, 'w', encoding='utf-8', newline='') as bf:
        writer = csv.writer(bf)
        writer.writerow([pk, column, 'original'])
        for row in rows:
            writer.writerow([row[pk], row['value']])
    return backup_file


def generate_candidates(value):
    candidates = [('orig', value, score_text(value))]
    for name, func in CANDIDATES:
        try:
            fixed = func(value)
        except Exception:
            continue
        if fixed is None:
            continue
        candidates.append((name, fixed, score_text(fixed)))
    return candidates


def choose_best(candidates):
    return max(candidates, key=lambda x: x[2])


def find_suspects(conn, table, column, pk, max_rows=None):
    with conn.cursor() as cur:
        sql = f"SELECT `{pk}`, `{column}` AS value, HEX(`{column}`) AS hex FROM `{table}` WHERE `{column}` IS NOT NULL"
        if max_rows:
            sql += " LIMIT %s"
            cur.execute(sql, (max_rows,))
        else:
            cur.execute(sql)
        for row in cur.fetchall():
            value = row['value']
            if value is None:
                continue
            original_score = score_text(value)
            if original_score > 0 and not SUSPECT_PATTERN.search(value):
                continue
            candidates = generate_candidates(value)
            best_name, best_val, best_score = choose_best(candidates)
            if best_name == 'orig' or best_score <= original_score:
                continue
            yield row[pk], value, row['hex'], best_name, best_val, original_score, best_score


def process(dry_run=True, max_rows=500):
    conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, database=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
    try:
        cols = get_text_columns(conn)
        report = []
        total_candidates = 0
        for row in cols:
            table = row['TABLE_NAME']
            column = row['COLUMN_NAME']
            pk = get_primary_key(conn, table)
            if not pk:
                continue
            suspects = list(find_suspects(conn, table, column, pk, max_rows=max_rows))
            if not suspects:
                continue
            total_candidates += len(suspects)
            if not dry_run:
                backup_rows(table, column, pk, [{'id': row[0], 'value': row[1]} for row in suspects])
                with conn.cursor() as cur:
                    for pk_val, orig, hexval, best_name, best_val, orig_score, best_score in suspects:
                        cur.execute(f"UPDATE `{table}` SET `{column}`=%s WHERE `{pk}`=%s", (best_val, pk_val))
                conn.commit()
            for pk_val, orig, hexval, best_name, best_val, orig_score, best_score in suspects:
                report.append({
                    'table': table,
                    'column': column,
                    'pk': pk,
                    'id': pk_val,
                    'hex': hexval,
                    'original_score': orig_score,
                    'best_score': best_score,
                    'best_transform': best_name,
                    'original': orig,
                    'fixed': best_val,
                })
        with open('tools/db_mojibake_verify_report.csv', 'w', encoding='utf-8', newline='') as out_csv:
            writer = csv.writer(out_csv)
            writer.writerow(['table','column','pk','id','hex','original_score','best_score','best_transform','original','fixed'])
            for row in report:
                writer.writerow([row['table'], row['column'], row['pk'], row['id'], row['hex'], row['original_score'], row['best_score'], row['best_transform'], row['original'], row['fixed']])
        print(f'Found {len(report)} candidate fixes across {len(set((r["table"], r["column"]) for r in report))} columns.')
        print('Report written to tools/db_mojibake_verify_report.csv')
        if dry_run and total_candidates == 0:
            print('No actual candidate reparations were found.')
    finally:
        conn.close()


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Verify or fix mojibake in text columns.')
    parser.add_argument('--apply', action='store_true', help='Apply fixes to the database.')
    parser.add_argument('--max', type=int, default=1000, help='Limit rows scanned per column.')
    args = parser.parse_args()
    process(dry_run=not args.apply, max_rows=args.max)
