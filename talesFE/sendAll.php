<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

$first = $_POST['firstName'];
$last = $_POST['lastName'];
$zipcode = $_POST['zipcode'];

session_start();
if (isset($_SESSION['user'])) {
  array_push($_SESSION['user'], $first, $last, $zipcode);
} else {
  header("Location: register.html");
}

$conemail = $_SESSION['user'][0];

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$channel->queue_declare('User', false, true, false, false);
$msg = new AMQPMessage("{$conemail}:{$first}:{$last}:{$zipcode}");
$channel->basic_publish($msg, '', 'User');
echo "Registered {$conemail} for {$first} {$last} living within {$zipcode}.\n";
header("Refresh: 5; url=dashboard.php");
$channel->close();
$connection->close();
?>
