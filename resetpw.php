<?php

        session_start();
  include 'mysql_settings.php';
//        $index_file="index.php";
               
$go = $_POST['go'];
if($go!=1) $form_method="resetpw.php";
else $form_method="newpswd.php";
echo "<form action='$form_method' method='post'>";


if($go == "1")
{
$_SESSION['myusername'] = $_POST['username'];
$sql = "SELECT * FROM users WHERE (users.username='$_SESSION[myusername]')";
	$result = mysql_query($sql);
        if($result) {
			while($row = mysql_fetch_array($result)) {
			$_SESSION['security_question']=$row['security_qts'];
                        $_SESSION['security_answer']=$row['security_ans'];
                        
		}
	} ?>
        <p>user:<br /><input type="text" name = "myusername " value = <?php echo $_SESSION['myusername'];?> />
        <p>Answer the security question below:<br />
            
<?php echo $_SESSION['security_question']; ?>
<input type="text" name="security_answer" value="" />

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

//echo $test;
//echo $row
?>
