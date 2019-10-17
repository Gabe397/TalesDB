import mysql.connector
import datetime

def insertLog(email,passwd,zipcode):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    dbCursor = cnx.cursor()

    chksql = """SELECT * FROM logs WHERE email = '%s' AND password = '%s' """ %(email,passwd)
    chkemail = """SELECT * FROM logs WHERE email = '%s' """ %(email)

    dbCursor.execute(chksql)

    chkresult = dbCursor.fetchall()

    dbCursor.execute(chkemail)
    emailRes = dbCursor.fetchall()

    f = open("logging.txt","a+")

    if len(chkresult) == 0 and len(emailRes) == 0:
        insql = "INSERT INTO logs (email, password,zipcode) VALUES(%s,%s,%s)"
        val = (email,passwd,zipcode)

        dbCursor.execute(insql,val)

        cnx.commit()

        f.write(email + " Successfuly Registered" + str(datetime.datetime.now()) + "\r\n")
        f.close()

        print(dbCursor.rowcount, "Record Inserted")
        return True
        
    else:
        f.write(email + " Failed to Register" + str(datetime.datetime.now()) + "\r\n")
        f.close()
        print("Account Exists")
        return False

    cnx.close()

def auth(email,passwd):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    f = open("logging.txt","a+")

    dbCursor = cnx.cursor()

    sql = """SELECT * FROM logs WHERE email = '%s' AND password = '%s' """ %(email,passwd)

    dbCursor.execute(sql)

    myresult = dbCursor.fetchall()

    if len(myresult) == 0:
        f.write(email + " Failed to Connect " + str(datetime.datetime.now()) + " \r\n")
        f.close()
        f.close()

        disconnect(cnx)
        
        return False;

    
    elif len(myresult) == 1:
        print("You're connected")
        f.write(email + " Successfuly Connected" + str(datetime.datetime.now()) + "\r\n")
        f.close()
 
        disconnect(cnx)
        return True;
    

def getLog(email,passwd):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')
    dbCursor = cnx.cursor()

    sql = """SELECT * FROM logs WHERE email = '%s' AND password = '%s' """ %(email,passwd)

    dbCursor.execute(sql)

    myresult = dbCursor.fetchall()

    if len(myresult) == 0:
        print("No Result")

    elif len(myresult) == 1:
        print(myresult)

    cnx.close()

def disconnect(cnx):
    cnx.close()

def connect():
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')
    return cnx
