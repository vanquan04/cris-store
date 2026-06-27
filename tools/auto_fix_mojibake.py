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
MOJIBAKE_REGEX = re.compile(r'[ÃÂ├┬ßÇÕÓÌÏÐàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]')
BAD_PATTERN = re.compile(r'[ÃÂ├┬ßÇÕÓÌÏÐ]')
VIET_ACCENTS = re.compile(r'[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]', re.I)

CANDIDATE_FUNCS = []

def candidate_identity(s):
    return s

def candidate_ftfy_fix_text(s):
    return ftfy.fix_text(s)

def candidate_ftfy_fix_encoding(s):
    return ftfy.fix_encoding(s)

def candidate_latin1_to_utf8(s):
    try:
        return s.encode('latin1', errors='ignore').decode('utf-8', errors='ignore')
    except Exception:
        return s

def candidate_utf8bytes_to_latin1(s):
    try:
        return s.encode('utf-8', errors='surrogateescape').decode('latin1', errors='ignore')
    except Exception:
        return s

CANDIDATE_FUNCS = [
    ('identity', candidate_identity),
    ('ftfy.fix_text', candidate_ftfy_fix_text),
    ('ftfy.fix_encoding', candidate_ftfy_fix_encoding),
    ('latin1->utf8', candidate_latin1_to_utf8),
    ('utf8bytes->latin1', candidate_utf8bytes_to_latin1),
]


def score_text(text):
    bad = len(BAD_PATTERN.findall(text))
    accents = len(VIET_ACCENTS.findall(text))
    common = len(re.findall(r'\b(gi|đi|của|và|với|những|thành|nhóm|trên|dưới)\b', text, re.I))
    length = len(text)
    # Favor Vietnamese accent presence, penalize mojibake tokens, moderate length
    return accents * 5 + common * 10 - bad * 15 + min(length, 100)


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


def find_rows(conn, table, column, limit=2000):
    regex = r"[ÃÂ├┬ßÇÕÓÌÏÐ]"
    sql = f"SELECT `{table}`.`{column}` AS value, `{pk}` AS pk FROM `{table}` WHERE `{column}` REGEXP %s LIMIT %s"
    # will be formatted by caller
    pass


def process_text(conn, table, column, pk, dry_run=True, max_rows=2000):
    with conn.cursor() as cur:
        cur.execute(f"SELECT `{pk}`, `{column}` FROM `{table}` WHERE `{column}` REGEXP %s LIMIT %s", ('[ÃÂ├┬ßÇÕÓÌÏÐ]', max_rows))
        rows = cur.fetchall()
    results = []
    for row in rows:
        orig = row[column]
        if orig is None:
            continue
        candidates = []
        for name, func in CANDIDATE_FUNCS:
            try:
                cand = func(orig)
            except Exception:
                cand = orig
            if cand is None:
                cand = orig
            candidates.append((name, cand, score_text(cand)))
        best = max(candidates, key=lambda x: x[2])
        original_score = score_text(orig)
        if best[1] != orig and best[2] > original_score:
            results.append((row[pk], orig, best[0], best[1], original_score, best[2]))
    if dry_run:
        return results

    backup_dir = os.path.join('tools', 'backups')
    os.makedirs(backup_dir, exist_ok=True)
    backup_file = os.path.join(backup_dir, f'backup_{table}_{column}.csv')
    with open(backup_file, 'w', encoding='utf-8', newline='') as bf:
        writer = csv.writer(bf)
        writer.writerow([pk, column, 'method', 'orig', 'fixed', 'orig_score', 'new_score'])
        for pk_val, orig, method, fixed, orig_score, new_score in results:
            writer.writerow([pk_val, orig, fixed, method, orig_score, new_score])
    if results:
        with conn.cursor() as cur:
            for pk_val, orig, method, fixed, orig_score, new_score in results:
                cur.execute(f"UPDATE `{table}` SET `{column}`=%s WHERE `{pk}`=%s", (fixed, pk_val))
        conn.commit()
    return results


def run(dry_run=True):
    conn = pymysql.connect(host=DB_HOST, port=DB_PORT, user=DB_USER, password=DB_PASS, db=DB_NAME, charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
    cols = get_text_columns(conn)
    print(f'Found {len(cols)} text columns')
    total = 0
    summary = []
    for row in cols:
        table = row['TABLE_NAME']
        column = row['COLUMN_NAME']
        pk = get_primary_key(conn, table)
        if not pk:
            continue
        res = process_text(conn, table, column, pk, dry_run=dry_run)
        if res:
            print(f'Will fix {len(res)} rows in {table}.{column}')
            summary.append((table, column, len(res)))
            total += len(res)
    conn.close()
    print(f'Total candidate rows: {total}')
    return summary

if __name__ == '__main__':
    import argparse
    parser = argparse.ArgumentParser(description='Auto-fix mojibake text columns.')
    parser.add_argument('--apply', action='store_true', help='Apply changes rather than dry run')
    args = parser.parse_args()
    run(dry_run=not args.apply)
