import mysql.connector
import smtplib
from better_profanity import profanity
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import time

mydb = mysql.connector.connect(host='localhost',database='hajduk_app',user='hajduk',password='vHgpUvwR*,;uS>')

fromaddr = "reports@sportm4te.com"
toaddr = "reports@sportm4te.com"
msg = MIMEMultipart()
msg['From'] = fromaddr
msg['To'] = toaddr
msg['Subject'] = "New text was censured"

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
            non_censured = x[0]
            censored_text = profanity.censor(x[0])
            if non_censured != censored_text:
                body = f'Non censured text: {non_censured}. Censured text: {censored_text}'
                msg.attach(MIMEText(body, 'plain'))
                server = smtplib.SMTP('smtps.platon.sk', 587)
                server.ehlo()
                server.starttls()
                server.ehlo()
                server.login('no-reply@sportm4te.com', '4Xv!h?t<#{mTvK')
                text = msg.as_string()
                server.sendmail(fromaddr, toaddr, text)
                mycursor = mydb.cursor()
                sql = f"UPDATE users SET bio = '{censored_text}' WHERE id = '{a}'"
                mycursor.execute(sql)
                mydb.commit()
                should_restart = True
            else:
                should_restart = True