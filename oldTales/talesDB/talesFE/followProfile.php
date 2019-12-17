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
$result = ($channel->basic_get('friendsReply',true,null)->body);

echo $result;
echo gettype($result);

$result_array = preg_split ("/\,/", $result);
$noQuote = array((count($result_array)-1)=> rtrim(end($result_array), '"'));
$followProfile = array_replace($result_array, $noQuote);

echo $followProfile[1];
echo gettype($followProfile);
$channel->close();
$connection->close();
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dark.css">

    <script>
    function showFollowing(){
    var followerInfo = <?php echo json_encode($followProfile); ?> ;
    document.getElementById('userName').innerHTML += followerInfo[1]+ " " +followerInfo[2];
    document.getElementById('zip').innerHTML += followerInfo[3];
     }
    </script>

</head>

<body onload="showFollowing()">
    <div class="login-dark">
      <form action="dashboard.php">
          <h2><span id="userName"></span></h2>
          <h3>Living within <span id="zip"></span></h3>
          <div class="form-group"><button class="btn btn-primary btn-block" id="btn" name="Friends">Go back to Dashboard</button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
