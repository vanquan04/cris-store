#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Scan all text columns in the devchampion DB and fix mojibake using ftfy.
Backs up affected rows to a CSV before updating.
"""
import pymysql
import ftfy
import csv
import os

DB_HOST = '127.0.0.1'
DB_PORT = 3306
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'devchampion'

conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)

def get_text_columns():
    sql = """
    SELECT TABLE_NAME, COLUMN_NAME
    FROM information_schema.columns
    WHERE table_schema=%s AND DATA_TYPE IN ('char','varchar','text','mediumtext','longtext')
    """
    with conn.cursor() as cur:
        cur.execute(sql, (DB_NAME,))
        return cur.fetchall()

def get_primary_key(table):
    with conn.cursor() as cur:
        cur.execute("SELECT COLUMN_NAME FROM information_schema.key_column_usage WHERE table_schema=%s AND table_name=%s AND constraint_name='PRIMARY'", (DB_NAME, table))
        row = cur.fetchone()
        return row['COLUMN_NAME'] if row else None

def scan_and_fix():
    cols = get_text_columns()
    print(f"Found {len(cols)} text columns to check")
    updated_count = 0
    for row in cols:
        table = row['TABLE_NAME']
        col = row['COLUMN_NAME']
        pk = get_primary_key(table)
        if not pk:
            continue
        # select rows with common mojibake tokens or non-utf sequences
        sel = f"SELECT `{pk}`, `{col}` FROM `{table}` WHERE `{col}` REGEXP '[├┬Ã]' LIMIT 1000"
        with conn.cursor() as cur:
            cur.execute(sel)
            rows = cur.fetchall()
        if not rows:
            continue
        # backup
        backup_dir = os.path.join('tools','backups')
        os.makedirs(backup_dir, exist_ok=True)
        backup_file = os.path.join(backup_dir, f"backup_{table}_{col}.csv")
        with open(backup_file, 'w', newline='', encoding='utf-8') as bf:
            writer = csv.writer(bf)
            writer.writerow([pk, col])
            for r in rows:
                writer.writerow([r[pk], r[col]])
        print(f"Backed up {len(rows)} rows from {table}.{col} to {backup_file}")
        # attempt fixes
        for r in rows:
            orig = r[col]
            if orig is None:
                continue
            fixed = ftfy.fix_text(orig)
            if fixed != orig:
                # update row
                upd = f"UPDATE `{table}` SET `{col}`=%s WHERE `{pk}`=%s"
                with conn.cursor() as cur:
                    cur.execute(upd, (fixed, r[pk]))
                updated_count += 1
        conn.commit()
        print(f"Updated {updated_count} total rows so far")
    print(f"Done. Total updated rows: {updated_count}")

if __name__ == '__main__':
    scan_and_fix()
    conn.close()
