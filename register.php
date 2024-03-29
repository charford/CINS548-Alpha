<h2>Register</h2>
<?php
error_reporting(0);
	if(isset($_POST['register'])) {
	include 'mysql_settings.php';
	//form was submitted, so lets process it//

		//retrieving data from POST
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$birth_month = $_POST['birth_month'];
		$birth_day = $_POST['birth_day'];
		$birth_year = $_POST['birth_year'];
		$email = $_POST['email'];
		$security_question = $_POST['security_question'];
		$security_answer = $_POST['security_answer'];
                $security_question1 = $_POST['security_question1'];
		$security_answer1 = $_POST['security_answer1'];
		$street_address = $_POST['street_address'];
		$zipcode = $_POST['zipcode'];
	//sanitize the data//

		//removing slashes
		$first_name = stripslashes($first_name);
		$last_name = stripslashes($last_name);
		$username = stripslashes($username);
		$password = stripslashes($password);
		$confirm_password = stripslashes($confirm_password);
		$birth_month = stripslashes($birth_month);
		$birth_day = stripslashes($birth_day);
		$birth_year = stripslashes($birth_year);
		$email = stripslashes($email);
		$security_question = stripslashes($security_question);
		$security_answer = stripslashes($security_answer);
                $security_question1 = stripslashes($security_question1);
		$security_answer1 = stripslashes($security_answer1);
		$street_address = stripslashes($street_address);
		$zipcode = stripslashes($zipcode);

		//removing escape strings for mysql
		$first_name = mysql_real_escape_string($first_name);
		$last_name = mysql_real_escape_string($last_name);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		$confirm_password = mysql_real_escape_string($confirm_password);
		$birth_month = mysql_real_escape_string($birth_month);
		$birth_day = mysql_real_escape_string($birth_day);
		$birth_year = mysql_real_escape_string($birth_year);
		$email = mysql_real_escape_string($email);
		$security_question = mysql_real_escape_string($security_question);
		$security_answer = mysql_real_escape_string($security_answer);
                $security_question1 = mysql_real_escape_string($security_question1);
		$security_answer1 = mysql_real_escape_string($security_answer1);
		$street_address = mysql_real_escape_string($street_address);
		$zipcode = mysql_real_escape_string($zipcode);
  
    $first_name = strip_tags($first_name);
    $last_name = strip_tags($last_name);
    $username = strip_tags($username);
    $birth_month = strip_tags($birth_month);
    $birth_day = strip_tags($birth_day);
    $birth_year = strip_tags($birth_year);
    $email = strip_tags($email);
    $security_question = strip_tags($security_question);
    $security_answer = strip_tags($security_answer);
    $security_question1 = strip_tags($security_question1);
    $security_answer1 = strip_tags($security_answer1);
    $street_address = strip_tags($street_address);
    $zipcode = strip_tags($zipcode);

		$bday=$birth_year."-".$birth_month."-".$birth_day;

	//validate form data//
    include 'validate.php';

		//generate salt, and encrypt it
		$salt = hash('sha256',date('U'));	//date and time ISO format

		//encrypt using sha256 and an encrypted salt
		$password = hash('sha256',$password.$salt);

		//echo "$password";

		if($errors==0) {
			//insert into database
      $mysqli = new mysqli('132.241.49.7',$admin_username,$admin_password,'cins548');
			$sql = "INSERT INTO users (username,password,salt,email,f_name,l_name,street_address,
                                 zipcode,security_qts,security_ans,security_qts1,security_ans1,bday,user_type) 
              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,'0')";
      if($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param("sssssssssssss",$username,$password,$salt,$email,$fist_name,$last_name,$street_address,
                          $zipcode,$security_question,$security_answer,$security_question1,$security_answer1,$bday);
        if($stmt->execute()) {
				  echo "<div id='info'>successfully added user</div>";
        }
			  else echo "failed to add user";
      }
		}
	}
?>
<form action="" method="POST">
<p>First name:<br />
<input type="text" name="first_name" value=""/></p>
<p>Last name:<br />
<input type="text" name="last_name" value="" /></p>
<p>Username:<br />
<input type="text" name="username" value="" /></p>
<p>Password:<br />
<input type="password" name="password" value="" /></p>
<p>Confirm Password:<br />
<input type="password" name="confirm_password" value="" /></p>
<p>Date of birth:<br />
<select name="birth_month">
<?php
	for($i=1; $i<13; $i++) {
		echo "<option value='$i'>$i</option>";
	}
?>
</select>
<select name="birth_day">
<?php
	for($i=1; $i<32; $i++) {
		echo "<option value='$i'>$i</option>";
	}
?>
</select>
<select name="birth_year">
<?php
	for($i=date('Y'); $i>1900; $i--) {
		echo "<option value='$i'>$i</option>";
	}
?>
</select>
</p>
<p>Email:<br />
<input type="text" name="email" value=""/></p>
<p>Street Address:<br />
<input type="text" name="street_address" value="" /></p>
<p>Zip code:<br />
<input type="text" name="zipcode" value="" /></p>
<p>First Security question:<br />
<input type="text" name="security_question" value="" /></p>
<p>Security answer:<br />
<input type="text" name="security_answer" value="" /></p>
<p>Second Security question:<br />
<input type="text" name="security_question1" value="" /></p>
<p>Security answer:<br />
<input type="text" name="security_answer1" value="" /></p>
<input type="submit" name="register" value="Register" /> <input type="reset" value="reset" />
</form>
