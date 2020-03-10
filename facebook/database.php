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

  	function addnewuser($username, $password,$emailid,$phoneno) {
		global 	$mysqli;
		$prepared_sql = "INSERT INTO users VALUES (?,password(?),?,?);";
		echo "DEBUG:database.php>prepared_sql= $prepared_sql\n";

		if(!$stmt = $mysqli->prepare($prepared_sql)) return FALSE;
		$stmt->bind_param("ssss", $username,$password,$emailid,$phoneno);
		if(!$stmt->execute()) return FALSE;
		return TRUE;
  	}

function addnewpost($post){ 	
  		global 	$mysqli;
		$prepared_sql = "INSERT INTO posts (post) VALUES(?);";
		echo "post has been added!!";

		if(!$stmt = $mysqli->prepare($prepared_sql)) return FALSE;
		$stmt->bind_param("s",$post);
		if(!$stmt->execute()) return FALSE;
		return TRUE;
  	}

  	function show_addpost()
	{
	global $mysqli;
	$prepared_sql ="select postid, post from posts";
	if(!$stmt = $mysqli->prepare($prepared_sql)) {echo "Cannot prepare"; die();}
	if(!$stmt->execute()) {echo "Cannot execute"; die();}
	$postid = NULL; $post = NULL;
	if(!$stmt-> bind_result($postid, $post)) echo "binding failed";
	while($stmt->fetch()){
	echo "Postid: " . htmlentities($postid) . ". Content: " .
	htmlentities($post) . "<a href='edit_post.php?postid=$postid'> edit </a><br>";
	}
	
	}

	function updatepost($postid,$post) { 
	global $mysqli;
	   echo "Debug:Updatepost for Postid= $postid <br>";
	$prepared_sql = "UPDATE posts SET post=? WHERE postid=?;";

	if(!$stmt = $mysqli->prepare($prepared_sql))
	echo "Prepared statement error";
	$stmt->bind_param("si",htmlspecialchars($post),$postid);

	if(!$stmt->execute()) {echo "Execute Error"; return FALSE;}
	return TRUE;

}


function new_comment($owner,$comments){
	global $mysqli;
	$prepared_sql = "INSERT into comment (owner,comments) VALUES (?,?);";
	if(!$stmt = $mysqli->prepare($prepared_sql))
	echo "Prepared Statement Error";
	$stmt->bind_param("ss", htmlspecialchars($owner),
				  htmlspecialchars($comments))
				  if(!$stmt->execute()) {echo "Execute Error"; return FALSE;}
		return TRUE;
}


	?>


