<?php
session_start();
if (isset($_SESSION['user'])) {
  //Let it run
} else {
  header("Location: register.html");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dark.css">
</head>

<body>

  <div class="login-dark">
          <form action="sendAll.php" method="post">
              <h2 class="sr-only">Profile Setup</h2>
              <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
              <div class="form-group"><input class="form-control" type="firstName" name="firstName" placeholder="First Name"></div>
              <div class="form-group"><input class="form-control" type="lastName" name="lastName" placeholder="Last Name"></div>
              <div class="form-group"><input class="form-control" type="zipcode" name="zipcode" placeholder="Zip code"></div>
              <div class="form-group"><button class="btn btn-primary btn-block" id="btn">Finish Setup</button>
      </div>

</body>
</html>
