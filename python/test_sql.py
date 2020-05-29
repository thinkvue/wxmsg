import pymysql

try:
    db = pymysql.connect("localhost", "root", "lijian83", "mitest")
    c = db.cursor()
    with open('thinkvue.sql',encoding='utf-8',mode='r') as f:
        sql_list = f.read().split(';\n')[:-1]
        for x in sql_list:
            if '\n' in x:
                x = x.replace('\n', ' ')
            if '    ' in x:
                x = x.replace('    ', '')
            sql_item = x+';'
            c.execute(sql_item)
            print("执行成功sql: %s"%sql_item)
except Exception as e:
    print('执行失败sql: %s'%sql_item)
    print(e)
finally:
    c.close()
    db.commit()
    db.close()