#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import pymysql
import io
import re

DB_HOST = '127.0.0.1'
DB_PORT = 3306
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'devchampion'
PATTERN = r'[├┬ÃßπÇ]'

conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
cur = conn.cursor()
with io.open('tools/mojibake_hex.txt', 'w', encoding='utf-8') as out:
    cur.execute("SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.columns WHERE table_schema=%s AND DATA_TYPE IN ('char','varchar','text','mediumtext','longtext')", (DB_NAME,))
    cols = cur.fetchall()
    for row in cols:
        table = row['TABLE_NAME']
        column = row['COLUMN_NAME']
        cur.execute(f"SELECT `{column}` AS value, HEX(`{column}`) AS hexval FROM `{table}` WHERE `{column}` REGEXP %s LIMIT 20", (PATTERN,))
        rows = cur.fetchall()
        if not rows:
            continue
        out.write(f'=== {table}.{column} ({len(rows)} rows)\n')
        for r in rows:
            val = r['value']
            out.write('VALUE: ' + repr(val) + '\n')
            out.write('HEX: ' + (r['hexval'] or '') + '\n')
        out.write('\n')
conn.close()
