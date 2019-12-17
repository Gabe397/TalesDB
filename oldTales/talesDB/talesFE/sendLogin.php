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

$email = $_POST['email'];
$password = $_POST['password'];

$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$channel->queue_declare('login', false, true, false, false);
$msg = new AMQPMessage("{$email}:{$password}");
$channel->basic_publish($msg, '', 'login');
//echo " [x] Sent {$email} & {$password}\n";
header("Refresh: 4; url=receiveLogin.php");
$channel->close();
$connection->close();
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="style.css" />
<link href='https://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'/>
</head>
<body>
<div id="loader">
    <div id="lemon"></div>
    <div id="straw"></div>
    <div id="glass">
        <div id="cubes">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div id="drink"></div>
        <span id="counter"></span>
    </div>
    <div id="coaster"></div>
</div>

<footer>Please wait while we log you in...</footer>



<script>
var worker = null;
var loaded = 0;

function increment() {
    $('#counter').html(loaded+'%');
    $('#drink').css('top', (100-loaded*.9)+'%');
    if(loaded==25) $('#cubes div:nth-child(1)').fadeIn(100);
    if(loaded==50) $('#cubes div:nth-child(2)').fadeIn(100);
    if(loaded==75) $('#cubes div:nth-child(3)').fadeIn(100);
    if(loaded==100) {
        $('#lemon').fadeIn(100);
        $('#straw').fadeIn(300);
        loaded = 0;
        stopLoading();
        setTimeout(startLoading, 1000);
    }
    else loaded++;
}

function startLoading() {
    $('#lemon').hide();
    $('#straw').hide();
    $('#cubes div').hide();
    worker = setInterval(increment, 30);
}
function stopLoading() {
    clearInterval(worker);
}

startLoading();
</script>
</body>
</html>
