#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import pymysql
import ftfy

def candidates(s):
    out = []
    out.append(('orig', s))
    try:
        out.append(('ftfy.fix_text', ftfy.fix_text(s)))
    except Exception as e:
        out.append(('ftfy.fix_text err', str(e)))
    try:
        out.append(('ftfy.fix_encoding', ftfy.fix_encoding(s)))
    except Exception as e:
        out.append(('ftfy.fix_encoding err', str(e)))
    try:
        u = s.encode('latin1', errors='replace').decode('utf-8', errors='replace')
        out.append(('latin1->utf8', u))
    except Exception as e:
        out.append(('latin1->utf8 err', str(e)))
    try:
        u = s.encode('utf-8', errors='surrogateescape').decode('latin1', errors='replace')
        out.append(('utf8bytes->latin1', u))
    except Exception as e:
        out.append(('utf8bytes->latin1 err', str(e)))
    return out

import io

conn = pymysql.connect(host='127.0.0.1', user='root', password='', db='devchampion', charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
cur = conn.cursor()
remaining = [
    ('blogs', 'content_demo'),
    ('cat_blogs', 'name'),
    ('chat_messages', 'content'),
    ('orders', 'fullname'),
    ('permissions', 'name'),
]
with io.open('tools/remaining_debug.txt', 'w', encoding='utf-8') as out_file:
    for table, col in remaining:
        out_file.write(f'=== {table}.{col}\n')
        cur.execute(f"SELECT id, `{col}` AS value FROM `{table}` WHERE `{col}` REGEXP %s LIMIT 20", ('[ÃÂ├┬ßÇÕÓÌÏÐ]',))
        rows = cur.fetchall()
        for r in rows:
            out_file.write(f'ID {r["id"]}\n')
            for name, candidate_text in candidates(r['value']):
                out_file.write(f'--- {name}\n')
                out_file.write(candidate_text[:300] + '\n')
            out_file.write('\n')
conn.close()
