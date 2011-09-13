<?php
	ob_start();
	include 'mysql_settings.php';
	$index_file="index.php";

	$myusername = $_POST['username'];
	$mypassword = $_POST['password'];
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);

	//retrieve salt
	$sql = "SELECT salt FROM users WHERE username='$myusername'";
	$result = mysql_query($sql);
	if($result) {
		while($row = mysql_fetch_array($result)) {
			$salt = $row['salt'];
		}
	}
	//encrypt using sha256 and an encrypted salt
	$encrypted_mypassword = hash('sha256',$mypassword.$salt);

	$sql = "SELECT * FROM users WHERE username='$myusername' and password='$encrypted_mypassword'";
	$result = mysql_query($sql);

	$count=mysql_num_rows($result);
	//echo $count;
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
