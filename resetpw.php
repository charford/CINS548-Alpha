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
$sql = "SELECT * FROM users WHERE username='$user'";
	$result = mysql_query($sql);
        if(!$result) echo "<p><a href=resetpw.php> username not in database, start again</a></p>";
        
       else if($result) {
			while($row = mysql_fetch_array($result))
                            {
			    $security_quest=$row['security_qts'];
                            $sec_ans=$row['security_ans'];
                        
		}
	} ?>
        <p>user:<br /><input type="text" name = "myusername " value = "<?php echo $user;?>" />
        <p>Answer the security question below:<br />
            
<?php echo $security_quest; ?>
<input type="text" name="security_answer" value="" />
<input type="hidden" name="user" value="<?php echo $user;?>">
<input type="hidden" name="sec_ans" value="<?php echo $sec_ans;?>">
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
