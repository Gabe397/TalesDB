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


if(isset($result)) {
  $result_array = preg_split ("/\,/", $result);
  $noQuote = array((count($result_array)-1)=> rtrim(end($result_array), '"'));
  $friends = array_replace($result_array, $noQuote);
  //echo gettype($friends);
} else {
  echo "Sorry, no friends yet :( ";
}

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
    var followers = <?php echo json_encode($friends); ?> ;
    var indexFriend = 1;
      for (indexFriend; indexFriend < followers.length; indexFriend++) {
        document.getElementById('followerBlock').innerHTML += followers[indexFriend] + "<button class='btn btn-secondary btn-sm' id='followerBtn' name='followerBtn' value="  +followers[indexFriend]+ ">Profile</button><br /><br />";
      }
     }
      </script>

</head>

<body onload="showFollowing()">
    <div class="login-dark">
        <form action="followerAction.php" method="post">
            <h5>Friends List</h5>
            <br>
            <span id="followerBlock"></span>
            <br><br>
            <div class="form-group">Add New Friends<input class="form-control" name="fname" id="fname" placeholder="Friends email"></div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
