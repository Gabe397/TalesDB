import mysql.connector
import datetime

def insertLog(email,passwd):
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
        insql = "INSERT INTO logs (email, password) VALUES(%s,%s)"
        val = (email,passwd)

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

        cnx.close()
        
        return False

    
    else:
        print("You're connected")
        f.write(email + " Successfuly Connected" + str(datetime.datetime.now()) + "\r\n")
        f.close()
        cnx.close()
        return True
    

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

def insertUser(email,fname,lname,zipcode):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')
    dbCursor = cnx.cursor()

    insql = "INSERT INTO user (email, firstname,lastname,residence) VALUES(%s,%s,%s,%s)"
    val = (email,fname,lname,zipcode)

    f = open("userLogs.txt","a+")

    f.write(email + " User Created " + str(datetime.datetime.now()) + " \r\n")
    
    f.close()
    dbCursor.execute(insql,val)

    cnx.commit()

    return "UserCreated"

def getUser(email):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    sql = """SELECT * FROM user WHERE email = '%s'  """ %(email)
    
    dbCursor = cnx.cursor()

    dbCursor.execute(sql)

    myresult = dbCursor.fetchall()

    returnArray = []

    for x in range(len(myresult[0])):
        returnArray.append(myresult[0][x].encode('utf-8'))
    
    del returnArray[0]
    return returnArray


    cnx.close()


def addFriend(cemail,femail):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    dbCursor = cnx.cursor()

    chksql  = """SELECT * FROM friends WHERE userEmail = '%s' AND friendEmail = '%s' """ %(cemail,femail)

    dbCursor.execute(chksql)

    myresult = dbCursor.fetchall()

    chksql2 =  """SELECT * FROM user WHERE email = '%s' """ %(femail)
    dbCursor.execute(chksql2)

    myresult2 = dbCursor.fetchall()

    if len(myresult) == 0 and len(myresult2) == 1:
        insql = "INSERT INTO friends (userEmail,friendEmail) VALUES(%s,%s)"
        val = (cemail,femail)
        dbCursor.execute(insql,val)
        cnx.commit()

    else:
        return False

    cnx.close()

def getFriend(email):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    dbCursor = cnx.cursor()

    sql = """SELECT * FROM friends WHERE userEmail = '%s' """ %(email)

    dbCursor.execute(sql)

    myresult = dbCursor.fetchall()

    returnArray = []
    friendArray = []

    for x in myresult:
        returnArray.append(x[2])

    for x in returnArray:
        friendArray.append(x.encode('utf-8'))    
    cnx.close()
    return friendArray

def getFavorite(email):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    dbCursor = cnx.cursor()

    sql = """SELECT drink,drinkID,pic,rating FROM fave WHERE email = '%s' """ %(email)

    dbCursor.execute(sql)

    myresult = dbCursor.fetchall()
    parsedArray=[]
    emptyStr = ''
    for x in myresult:
        for i in x:
            if isinstance(i,int):
                parsedArray.append(i)
            else:
                parsedArray.append(i.encode('utf-8'))

    for x in parsedArray:
        if  not isinstance(x,int):
            emptyStr = emptyStr + ',' + x
        else:
            emptyStr = emptyStr + ',' + str(x)
            
            

    return(emptyStr)
    
    cnx.close()
    

def addFavorite(email,lname,drink,drinkID,pic,rating):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    dbCursor = cnx.cursor()

    sql = """SELECT  drinkID FROM fave WHERE email = '%s' AND drinkID = '%s'""" %(email,drinkID)

    dbCursor.execute(sql)

    myresult = dbCursor.fetchall()

    if len(myresult) == 0:
        sql2 = "INSERT INTO fave (email,lname,drink,drinkID,pic,rating) VALUES(%s,%s,%s,%s,%s,%s)"
        val = (email,lname,drink,drinkID,pic,rating)
        dbCursor.execute(sql2,val)
        cnx.commit()
        cnx.close()
        return True
    else:
        print('Nothing Added')

def addLog(log,created):
    cnx = mysql.connector.connect(user='root',password='password',host='127.0.0.1',database ='logDB')

    dbCursor = cnx.cursor()

    insql = "INSERT INTO clogs(log,created) VALUES(%s,%s)"
    val = (log,created)

    dbCursor.execute(insql,val)

    cnx.commit()

