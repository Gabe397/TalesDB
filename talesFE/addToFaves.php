<?php
session_start();
if (isset($_SESSION['user'])) {
  //Print out the Session array
  // foreach($_SESSION['user'] as $productId){
  //       echo $productId, '<br>';
  //     }
} else {
  header("Location: login.html");
}

$alc = $_POST['drinkRating'];

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


// 
// $connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
// $channel = $connection->channel();
// $channel->queue_declare('favorite', false, true, false, false);
// $msg = new AMQPMessage("{$alc}");
// $channel->basic_publish($msg, '', 'favorite');
// header("Refresh: 5; url=talesQuiz.php");
// echo " [x] Sent {$alc}\n";
// $channel->close();
// $connection->close();

?>
