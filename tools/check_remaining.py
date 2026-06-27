import pymysql
patterns = [
    ('blogs', 'content'),
    ('blogs', 'content_demo'),
    ('cat_blogs', 'name'),
    ('chat_messages', 'content'),
    ('configs', 'name'),
    ('orders', 'fullname'),
    ('orders', 'note'),
    ('permissions', 'name'),
    ('roles', 'description'),
    ('users', 'name'),
]
conn = pymysql.connect(host='127.0.0.1', user='root', password='', db='devchampion', charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
cur = conn.cursor()
for table, col in patterns:
    cur.execute(f"SELECT COUNT(*) AS cnt FROM `{table}` WHERE `{col}` REGEXP %s", ('[ÃÂ├┬ßÇÕÓÌÏÐ]',))
    print(f'{table}.{col}:', cur.fetchone()['cnt'])
conn.close()
