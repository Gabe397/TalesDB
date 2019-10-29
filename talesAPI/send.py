#!/usr/bin/env python
import pika 




credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))

channel = connection.channel()

channel.queue_declare(queue='hello',passive=False,durable=False)



channel.basic_publish(exchange='',
        			 routing_key='hello',
        			 body=var)


 

connection.close()

