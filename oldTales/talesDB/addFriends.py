import sqlCommands
import pika
import json

credentials = pika.PlainCredentials('gabe','gabe')
connection = pika.BlockingConnection(pika.ConnectionParameters('192.168.1.160',5672,'/',credentials))


channel = connection.channel()

channel.queue_declare(queue='newFriends',passive=False,durable=True)


def callback(ch, method, properties, body):
    user = body.split(':')
    results = sqlCommands.addFriend(user[0],user[1])
    bar = sqlCommands.getFriend(user[0])
    emptyStr = ''
    for word in bar:
        emptyStr =  emptyStr +',' + word

    if results == False:
       channel.basic_publish(exchange='',
                          routing_key='friendsReply',
                          body='User does not exist' + json.dumps((emptyStr)))
    else:
        channel.basic_publish(exchange='',
                          routing_key='friendsReply',
                          body=json.dumps(emptyStr))

    print('Friend Added')

channel.basic_consume(
        queue='newFriends',
        on_message_callback=callback,
        auto_ack=True)

print("Waiting for messages")

channel.start_consuming()
connection.close()
