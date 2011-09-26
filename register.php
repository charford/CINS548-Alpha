<?php
error_reporting(-1);
	if(isset($_POST['register'])) {
	include 'mysql_settings.php';
	echo "register";
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
		$street_address = mysql_real_escape_string($street_address);

		$bday=$birth_year."-".$birth_month."-".$birth_day;

	//validate form data//
		$errors=0;
		if($first_name=='') {
			echo "<p>first_name can't be blank</p>";
			$errors=1;		
		}
		if($last_name=='') {
			echo "<p>last name can't be blank</p>";
			$errors=1;		
		}
		if($username=='') {
			echo "<p>username can't be blank</p>";
			$errors=1;		
		}
		if($password=='') {
			echo "<p>password can't be blank</p>";
			$errors=1;		
		}
		if($confirm_password=='') {
			echo "<p>confirm password can't be blank</p>";
			$errors=1;		
		}
		if($password!=$confirm_password) {
			echo "<p>passwords don't match</p>";
			$errors=1;
		}
		if($birth_month=='') {
			echo "<p>birth month can't be blank</p>";
			$errors=1;		
		}
		if($birth_day=='') {
			echo "<p>birth day can't be blank</p>";
			$errors=1;		
		}
		if($birth_year=='') {
			echo "<p>birth year can't be blank</p>";
			$errors=1;		
		}
		if($email=='') {
			echo "<p>email can't be blank</p>";
			$errors=1;		
		}
		if($security_question=='') {
			echo "<p>security question can't be blank</p>";
			$errors=1;		
		}
		if($security_answer=='') {
			echo "<p>security answer can't be blank</p>";
			$errors=1;		
		}
		
	
		//generate salt, and encrypt it
		$salt = hash('sha256',date('c'));	//date and time ISO format
	
		//encrypt using sha256 and an encrypted salt
		$password = hash('sha256',$password.$salt);

		//echo "$password";
		
		if($errors==0) {
			//insert into database
			$sql = "INSERT INTO users 
				VALUES ('$username','$password','$salt','$email','$f_name','$l_name','$bday','$street_address','$zipcode','$phone_number','0')";
			$result = mysql_query($sql);
			if($result) {
				echo "<p>successfully added user</p>";
			}
			else echo "failed to add user";
		}
	}
?>
<form action="" method="POST">
<p>Register below</p>
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
<p>Security question:<br />
<input type="text" name="security_question" value="" /></p>
<p>Security answer:<br />
<input type="text" name="security_answer" value="" /></p>
<input type="submit" name="register" value="Register" /> <input type="reset" value="reset" />
</form>
