<?php

	$lifetime = 15 * 60;
	$path = "/labs/lab6";
	$domain = "madhavans1.com";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
	session_start();
	 
	if (isset($_POST["username"]) and isset($_POST["password"]) ){   
	if (securechecklogin($_POST["username"],$_POST["password"])) {
		$_SESSION["logged"]=TRUE;
		$_SESSION["username"]=$_POST["username"];
		$_SESSION["browser"]=$_SERVER["HTTP_USER_AGENT"];
	//if (checklogin($_POST["username"],$_POST["password"])) {
	
	}else{
		echo "<script>alert('Invalid username/password');</script>";
		unset($_SESSION["logged"]);
		header("Refresh:0; url=form.php");
		die();
	}
}
	if (!isset($_SESSION["logged"]) or $_SESSION["logged"] != TRUE){
	echo "<script>alert('You have not login. PLease login first');</script>";
	header("Refresh:0; url=form.php");
	die();	
	}

	if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
	echo "<script>alert('Session hijacking is detected!');</script>";
	header("Refresh:0; url=form.php");
	die();
	}

?>
	<h2> Welcome <?php echo htmlentities ($_SESSION['username']); ?> !</h2>
	<a href="changepasswordform.php">Change Password</a> | <a href="logout.php">Logout</a>
<?php
  	function securechecklogin($username, $password) {
			$mysqli = new mysqli('localhost','madhavans1','***','secad_s19');		
		if ($mysqli->connect_errno){
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			exit();
		}

		$prepared_sql = "SELECT * FROM users WHERE username= ?" ." AND password=password(?);";
		//echo "DEBUG>sql= $sql";

		if(!$stmt = $mysqli->prepare($prepared_sql))
			echo "Prepared Statement error";
		$stmt->bind_param("ss", $username,$password);
		if(!$stmt->execute()) echo "Execute error";
		if(!$stmt->store_result()) echo "store_result error";
		$result = $stmt;
		if($result->num_rows ==1) 
			return TRUE;

		return FALSE;
  	}
?>
