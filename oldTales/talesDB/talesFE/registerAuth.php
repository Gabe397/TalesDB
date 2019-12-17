<?php
	//ini_set('display_errors', 1);
	ini_set('log_errors',1);
	ini_set('error_log', dirname(__FILE__) . '/login_auth.log');
	error_reporting(E_ALL);

	//session_start();
	include('testRabbitMQClient.php');

	$email = $_POST['email'];
	$password = $_POST['password'];
	echo $response
	//$response = loginAuth($email, $password);
  ?>
