#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import pymysql
import re

DB_HOST = '127.0.0.1'
DB_PORT = 3306
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'devchampion'
PATTERN = r'[├┬ÃßπÇ]'
# narrow pattern for actual mojibake tokens, not valid Vietnamese accents

conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
cur = conn.cursor()
cur.execute("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.columns WHERE table_schema=%s AND DATA_TYPE IN ('char','varchar','text','mediumtext','longtext')", (DB_NAME,))
cols = cur.fetchall()
summary = []
for row in cols:
    table = row['TABLE_NAME']
    column = row['COLUMN_NAME']
    cur.execute(f"SELECT COUNT(*) AS cnt FROM `{table}` WHERE `{column}` REGEXP %s", (PATTERN,))
    cnt = cur.fetchone()['cnt']
    if cnt > 0:
        summary.append((table, column, cnt))
        print(f'{table}.{column}: {cnt}')
        cur.execute(f"SELECT `{column}` FROM `{table}` WHERE `{column}` REGEXP %s LIMIT 5", (PATTERN,))
        for sample in cur.fetchall():
            val = sample[column]
            print('  -', repr(val)[:200])
        print()

print('TOTAL columns with matches:', len(summary))
print('TOTAL rows with matches:', sum(cnt for _, _, cnt in summary))
conn.close()
