<?php
session_start();
?>
 
<?php

include 'mysql_settings.php';
$index_file="index.php";
$username = $_POST['myusername'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
if($_POST['security_answer']!='')
$_SESSION['security']=$_POST['security_answer'];
$error= 0;

$password = stripslashes($password);
$confirm_password = stripslashes($confirm_password);
$password = mysql_real_escape_string($password);
$confirm_password = mysql_real_escape_string($confirm_password);
//if(isset($_POST['submit'])){
$errors=0;
//$sql = "SELECT * FROM users WHERE (users.username='$_SESSION[myusername]')";
//$result = mysql_query($sql);
  //      if($result) {
//      while($row = mysql_fetch_array($result)) {
    //  $security_answer=$row['security_ans'];
  //                      }
    //                    }
echo "security answer session variable is".$_SESSION['security_answer'];
echo "security answer variable is".$_SESSION['security'];

if($_SESSION['security']!=$_SESSION['security_answer'])
    echo "<p> <a href= resetpw.php> Wrong security answer, click to go to reset page</a></p>";
else{?>
 <form action="" method="POST">
<p>Enter the new Password:<br />
<input type="password" name="password" value="" /></p>
<p>Confirm Password:<br />
<input type="password" name="confirm_password" value="" /></p>
<input type="submit" name="submit"/>   
<?php }
if($_SESSION['security']==$_SESSION['security_answer'] && isset($_POST['submit'])){
    
// echo "<p>Match</p>";
  //  $_SESSION['security_answer'] = $security_answer;
  
    if($password=='') {
  echo "<p>password can't be blank</p>";
  $errors=1;    
    }
if($confirm_password=='') {
  echo "<p>confirm password can't be blank</p>";
  $errors=2;    
    }
if($password!=$confirm_password) {
    echo "<p>passwords don't match</p>";
    $errors=3;
    }
        $salt = hash('sha256',date('c')); //date and time ISO format
        //encrypt using sha256 and an encrypted salt
        $password = hash('sha256',$password.$salt);
        if($errors==0) {
      //insert into database
      $sql = "update users set password='$password' , salt='$salt' where (users.username='$_SESSION[myusername]')";
        
      $result = mysql_query($sql);
                        echo $result;
      if($result) {
        echo "<p>successfully changed password</p>";
                                echo "<p><a href='index.php'>Click, to go back Home</a></p>";
      }
      else die('Invalid query: ' . mysql_error());//echo "failed to add user";
    }
    }



//generate salt, and encrypt it



        


?>
