import sqlCommands
import pika
import os

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))

channel = connection.channel()

channel.queue_declare(queue='User',passive=False,durable=True)


def callback(ch, method, properties, body):
    user = body.split(':')
    results = sqlCommands.insertUser(user[0],user[1],user[2],user[3])
    print("User Created")

channel.basic_consume(
    queue='User', on_message_callback=callback, auto_ack=True)

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()


connection.close()

