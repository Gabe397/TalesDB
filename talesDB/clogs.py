import sqlCommands
import pika
import json

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='logs',passive=False,durable=True)


def callback(ch, method, properties, body):
    user = body.split(";")
    print user
    results = sqlCommands.addLog(user[0],user[-1])

    emptyStr = ''
    channel.basic_publish(exchange='',
                        routing_key='logss',
                        body=results)


    print('Logs Added')

channel.basic_consume(
        queue='logs',
        on_message_callback=callback,
        auto_ack=True)

print("Waiting for messages")

channel.start_consuming()
connection.close()
