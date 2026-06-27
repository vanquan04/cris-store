#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import pymysql, ftfy
DB_HOST='127.0.0.1'
DB_PORT=3306
DB_USER='root'
DB_PASS=''
DB_NAME='devchampion'
conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
with conn.cursor() as cur:
    cur.execute("SELECT id, content_demo FROM blogs WHERE id=10")
    row = cur.fetchone()
    s = row['content_demo']
    print('ORIG:')
    print(s[:400])
    print('\nFTFY:')
    print(ftfy.fix_text(s)[:400])
    print('\nLATIN1->UTF8:')
    try:
        print(s.encode('latin1').decode('utf-8')[:400])
    except Exception as e:
        print('error', e)
    print('\nUTF8->LATIN1->UTF8:')
    try:
        t = s.encode('utf-8', errors='surrogateescape')
        u = t.decode('latin1')
        print(u[:400])
        print('\nFTFY on that:')
        print(ftfy.fix_text(u)[:400])
    except Exception as e:
        print('error', e)
    print('\nCOMBINED ftfy on latin1->utf8:')
    try:
        c = ftfy.fix_text(s.encode('latin1').decode('utf-8'))
        print(c[:400])
    except Exception as e:
        print('error', e)
conn.close()
