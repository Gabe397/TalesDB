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
$result = ($channel->basic_get('alcoholicReply',true,null)->body);

$result_array = preg_split ("/\,/", $result);
$noQuote = array((count($result_array)-1)=> rtrim(end($result_array), '"'));
$drinks = array_replace($result_array, $noQuote);

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dark.css">

    <script>
  function showDrinks(){
  var drinks = <?php echo json_encode($drinks); ?> ;
  var session = <?php echo json_encode($_SESSION['user']); ?> ;
  var every3rd = 1;
    for (var indexDrink = 2; indexDrink < drinks.length; indexDrink++) {
      if (every3rd == 3)
      {
        //document.getElementById('quizDrinks').innerHTML += "<select class='selectpicker' name='drinkRating'><option value=':5'>5 Stars</option><option value=':4'>4 Stars</option><option value=':3'>3 Stars</option><option value=':2'>2 Stars</option><option value=':1'>1 Stars</option>"
        document.getElementById('quizDrinks').innerHTML += "<button class='btn btn-secondary btn-sm' id='followerBtn' name='fav' value="  +  drinks[indexDrink ] + ">Favorite</button><br /><br />";
        document.getElementById('quizDrinks').innerHTML += "<img src='" + drinks[indexDrink] + "' width=25% height=25%> <br />";
        every3rd = 1;
      }

      else{
    document.getElementById('quizDrinks').innerHTML += drinks[indexDrink]+ "<br />";
    every3rd ++;
      }
      }
    }
      </script>
      <style>.login-dark form {max-width: 920px;}</style>
</head>

<body onload="showDrinks()">
    <div class="login-dark">
        <form action="addToFaves.php" method="post">
            <h5>Drink's List</h5>
            <p><span id="quizDrinks"</p>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
