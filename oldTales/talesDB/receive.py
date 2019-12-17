import pika 
import sqlCommands
import sys

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))

channel = connection.channel()

channel.queue_declare(queue='hello')

def callback(ch,method,properties,body):
    #print("[x] Received %r" % body)
    user = body.split(':')
    results = sqlCommands.auth(user[0],user[1])
    if results == True:
        import send
    else:
        import failSend

channel.basic_get(queue='hello',      
		  callback,
		  auto_ack=True
		  )

print(' [*] Waiting for messages. To exit press CTRL+C')


channel.start_consuming()


