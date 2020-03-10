<?php
    require "session_auth.php";
    require 'database.php';
    $nocsrftoken = $_REQUEST["nocsrftoken"];


  	$username= $_SESSION["username"]; //$_REQUEST["username"];
	$newpassword = $_REQUEST["newpassword"];

    if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken']))
    {
      echo "<script>alert('Cross-site request forgery is detected!');</script>";
      header("Refresh:0; url=logout.php");
      die();
    }

  if(isset($username) AND isset($newpassword)) {
    echo "DEBUG:changepassword.php->Got: username=$username; newpassword=$newpassword;";
    if(changepassword($username,$newpassword)){
      echo "<h4>The new password has been set.</h4>";
    }else
    {
      echo "<h4>Error: cannot change the password.</h4>";
    }
  }
  else{
    echo "No provided username/password to change";
    exit();
  }
?>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>

