import mysql.connector
from better_profanity import profanity
import time

mydb = mysql.connector.connect(host='localhost',database='hajduk_app',user='hajduk',password='vHgpUvwR*,;uS>')

mycursor = mydb.cursor()

a = 25

should_restart = True
while should_restart:
    should_restart: False
    a+=1
    sql = f'SELECT bio FROM users WHERE id = {a}'
    mycursor.execute(sql)
    myresult = mycursor.fetchall()
    if not myresult:
        quit()
    else:
        for x in myresult:
            censored_text = profanity.censor(x[0])
            mycursor = mydb.cursor()
            sql = f"UPDATE users SET bio = '{censored_text}' WHERE id = '{a}'"
            mycursor.execute(sql)
            mydb.commit()
        should_restart = True