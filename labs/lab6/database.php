<?php

$mysqli = new mysqli('localhost','madhavans1','***','secad_s19');	
		if($mysqli->connect_errno) {
			printf("Connection Failed: %s\n",$mysqli->connect_error);
			exit();
		}
function changepassword($username, $newpassword) {
		global $mysqli;
		//echo "user: $username pass: $newpassword";
		$prepared_sql = "UPDATE users SET password=password(?) WHERE username=?;";
		echo "DEBUG>prepared_sql=$prepared_sql\n";

  		if(!$stmt = $mysqli->prepare($prepared_sql)) 
  			return FALSE;
		
		$stmt->bind_param("ss",$newpassword,$username);
		
		if(!$stmt->execute()) 
			return FALSE;
		
		return TRUE;
		
	}

function addnewuser($username, $newpassword) {
		global 	$mysqli;
		$prepared_sql = "INSERT INTO users VALUES (?,password(?));";
		echo "DEBUG:database.php>prepared_sql= $prepared_sql\n";

		if(!$stmt = $mysqli->prepare($prepared_sql)) return FALSE;
		$stmt->bind_param("ss", $username,$newpassword);
		if(!$stmt->execute()) return FALSE;
		return TRUE;
  	}


?>
?>
