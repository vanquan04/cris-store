#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import pymysql, ftfy, csv, os, sys
DB_HOST='127.0.0.1'
DB_PORT=3306
DB_USER='root'
DB_PASS=''
DB_NAME='devchampion'

def fix_column(table, column, pk='id'):
    conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
    cur = conn.cursor()
    cur.execute(f"SELECT `{pk}`, `{column}` FROM `{table}`")
    rows = cur.fetchall()
    backup_dir = os.path.join('tools','backups')
    os.makedirs(backup_dir, exist_ok=True)
    backup_file = os.path.join(backup_dir, f'backup_{table}_{column}_full.csv')
    with open(backup_file, 'w', encoding='utf-8', newline='') as bf:
        w = csv.writer(bf)
        w.writerow([pk, column])
        for r in rows:
            w.writerow([r[pk], r[column]])
    print(f'Backed up {len(rows)} rows to {backup_file}')
    updated=0
    for r in rows:
        orig = r[column]
        if orig is None:
            continue
        fixed = ftfy.fix_text(orig)
        if fixed != orig:
            cur.execute(f"UPDATE `{table}` SET `{column}`=%s WHERE `{pk}`=%s", (fixed, r[pk]))
            updated+=1
    conn.commit()
    conn.close()
    print(f'Updated {updated} rows in {table}.{column}')

if __name__=='__main__':
    if len(sys.argv)<3:
        print('Usage: fix_single_column.py table column [pk]')
        sys.exit(1)
    tbl = sys.argv[1]
    col = sys.argv[2]
    pk = sys.argv[3] if len(sys.argv)>3 else 'id'
    fix_column(tbl,col,pk)
