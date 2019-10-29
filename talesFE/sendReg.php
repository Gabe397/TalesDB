<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

$email = $_POST['email'];
$password = $_POST['password'];

session_start();
if (isset($_POST['Submit'])) {
  $session_arry = array($email);
  $_SESSION['user'] = $session_arry;
}

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// $email = $_POST['email'];
// $password = $_POST['password'];

$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$channel->queue_declare('Register', false, true, false, false);
$msg = new AMQPMessage("{$email}:{$password}");
$channel->basic_publish($msg, '', 'Register');
echo " [x] Sent {$email} & {$password}\n";
header("Refresh: 3; url=receive.php");
$channel->close();
$connection->close();
?>
