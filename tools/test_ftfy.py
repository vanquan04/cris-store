import pymysql, ftfy
conn = pymysql.connect(host='127.0.0.1', user='root', password='', db='devchampion', charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor)
with conn.cursor() as cur:
    cur.execute("SELECT content_demo FROM blogs WHERE id=10")
    s = cur.fetchone()['content_demo']
    print('FTFY.fix_encoding:')
    print(ftfy.fix_encoding(s)[:400])
    print('\nFTFY.fix_text:')
    print(ftfy.fix_text(s)[:400])
conn.close()
