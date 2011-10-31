<?php
	ob_start();
	include 'mysql_settings_read.php';
	$index_file="index.php";

	$myusername = $_POST['username'];
	$mypassword = $_POST['password'];
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);

	//retrieve salt
  $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
	$sql = "SELECT salt FROM users WHERE username=?";
  if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s",$myusername);
    $stmt->execute();
    $stmt->bind_result($salt);
    while($stmt->fetch()) {
      //remove this comment
    }
  }
	
  //encrypt using sha256 and an encrypted salt
	$encrypted_mypassword = hash('sha256',$mypassword.$salt);
  
  
  $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
	$sql = "SELECT COUNT(*) as count FROM users WHERE username=? and password=?";
  if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ss",$myusername,$encrypted_mypassword);
    $stmt->execute();
    $stmt->bind_result($count);
    while($stmt->fetch()) {
      //remove this comment
    }
  }
	
  if($count==1) {
		session_start();
		$_SESSION['myusername'] = $myusername;
		$_SESSION['logged_in'] = 1;
		header("location:index.php");
	}
	else {
	echo "failed";
		#header("location:login_failed.php");
	}
ob_end_flush();

?>
