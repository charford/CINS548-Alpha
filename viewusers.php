View Users</p><h2>View Users</h2>
<?php

include 'mysql_settings.php';

	//find out if user is admin or not
	$id = $_SESSION['myusername'];
	$sql = "SELECT user_type FROM users WHERE username='$id'";
	$result = mysql_query($sql);
	if($result) {
		//user type 0 = regular user	//
		//user type 1 = moderator user	//
		//user type 2 = admin user	//
		while($row = mysql_fetch_array($result)) {
			$user_type=$row['user_type'];
		}
	}
	else $user_type="0";	//set user to lowest privilege(view only)
  
  if($user_type=='2') {
    //output table header
    echo "<table class='results_table'>
            <tr class='results_firstrow'><th>Username</th>
                <th>Real Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Zip Code</th>
            </tr>";
    
    //get user info from database
    $sql = "SELECT * FROM users ORDER BY username";
    $result = mysql_query($sql);
    
    if($result) {
      while ($row = mysql_fetch_array($result)) {
        $username = $row['username'];
        $email = $row['email'];
        $f_name = $row['f_name'];
        $l_name = $row['l_name'];
        $bday = $row['bday'];
        $street = $row['street_address'];
        $zipcode = $row['zipcode'];
        $phone = $row['phone_num'];
        $ut = $row['user_type'];
        
        echo "<tr id='postrow'>
                <td>$username</td>
                <td>$f_name $l_name</td>
                <td><a href='mailto:$email'>$email</a></td>
                <td>$phone</td>
                <td>$street</td>
                <td>$zipcode</td>
              </tr>";
              
      }
    }
    

    echo "</table>";

  }
  else {
    echo "you cannot view users";
  }
?>
