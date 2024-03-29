import sqlCommands
import pika
import json

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='profile',passive=False,durable=True)


def callback(ch, method, properties, body):
    user = body.split(':')
    results = sqlCommands.getFavorite(user[0])


    channel.basic_publish(exchange='',
                        routing_key='profileReply',
                        body=results)


    print('Something Happened')

channel.basic_consume(
        queue='profile',
        on_message_callback=callback,
        auto_ack=True)

print("Waiting for messages")

channel.start_consuming()
connection.close()
