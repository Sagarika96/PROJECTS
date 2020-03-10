<?php
	session_start();    
	if (securechecklogin($_POST["username"],$_POST["password"])) {
	//if (checklogin($_POST["username"],$_POST["password"])) {
?>
	<h2> Welcome <?php echo htmlentities ($_POST['username']); ?> !</h2>
<?php		
	}else{
		echo "<script>alert('Invalid username/password');</script>";
		die();
	}
	function checklogin($username, $password) {
		$mysqli = new mysqli('localhost','madhavans1','***','secad_s19');
		
		if ($mysqli->connect_errno){
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			exit();
		}
		$sql = "SELECT * FROM users WHERE username='" .$username ."' ";
		$sql =$sql . " AND password = password('" .$password . "') ";
		echo "DEBUG>sql= $sql";
		$result = $mysqli->query($sql);
		if($result ->num_rows ==1) {
			return TRUE;
		}
		return FALSE;
  	}

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
		if($result ->num_rows ==1) 
			return TRUE;
		return FALSE;
  	}
?>