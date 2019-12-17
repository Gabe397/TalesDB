<!DOCTYPE html>
<html>
<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
echo " [*] Authenticating \n";
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    var $i = body;
    header("Location: login.html");
};
// if(isset($i)) {
//   flush();
//   header("Location: login.html");
//   die('should have redirected by now');
// }
$channel->basic_consume('hello', '', false, true, false, false, $callback);
while ($channel->is_consuming()) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>


<head>
  <title>Waiting Room</title>
</head>
<h1>Here we are waiting for this php to work</h1>
</html>
