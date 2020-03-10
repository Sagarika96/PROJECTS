<?php
	require "database.php";
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$emailid = $_POST["emailid"];
	$phoneno = $_POST["phoneno"];

	if(!validateUsername($username) or !validatePassword($password)){

		echo "TODO:error";
		die();
	}
	//echo "DEBUG>addnewuser.php>username= $username;password=$password\n";

	if(addnewuser($username,$password,$emailid,$phoneno)){
		echo "DEBUG>addnewuser.php>$username is added\n";
		//todo: have a nice message
	}else{
		echo "DEBUG>addnewuser.php>$username cannot be added\n";
	}

	function validateUsername($username)
	{
		//todo: validate username

		return TRUE;
		//m_returnstatus(conn, identifier)
	}

	function validatePassword($password)
	{
		//todo: validate password

		return TRUE;

	}

	

	function validateEmail($emailid)
	{
		//todo: validate Phone

		return TRUE;

	}

	function validatePhone($phoneno)
	{
		//todo: validate Email

		return TRUE;

	}

?>
<br>
<br>
<a href="form.php">Go to Login Page</a>

