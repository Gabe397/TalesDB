<?php
session_start();
if (isset($_SESSION['user'])) {
  //Let it run
}
 else {
  header("Location: login.html");
}


if($_POST['logout']) {
  session_destroy();
  echo "Logging out, see you next time!";
  header("Refresh: 5; url=login.html");
}
if($_POST['quiz']) {
  header("Location: talesQuiz.php");
}

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();

if($_POST['profile']) {
  $channel->queue_declare('profile', false, true, false, false);
  $msg = new AMQPMessage("{$_SESSION['user'][0]}");
  $channel->basic_publish($msg, '', 'profile');
  echo "Going to profile page";
  header("Refresh: 3; url=userPage.php");
}

if($_POST['planner']) {
  $channel->queue_declare('alcoholic', false, true, false, false);
  $msg = new AMQPMessage("{$_SESSION['user'][3]}");
  $channel->basic_publish($msg, '', 'alcoholic');
  echo " [x] Sent {$_SESSION['user'][3]}\n";
  header("Refresh: 3; url=showPlan.php");
}
if($_POST['pop']) {
  $channel->queue_declare('popular', false, true, false, false);
  $msg = new AMQPMessage("{$_SESSION['user'][3]}");
  $channel->basic_publish($msg, '', 'popular');
  echo " [x] Sent {$_SESSION['user'][3]}\n";
  header("Refresh: 3; url=showPop.php");
}

$channel->close();
$connection->close();
?>
