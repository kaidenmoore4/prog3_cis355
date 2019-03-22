<?php
session_start();
require "database.php";

if ($_GET)
    $errorMessage = $_GET["errorMessage"];
else
    $errorMessage='';


if ($_POST){
    
    $username = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
	
    $pdo = Database::connect();
	
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO customer (name,email,password,mobile) values(?, ?, ?, ?)";
    $q = $pdo -> prepare($sql);
    $q -> execute(array($username, $email, $password, $mobile));
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM customer WHERE email = ? AND password = ? LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($email,$password));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    
    if ($data) {
        $_SESSION["username"] = $username;
        header("Location: customer.php");
    } else 
        header("Location: createAccount.php?errorMessage=Something went wrong. Please try again.");
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
	<form method="post">
	
					<label class="control-label">Name</label>
					<div class="controls">
						<input name="name" type="text"  placeholder="Name Me" required>
					</div>
						
					<label class="control-label">Email</label>
					<div class="controls">
						<input name="email" type="text"  placeholder="email@email.com" required>
					</div>
						
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password"  placeholder="******" required>
					</div>
						
					<label class="control-label">Mobile</label>
					<div class="controls">
						<input name="mobile" type="tel"  placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
					</div>
					
					<button type="submit" class="btn btn-success">Join</button>
					<a href='login.php' class="btn btn-warning">Back</a>


	</form>
</div>
</html>