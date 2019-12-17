<?php
session_start();
if (isset($_SESSION['user'])) {
  //Print out the Session array
  // foreach($_SESSION['user'] as $productId){
  //       echo $productId, '<br>';
  //     }
} else {
  header("Location: register.html");
}

$alc = $_POST['alcselect'];
$category = $_POST['category'];
$primaryliq = $_POST['primaryliq'];
$ingredients = $_POST['ingredients'];

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;



$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$channel->queue_declare('quiz', false, true, false, false);
$msg = new AMQPMessage("{$alc}:{$category}:{$primaryliq}:{$ingredients}");
$channel->basic_publish($msg, '', 'quiz');
header("Refresh: 120; url=receiveQuiz.php");
echo " [x] Sent {$alc},{$category},{$primaryliq},{$ingredients}\n";
$channel->close();
$connection->close();
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link type="text/css" rel="stylesheet" href="style2.css" />
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

<footer>Please wait while we find you a drink...</footer>



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
