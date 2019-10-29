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
    <title>Tales Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dark.css">

    <!-- <style> #liq { display: none; } </style> -->
</head>

<body>
    <div class="login-dark">
        <form action="sendQuiz.php" method="post">
            <h2 class="sr-only">Tales Quiz</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group"><input type="radio" id="alcoholic" name="alcselect" value="alcoholic"><label for="alc1">Alcohol</label><br>
            <!-- <div class="form-group"><input type="radio" id="nonalcoholic" name="alcselect" value="nonalcoholic"><label for="alc2">Non-Alcoholic</label><br> -->

            <div class="form-group" id="cat"><select name="category">
              <option value="Ordinary_Drink,">Ordinary Drink</option>
              <option value="Cocktail,">Cocktail</option>
              <!-- <option value="Milk_/_Float_/_Shake,">Milk / Float / Shake</option>
              <option value="Cocoa,">Cocoa</option> -->
              <option value="Shot,">Shot</option>
              <!-- <option value="Coffee_/_Tea,">Coffe / Tea</option> -->
              <option value="Homemade_Liqueur,">Homemade Liqueur</option>
              <option value="Beer,">Beer</option>
              <!-- <option value="Soft_Drink_/_Soda,">Soft Drink / Soda</option> -->
            </select>
          </div>
            <div class="form-group" id="liq"><select name="primaryliq">
              <option disabled selected value> -- Pick Your Poison -- </option>
              <option value="rum,">Rum</option>
              <option value="whisky,">Whisky</option>
              <option value="vodka,">Vodka</option>
              <option value="tequila,">Tequila</option>
              <option value="gin,">Gin</option>
            </select>
          </div>
            <div class="form-group"><input class="form-control" type="ingredients" name="ingredients" placeholder="Ingredients"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" id="btn" name="Submit">Submit</button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<script>
    // $('#alcoholic').click(function() {
    //     $('#liq').show();
    // })
    //
    // $('#nonalcoholic').click(function() {
    //     $('#liq').hide();
    // })
</script>
