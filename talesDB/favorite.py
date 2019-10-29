import sqlCommands
import pika
import json

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='favorite',passive=False,durable=True)


def callback(ch, method, properties, body):
    user = body.split(':')
    results = sqlCommands.addFavorite(user[0],user[1],user[2],user[3],user[4],int(user[5]))

    if results == True:
       channel.basic_publish(exchange='',
                          routing_key='favoriteReply',
                          body='Drink added to favorites')
    else:
        channel.basic_publish(exchange='',
                          routing_key='favoriteReply',
                          body='Drink already in favorites!')

    print('Something Happened')

channel.basic_consume(
        queue='favorite',
        on_message_callback=callback,
        auto_ack=True)

print("Waiting for messages")

channel.start_consuming()
connection.close()
