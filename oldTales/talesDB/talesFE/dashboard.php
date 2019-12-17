<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

session_start();
if (isset($_SESSION['user'])) {
  //Print out the Session array
  // foreach($_SESSION['user'] as $productId){
  //       echo $productId, '<br>';
  //     }
} else {
  header("Location: login.html");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dashboardstyle.css">
</head>

<body>
    <div class="login-dark">
        <form action="sendDash.php" method="post">
            <h2>Welcome to Tales</h2>
            <div class="form-group"><button class="btn btn-primary btn-block" name="quiz" value="quiz">Take or Re-Take Quiz</button></div>
            <div class="form-group"><button class="btn btn-primary btn-block" name="planner" value="planner">Plan My Night</button></div>
            <div class="form-group"><button class="btn btn-primary btn-block" name="pop" value="pop">Popular Drinks</button></div>
            <div class="form-group"><button class="btn btn-primary btn-block" name="profile" value="profile">User Profile</button></div>
            <div class="form-group"><button class="btn btn-primary btn-block" name="logout" value="logout">Log Out</button></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
