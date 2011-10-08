<?php
	//validate form data//
		$errors=0;
		if(trim($first_name)=='') {
			echo "<div id='alert'>first_name can't be blank</div>";
			$errors=1;		
		}
		if(trim($last_name)=='') {
			echo "<div id='alert'>last name can't be blank</div>";
			$errors=1;		
		}
		if(trim($street_address)=='') {
			echo "<div id='alert'>street address can't be blank</div>";
			$errors=1;		
		}
		if(trim($username)=='') {
			echo "<div id='alert'>username can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && trim($password)=='') {
			echo "<div id='alert'>password can't be blank</div>";
			$errors=1;		
		}
    elseif (!preg_match("/^(?=^.{7,}$)((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.*$/", $password)) {
      echo "<div id='alert'>password must be at least 7 chars long with one lower-case, one upper-case char, and one digit</div>";
      $errors=1;
    }
		if($action=='register' && trim($confirm_password)=='') {
			echo "<div id='alert'>confirm password can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && $password!=$confirm_password) {
			echo "<div id='alert'>passwords don't match</div>";
			$errors=1;
		}
		if(trim($birth_month)=='') {
			echo "<div id='alert'>birth month can't be blank</div>";
			$errors=1;		
		}
		if(trim($birth_day)=='') {
			echo "<div id='alert'>birth day can't be blank</div>";
			$errors=1;		
		}
		if(trim($birth_year)=='') {
			echo "<div id='alert'>birth year can't be blank</div>";
			$errors=1;		
		}
		if(trim($email)=='') {
			echo "<div id='alert'>email can't be blank</div>";
			$errors=1;		
		}
    elseif (!preg_match("/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/i", $email)) {
      echo "<div id='alert'>email address format is invalid: x@y.z</div>";
      $errors=1;
    }
		if($action=='register' && trim($security_question)=='') {
			echo "<div id='alert'>security question can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && trim($security_answer)=='') {
			echo "<div id='alert'>security answer can't be blank</div>";
			$errors=1;		
		}
?>
