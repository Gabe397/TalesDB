<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

session_start();
if (isset($_SESSION['user'])) {
  //Let it run
} else {
  header("Location: login.html");
}

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

if($_POST['fname']) {

  $follower = $_POST['fname'];


  $connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
  $channel = $connection->channel();
  $channel->queue_declare('newFriends', false, true, false, false);
  $msg = new AMQPMessage("{$_SESSION['user'][0]}:{$follower}");
  $channel->basic_publish($msg, '', 'newFriends');
  echo " [x] Sent {$_SESSION['user'][0]} & {$follower}\n";
  header("Refresh: 3; url=receiveFriends.php");
  $channel->close();
  $connection->close();
}

if($_POST['followerBtn']) {

  $followPage = $_POST['followerBtn'];

  $connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
  $channel = $connection->channel();
  $channel->queue_declare('friendsP', false, true, false, false);
  $msg = new AMQPMessage("{$followPage}");
  $channel->basic_publish($msg, '', 'friendsP');
  echo " [x] Sent {$followPage}\n";
  header("Refresh: 3; url=followProfile.php");
  $channel->close();
  $connection->close();
}

?>
