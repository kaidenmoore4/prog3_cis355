<?php
session_start();
require "database.php";

if ($_GET)
    $errorMessage = $_GET["errorMessage"];
else
    $errorMessage='';

if($_POST){
	//$success = false;
	$username = $_POST['username'];
	$password = $_POST['password'];
	//$password = MD5($password);
	
	$pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = "SELECT * FROM customer WHERE email='$username' AND password ='$password' LIMIT 1";
    $q = $pdo -> prepare($sql);
    $q -> execute(array());
    $data = $q->fetch(PDO::FETCH_ASSOC);
	
	//print_r ($data); exit();
	
	if($data){
		$_SESSION["username"] = $username;
		header("Location: customer.php");
	}
	else{
		header("Location: login.php?errorMessage=Invalid");
		exit();
		
	}	
}

?>
<!DOCTYPE html>

<head>
      <meta charset='UTF-8'>
      <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
      <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
      <style>label {width: 5em;}</style>
</head>

<div class="container">
<h1>LOG IN</h1>
<form class="form-horizontal" action="login.php" method="post">

	    <input name="username" type="text" placeholder="me@email.com" required>
        <input name="password" type="password" placeholder="password" required>
        <button type="submit" class="btn btn-success">Sign In</button>
		<a href='signup.php' class="btn btn-info">Sign Up</a>
		<p style='color: red;'><?php echo $errorMessage; ?></p>

		
</form>

</div>

</html>