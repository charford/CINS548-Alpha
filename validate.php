<?php
	//validate form data//
		$errors=0;
		if($first_name=='') {
			echo "<div id='alert'>first_name can't be blank</div>";
			$errors=1;		
		}
		if($last_name=='') {
			echo "<div id='alert'>last name can't be blank</div>";
			$errors=1;		
		}
		if($street_address=='') {
			echo "<div id='alert'>street address can't be blank</div>";
			$errors=1;		
		}
		if($username=='') {
			echo "<div id='alert'>username can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && $password=='') {
			echo "<div id='alert'>password can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && $confirm_password=='') {
			echo "<div id='alert'>confirm password can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && $password!=$confirm_password) {
			echo "<div id='alert'>passwords don't match</div>";
			$errors=1;
		}
		if($birth_month=='') {
			echo "<div id='alert'>birth month can't be blank</div>";
			$errors=1;		
		}
		if($birth_day=='') {
			echo "<div id='alert'>birth day can't be blank</div>";
			$errors=1;		
		}
		if($birth_year=='') {
			echo "<div id='alert'>birth year can't be blank</div>";
			$errors=1;		
		}
		if($email=='') {
			echo "<div id='alert'>email can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && $security_question=='') {
			echo "<div id='alert'>security question can't be blank</div>";
			$errors=1;		
		}
		if($action=='register' && $security_answer=='') {
			echo "<div id='alert'>security answer can't be blank</div>";
			$errors=1;		
		}
?>
