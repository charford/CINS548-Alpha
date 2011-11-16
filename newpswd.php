<?php
error_reporting(0);
session_start();
?>
 
<?php

include 'mysql_settings.php';
$index_file="index.php";
$thisusername = $_SESSION['myusername'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
if($_POST['security_answer']!='')
$sec=$_POST['security_answer'];
if($_POST['security_answer1']!='')
$sec1=$_POST['security_answer1'];
$error= 0;

$password = stripslashes($password);
$confirm_password = stripslashes($confirm_password);
$password = mysql_real_escape_string($password);
$confirm_password = mysql_real_escape_string($confirm_password);
$errors=0;

$mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
$sql = "SELECT security_ans,security_ans1 FROM users WHERE username = ?";
if($stmt = $mysqli->prepare($sql)) {
  $stmt->bind_param("s",$thisusername);
  $stmt->execute();
  $stmt->bind_result($sec_ans,$sec_ans1);
  while($stmt->fetch()) {
    //not sure i need anything here
  }
}
//can't find an answer, ERROR
else $errors=1;
 
if($sec!=$sec_ans|| $sec1!=$sec_ans1)
  $_SESSION['myusername'] = "";
  session_destroy();
  echo "<p> <a href= resetpw.php> Wrong security answer, click to go to reset page</a></p>";
else{?>

<form action="" method="POST">
<p>Enter the new Password:<br />
<input type="password" name="password" value="" /></p>
<p>Confirm Password:<br />
<input type="password" name="confirm_password" value="" /></p>
<input type="hidden" name="security_answer" value="<?php echo $sec; ?>" />
<input type="hidden" name="security_answer1" value="<?php echo $sec1; ?>" />
<input type="submit" name="submit"/>   

<?php }

if($sec==$sec_ans && isset($_POST['submit'])){
    
  
    if($password=='') {
 echo "<p>password can't be blank</p>";
	$errors=1;		
    }
if($confirm_password=='') {
	echo "<p>confirm password can't be blank</p>";
	$errors=2;		
    }
elseif (!preg_match("/^(?=^.{7,}$)((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.*$/", $password))
{
        echo "<div id='alert'>password must be at least 7 chars long with one lower-case, one upper-case char, and one digit</div>";
        $errors=1;
    }
if($password!=$confirm_password) {
    echo "<p>passwords don't match</p>";
    $errors=3;
    }
      $salt = hash('sha256',date('c'));	//date and time ISO format
      //encrypt using sha256 and an encrypted salt
      $password = hash('sha256',$password.$salt);
      if($errors==0) {
			//insert into database
      $mysqli = new mysqli('132.241.49.7',$admin_username,$admin_password,'cins548');
			$sql = "update users set password=? , salt=? where (users.username=?)";
      if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sss",$password,$salt,$thisusername);
        if($stmt->execute()) {
				  echo "<p>successfully changed password</p>";
          echo "<p><a href='index.php'>Click, to go back Home</a></p>";
        }
			  else echo "<p>failed to update password</p>";
      }
		}
  }
?>
