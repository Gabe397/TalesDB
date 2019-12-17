<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

session_start();
if (isset($_SESSION['user'])) {
  //Let it run
}
else {
  header("Location: login.html");
}
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('192.168.1.160', 5672, 'gabe', 'gabe');
$channel = $connection->channel();
$result = ($channel->basic_get('profileReply',true,null)->body);

if(isset($result)){
  $result_array = preg_split ("/\,/", $result);
  $noQuote = array((count($result_array)-1)=> rtrim(end($result_array), '"'));
  $favorites = array_replace($result_array, $noQuote);
}
else {
  echo "Nothing received.";

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dark.css">
</head>
<script>
function showFavorites(){
var followers = <?php echo json_encode($favorites); ?> ;
var indexFriend = 0;
var every3rd = 0;
  for (indexFriend; indexFriend < followers.length; indexFriend++) {
    if (every3rd == 3)
    {
      document.getElementById('favs').innerHTML += "<button class='btn btn-secondary btn-sm' id='followerBtn' name='Recipe' value="  +followers[indexFriend -1]+ ">Recipe</button><br /><br />";
      document.getElementById('favs').innerHTML += "<img src='" + followers[indexFriend] + "' width=50% height=50%> <br />";
      every3rd = 0;
    }
    else {
    document.getElementById('favs').innerHTML += followers[indexFriend]+ "<br />";
    every3rd ++;
  }
  }
 }
</script>



  <body onload="showFavorites()">
    <div class="login-dark">
        <form action="userLoader.php" method="post">
            <h5>Profile Page</h5>
            <h3><?php echo $_SESSION['user'][1], " ",$_SESSION['user'][2] ?> </h3>
            <h4>Living within <?php echo $_SESSION['user'][3]?> </h4>
            <div class="form-group"><button class="btn btn-primary btn-block"id="btn"name="Friends">MySpace Top 5</button>
            <div class="form-group"><span id="favs"></span>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
