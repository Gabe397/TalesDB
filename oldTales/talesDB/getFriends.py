import sqlCommands
import pika
import json

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='friends',passive=False,durable=True)


def callback(ch, method, properties, body):
    bar = sqlCommands.getFriend(body)
    emptyStr = ''
    for word in bar:
        emptyStr =  emptyStr +',' + word

    
    channel.basic_publish(exchange='',
                          routing_key='friendsReply',
                          body=json.dumps(emptyStr))


channel.basic_consume(
        queue='friends',
        on_message_callback=callback,
        auto_ack=True)

print("Waiting for messages")

channel.start_consuming()
connection.close()        
