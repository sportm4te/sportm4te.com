import mysql.connector
from better_profanity import profanity
import time

mydb = mysql.connector.connect(host='localhost',database='hajduk_app',user='hajduk',password='vHgpUvwR*,;uS>')

mycursor = mydb.cursor()

a = 0

should_restart = True
while should_restart:
    should_restart: False
    a+=1
    sql = f'SELECT name FROM event WHERE id = {a}'
    mycursor.execute(sql)
    myresult = mycursor.fetchall()
    if not myresult:
        print("Not found")
        quit()
    else:
        print("Result found")
        for x in myresult:
            censored_text = profanity.censor(x[0])
            mycursor = mydb.cursor()
            sql = f"UPDATE event SET name = '{censored_text}' WHERE id = '{a}'"
            mycursor.execute(sql)
            mydb.commit()
        should_restart = True

