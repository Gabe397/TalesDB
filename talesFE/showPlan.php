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
$result = ($channel->basic_get('alcoholicReply',true,null)->body);

if(isset($result)){
  echo gettype($result);
}
else {
  echo "Nothing received.";
  header("Refresh: 3; url=dashboard.php");
}
#$channel->close();
#$connection->close();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan My Night</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dark.css">

    <script>
    function arrayFunction(){
    var nightplans = <?php echo $result; ?> ;
      var indexDrink = 5;
      for (var indexBar=0; indexBar < 5; indexBar++) {
        document.getElementById('planmynight').innerHTML += "<img src='" +nightplans[indexBar].image_url + "' width=25% height=25%> <br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].rating + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].review_count + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].name + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].url + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].price + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].display_phone + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[indexBar].location.display_address + "<br />";
        document.getElementById('planmynight').innerHTML += nightplans[5].drinks[indexBar].strDrink + "<br />";
      }
       // document.getElementById('planmynight').innerHTML += nightplans[5].drink0.values().strDrink[0] + "<br />";
       // document.getElementById('planmynight').innerHTML += nightplans[6].drink1.values("strDrink") + "<br />";
       // document.getElementById('planmynight').innerHTML += nightplans[7].drink2[0].strDrink + "<br />";
       // document.getElementById('planmynight').innerHTML += nightplans[8].drink3[0].strDrink + "<br />";
       // document.getElementById('planmynight').innerHTML += nightplans[9].drink4[0].strDrink  + "<br />";
    }
    </script>

    <style>.login-dark form {max-width: 920px;}</style>
</head>
<body onload="arrayFunction()">
    <div class="login-dark" id="quiz">
        <form action="sendReg.php" method="post">
            <h2 class="sr-only">Night Planned</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><span id="planmynight"></span>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
