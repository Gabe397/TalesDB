<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

session_start();
if (isset($_SESSION['user'])) {
  //Let it run
} else {
  header("Location: register.html");
}

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$result = ($channel->basic_get('registerReply',true,null)->body);
// // echo $result;
//echo gettype($result);
if($result == 'Success'){
  header("Refresh: 0; url=home.php");
}
else {
  echo "Registration error.";
  header("Refresh: 3; url=register.html");
}
#$channel->close();
#$connection->close();
?>
