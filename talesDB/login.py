import sqlCommands
import pika
import json

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='login',passive=False,durable=True)


def callback(ch, method, properties, body):    
    user = body.split(':')
    results = sqlCommands.auth(user[0],user[1])
    
    if results == False:
        channel.basic_publish(exchange='',
                              routing_key='loginReply',
                              body='Failed')
    
    else:
        bar = sqlCommands.getUser(user[0])
        emptyStr = ''
        for word in bar:
           emptyStr =  emptyStr +',' + word
            
        channel.basic_publish(exchange='',
                              routing_key='loginReply',
                              body=json.dumps(emptyStr))
                              
        print(emptyStr)
    

    
channel.basic_consume(
        queue='login',
        on_message_callback=callback,
        auto_ack=True)

print("Waiting for messages")

channel.start_consuming()
connection.close()
