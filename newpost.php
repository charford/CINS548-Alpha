<?php
if($logged_in!=1) {
echo "You must be logged in for this function.";
exit(1);
}
include 'mysql_settings.php';

if(isset($_POST['post_title'])) {
	//process new post

	//retrieve from POST
	$post_title = $_POST['post_title'];
	$post_content = $_POST['post_content'];
	if(isset($_POST['privacy'])) $privacy=1;
	else $privacy=0;
	$discussion_id = $_POST['discussion_id'];
	$reply_id=0;	//will update when reply functionality is implemented	//TODO
	$user_id = $_SESSION['myusername'];
	
	
	//sanitize
	$post_title = stripslashes($post_title);
	$post_content = stripslashes($post_content);
	$privacy = stripslashes($privacy);
	$discussion_id = stripslashes($discussion_id);
	$reply_id = stripslashes($reply_id);
	$user_id = stripslashes($user_id);
	$post_title = mysql_real_escape_string($post_title);
	$post_content = mysql_real_escape_string($post_content);
	$privacy = mysql_real_escape_string($privacy);
	$discussion_id = mysql_real_escape_string($discussion_id);
	$reply_id = mysql_real_escape_string($reply_id);
	$user_id = mysql_real_escape_string($user_id);

  $post_title= strip_tags($post_title);
  $post_content = strip_tags($post_content);
  $privacy = strip_tags($privacy);
  $discussion_id = strip_tags($discussion_id);
  $reply_id = strip_tags($reply_id);
  $user_id = strip_tags($user_id);

	if(trim($post_title)!="" && trim($post_content)!="") {
		$sql = "INSERT INTO posts (title,content,date_posted,privacy,user_id,discussion_id,reply_id) 
			VALUES ('$post_title','$post_content',NOW(),'$privacy','$user_id','$discussion_id','$reply_id')";

		$result = mysql_query($sql);
		if($result) {
			echo "<p>added post successfully.</p>";
		}
		else {
			echo "<p>failed adding post.</p>";
		}

	}
	
}

//retrieve list of discussion_names
$sql = "SELECT * FROM discussions ORDER BY title";
$result = mysql_query($sql);
$discussions_title = array();
$discussions_id = array();
if($result) {
	while ($row = mysql_fetch_array($result)) {
		$title = $row['title'];
		$id = $row['id'];
		array_push($discussions_title,$title);
		array_push($discussions_id,$id);
	}
}
?>

<h2>New Post</h2>
<form action="" method="POST">
<p>Title:<br />
<input type="text" name="post_title" /></p>
<p>Category<br />
<select name="discussion_id">
<?php
	//generate category list
	for($i=0;$i<count($discussions_id); $i++) {
		echo "$discussions_id[$i]";
		echo "<option value='".$discussions_id[$i]."'>".$discussions_title[$i]."</option>";
	}
?>
</select>
</p>
<p>Content:<br />
<textarea name="post_content" style="width: 300pt; height: 100pt;"></textarea></p>
<p>Make private? <input type="checkbox" name="privacy" /></p>

<input type="submit" value="Submit" /> <input type="reset" value="Clear" />
</form>
