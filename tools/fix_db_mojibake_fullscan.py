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

SUSPECT_PATTERN = re.compile(r'[ÃÂÄÅªÆÇÐÊËÌÏÑÒÓÔÕÖ×ØßÃ\uFFFD├┬]')
VIETNAMESE_PATTERN = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', re.I)
COMMON_WORDS = re.compile(r'\b(và|của|cho|trên|dưới|này|đây|học|giày|cửa|hàng|khách|sản|phẩm|tại|có|là)\b', re.I)

CANDIDATE_FUNCS = [
    ('ftfy.fix_text', ftfy.fix_text),
    ('ftfy.fix_encoding', ftfy.fix_encoding),
]


def score_text(text):
    if text is None:
        return -9999
    bad = len(SUSPECT_PATTERN.findall(text))
    good = len(VIETNAMESE_PATTERN.findall(text))
    common = len(COMMON_WORDS.findall(text))
    score = good * 10 + common * 3 - bad * 20
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
    backup_file = os.path.join(backup_dir, f'fullscan_backup_{table}_{column}.csv')
    with open(backup_file, 'w', encoding='utf-8', newline='') as bf:
        writer = csv.writer(bf)
        writer.writerow([pk, column])
        for r in rows:
            writer.writerow([r[pk], r[column]])
    return backup_file


def process_column(conn, table, column, pk):
    with conn.cursor() as cur:
        cur.execute(f"SELECT `{pk}`, `{column}` FROM `{table}` WHERE `{column}` IS NOT NULL")
        rows = cur.fetchall()
    if not rows:
        return 0
    changed_rows = []
    updates = []
    for r in rows:
        orig = r[column]
        if orig is None:
            continue
        best = ('orig', orig, score_text(orig))
        for name, func in CANDIDATE_FUNCS:
            try:
                fixed = func(orig)
            except Exception:
                continue
            if fixed is None:
                continue
            best_candidate = (name, fixed, score_text(fixed))
            if best_candidate[2] > best[2]:
                best = best_candidate
        if best[0] != 'orig' and best[2] > score_text(orig):
            changed_rows.append(r)
            updates.append((r[pk], best[1]))
    if not updates:
        return 0
    backup_file = backup_rows(table, column, pk, changed_rows)
    with conn.cursor() as cur:
        for pk_val, new_value in updates:
            cur.execute(f"UPDATE `{table}` SET `{column}`=%s WHERE `{pk}`=%s", (new_value, pk_val))
    conn.commit()
    print(f"Updated {len(updates)} rows in {table}.{column}, backup saved to {backup_file}")
    return len(updates)


def main():
    conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
    try:
        cols = get_text_columns(conn)
        total = 0
        for row in cols:
            table = row['TABLE_NAME']
            column = row['COLUMN_NAME']
            pk = get_primary_key(conn, table)
            if not pk:
                continue
            updated = process_column(conn, table, column, pk)
            total += updated
        print(f'Total updated rows across all columns: {total}')
    finally:
        conn.close()

if __name__ == '__main__':
    main()
