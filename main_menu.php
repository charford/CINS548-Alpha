<?php
	$username = $_SESSION['myusername'];
?>
<h2>Logged in</h2>
<?php echo "Welcome, $username."; ?>
<p><a href="?action=newpost">New Post</a></p>
<p><a href="?action=viewposts">View Posts</a></p>
<p><a href="?action=viewusers">View Users</a></p>
<p><a href="?action=edituser">Edit My User Info</a></p>
<p><a href="?action=logout">Sign out</a></p>



