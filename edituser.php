Edit My User Info</p>
<?php
  //edit user information here. below, we get info from database
  //based on the current user logged in
  if($logged_in==1) {
    if(isset($_POST['editusersubmit'])) {
      
      include 'mysql_settings.php';
      //form was submitted, lets update the database
      $username = $_SESSION['myusername'];
      $f_name = $_POST['first_name'];
      $l_name = $_POST['last_name'];
      $email = $_POST['email'];
      $street_address = $_POST['street_address'];
      $zipcode = $_POST['zipcode'];
      $b_month = $_POST['birth_month'];
      $b_day = $_POST['birth_day'];
      $b_year = $_POST['birth_year'];

      //sanitize
      $f_name = stripslashes($f_name);
      $f_name = mysql_real_escape_string($f_name);
      $l_name = stripslashes($l_name);
      $l_name = mysql_real_escape_string($l_name);
      $email = stripslashes($email);
      $email = mysql_real_escape_string($email);
      $street_address = stripslashes($street_address);
      $street_address = mysql_real_escape_string($street_address);
      $zipcode = stripslashes($zipcode);
      $zipcode = mysql_real_escape_string($zipcode);
      $b_month = stripslashes($b_month);
      $b_month = mysql_real_escape_string($b_month);
      $b_day = stripslashes($b_day);
      $b_day = mysql_real_escape_string($b_day);
      $b_year = stripslashes($b_year);
      $b_year = mysql_real_escape_string($b_year);
  
    $first_name = strip_tags($first_name);
    $last_name = strip_tags($last_name);
    $username = strip_tags($username);
    $b_month = strip_tags($b_month);
    $b_day = strip_tags($b_day);
    $b_year = strip_tags($b_year);
    $email = strip_tags($email);
    $street_address = strip_tags($street_address);
    $zipcode = strip_tags($zipcode);

		$bday=$birth_year."-".$birth_month."-".$birth_day;
  
      $first_name=$f_name;
      $last_name=$l_name;
      $birth_day=$b_day;
      $birth_month=$b_month;
      $birth_year=$b_year;
      //check for errors in form
      include 'validate.php';

      if($errors==0) {
        //update tables in database with new user info
        $mysqli = new mysqli('132.241.49.7',$admin_username,$admin_password,'cins548');
        $sql = "UPDATE users SET f_name=?, l_name=?, email=?, street_address=?, zipcode=? WHERE username=?";
        if($stmt = $mysqli->prepare($sql)) {
          $stmt->bind_param("ssssss",$f_name,$l_name,$email,$street_address,$zipcode,$username);
          if($stmt->execute()) {
            echo "<p id='info'>Successfully updated user info.</p>";
          }
          else echo "<p id='alert'>An error occurred.</p>";
        }
        exit;
      }
      else echo "<p id='alert'>An error occurred while validating the form data.</p>";
    }
    else {
      //form not submitted yet, retrieve user details to populate form below
      include 'mysql_settings_read.php';
      $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
      $username = $_SESSION['myusername'];
      $sql = "SELECT f_name,l_name,bday,email,street_address,zipcode FROM users WHERE username=?";
      if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $stmt->bind_result($first_name,$last_name,$bday,$email,$street_address,$zipcode);
        while($stmt->fetch()) {
          //we need to split the bday up into month, day, year
          //mysql form is: YYYY-MM-DD
          list($b_year,$b_month,$b_day) = split("-",$bday);
        }
      }
    }
  }
  else { 
    echo "<script>alert('You must be logged in for this function, newb.')</script>";
    exit; 
  }
?>
<form action="" method="POST">
<p>First name:<br />
<input type="text" name="first_name" value="<?php echo $first_name; ?>"/></p>
<p>Last name:<br />
<input type="text" name="last_name" value="<?php echo $last_name; ?>" /></p>
<p>Date of birth:<br />
<select name="birth_month">
<?php
	for($i=1; $i<13; $i++) {
    if($i==$b_month) echo "<option value'$i' selected='selected'>$i</option>";
		else echo "<option value='$i'>$i</option>";
	}
?>
</select>
<select name="birth_day">
<?php
	for($i=1; $i<32; $i++) {
    if($i==$b_day) echo "<option value'$i' selected='selected'>$i</option>";
		else echo "<option value='$i'>$i</option>";
	}
?>
</select>
<select name="birth_year">
<?php
	for($i=date('Y'); $i>1900; $i--) {
    if($i==$b_year) echo "<option value'$i' selected='selected'>$i</option>";
		else echo "<option value='$i'>$i</option>";
	}
?>
</select>
</p>
<p>Email:<br />
<input type="text" name="email" value="<?php echo $email; ?>"/></p>
<p>Street Address:<br />
<input type="text" name="street_address" value="<?php echo $street_address; ?>" /></p>
<p>Zip code:<br />
<input type="text" name="zipcode" value="<?php echo $zipcode; ?>" /></p>
<input type="submit" name="editusersubmit" value="Save Changes" /> <input type="reset" value="reset" />
</form>
