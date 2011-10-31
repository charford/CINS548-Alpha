<?php

        session_start();
	include 'mysql_settings.php';
        $index_file="index.php";
               
$go = $_POST['go'];
if($go!=1) $form_method="resetpw.php";
else $form_method="newpswd.php";
echo "<form action='$form_method' method='post'>";


if($go == "1")
{
  $user=$_POST['username'];
  $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
  $sql = "SELECT security_qts,security_qts1,COUNT(*) as c FROM users WHERE username=?";
  if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s",$user);
    $stmt->execute();
    $stmt->bind_result($security_quest,$security_quest1,$count);
    while($stmt->fetch()) {
      //not sure I need anything here
    }
  }
        
	if($count==0) {
        	echo "<p><a href=resetpw.php>start again</a></p>";
		exit;
	}
  else $_SESSION['myusername'] = $user;
	?>
        <p>Answer the security questions below:<br />
            
<?php echo $security_quest; ?>
<input type="text" name="security_answer" value="" /><br/>
<?php echo $security_quest1; ?>
<input type="text" name="security_answer1" value="" />
<input type="hidden" name="user" value="<?php echo $user;?>">
<input type="submit" name="submitButtonName" border="0"></p>
<?php }
else
{
    ?>
    <p>Login below</p>
<p>Username:<br />
<input type="text" name="username" value="" /></p>
<input type="hidden" name="go" value="1" border="0"><input type="submit" name="submitButtonName" border="0">

    <?php
}
?>

<?php


?>
