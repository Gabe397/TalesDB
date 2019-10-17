import pika
import sqlCommands

credentials = pika.PlainCredentials('gabe','gabe')

parameters = pika.ConnectionParameters('192.168.1.160',5672,'/',credentials)


connection = pika.BlockingConnection(parameters)

channel = connection.channel()

channel.queue_declare(queue='loginReply',passive=False,durable=True)


channel.basic_publish(exchange='',
                      routing_key='loginReply',
                      body='Connected')


print("You are Connected")

connection.close()
