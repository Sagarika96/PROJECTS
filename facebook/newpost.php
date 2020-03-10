<?php

require "database.php";

$post = $_POST["post"];

if(addnewpost($post)){
	echo "$post is added";
}else {
	echo "$post cannot be added";
}
?>
<br>
<a href="index.php">Go to Home</a>
