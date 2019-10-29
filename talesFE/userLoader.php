<?php
session_start();
if (isset($_SESSION['user'])) {
  //Let it run
}
 else {
  header("Location: login.html");
}


if($_POST['Friends']) {
  header("Location: friendsList.php");
}
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();

if($_POST['Recipe']) {
  $id = $_POST[Recipe];
  $channel->queue_declare('recipe', false, true, false, false);
  $msg = new AMQPMessage("{$id}");
  $channel->basic_publish($msg, '', 'recipe');
  header("Location: receiveRecipe.php");
}
