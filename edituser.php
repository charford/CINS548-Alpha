<?php
  //edit user information here. below, we get info from database
  //based on the current user logged in
  if($logged_in==1) {
    include 'mysql_settings_read.php';
    $username = $_SESSION['myusername'];
    
    $sql = "SELECT f_name,l_name,bday,email,street_address,zipcode
            FROM users WHERE username='$username'";

    $result = mysql_query($sql);
  
    if($result) {
      while ($row = mysql_fetch_array($result)) {
        $first_name = $row['f_name'];
        $last_name = $row['l_name'];
        $email = $row['email'];
        $bday = $row['bday'];
        $street_address = $row['street_address'];
        $zipcode = $row['zipcode'];
      }
      //we need to split the bday up into month, day, year
      //mysql form is: YYYY-MM-DD
      list($b_year,$b_month,$b_day) = split("-",$bday);
       
    }
  }
?>
Edit My User Info</p>
<?php echo $b_month; ?>
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
<input type="submit" name="register" value="Register" /> <input type="reset" value="reset" />
</form>
