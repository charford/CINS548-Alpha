<?php
  //check if user is admin
  $id=$_SESSION['myusername'];
  include 'mysql_settings_read.php';
  $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
	$sql = "SELECT user_type FROM users WHERE username=?";
	if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s",$id);
    $stmt->execute();
    $stmt->bind_result($user_type);
    while($stmt->fetch()) {
      //do i need anything here
		  //user type 0 = regular user	//
		  //user type 1 = moderator user	//
		  //user type 2 = admin user	//
    }
	}
	else $user_type="0";	//set user to lowest privilege(view only)
  
  //user must be admin to delete posts
  if($user_type==2) {
    include 'mysql_settings.php';
    $mysqli = new mysqli('132.241.49.7',$admin_username,$admin_password,'cins548');
    $sql = "DELETE FROM posts WHERE post_id=? OR reply_id=?";
    if($stmt = $mysqli->prepare($sql)) {
      $post_id=$_GET['post_id'];
      $discussion_id=$_GET['discussion_id'];
      $stmt->bind_param("ii",$post_id,$post_id);
      $stmt->execute();
      header("Location: https://132.241.49.6/index.php?action=viewposts&discussion_id=".$discussion_id);
      exit();
    }
  }
?>
