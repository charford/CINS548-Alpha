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
    echo "<table>
            <tr><th>Username</th>
                <th>Real Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Zip Code</th>
            </tr>

    </table>";
  }
  else {
    echo "you cannot view users";
  }
?>
