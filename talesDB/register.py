import sqlCommands
import pika

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='Register',passive=False,durable=True)

body = channel.basic_get('Register',auto_ack=True)


channel.start_consuming()

if body != (None, None, None):
    user = body[-1].split(':')
    results = sqlCommands.insertLog(user[0],user[1],user[2])
    if results == True:
        import registerSuccess
    else:
        import registerFailed


connection.close()
