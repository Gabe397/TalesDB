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
$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$result = ($channel->basic_get('loginReply',true,null)->body);

$result_array = preg_split ("/\,/", $result);
$noQuote = array((count($result_array)-1)=> rtrim(end($result_array), '"'));
$final = array_replace($result_array, $noQuote);

if($result == 'Failed'){
  echo "Login error.";
  header("Refresh: 3; url=login.html");
}
else {
  array_push($_SESSION['user'], $final[1], $final[2], $final[3]);
  echo "\n", $_SESSION['user'][0];
  echo "\n", $_SESSION['user'][1];
  echo "\n", $_SESSION['user'][2];
  echo "\n", $_SESSION['user'][3];

  header("Refresh:3 ; url=dashboard.php");
}
$channel->close();
$connection->close();
?>
