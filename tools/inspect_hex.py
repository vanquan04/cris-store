import pymysql

conn = pymysql.connect(host='127.0.0.1', user='root', password='', db='devchampion', charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
cur = conn.cursor()
remaining = [
    ('blogs', 'content_demo'),
    ('cat_blogs', 'name'),
    ('chat_messages', 'content'),
    ('orders', 'fullname'),
    ('permissions', 'name'),
]
for table, col in remaining:
    print('===', table, col)
    cur.execute(f"SELECT id, HEX(`{col}`) AS hexvalue, `{col}` AS value FROM `{table}` WHERE `{col}` REGEXP %s LIMIT 20", ('[ÃÂ├┬ßÇÕÓÌÏÐ]',))
    rows = cur.fetchall()
    for r in rows:
        print('ID', r['id'], 'HEX', r['hexvalue'])
        print(r['value'])
        print()
conn.close()
