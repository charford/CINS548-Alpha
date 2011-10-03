<?php
  if(isset($_POST['reply'])) {
	  include 'mysql_settings.php';
  }
  else if(isset($_POST['add_discussion'])) {
	  include 'mysql_settings.php';
  }
  else include 'mysql_settings_read.php';
	//find out if user is admin or not
	//include 'mysql_settings_read.php';
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
  
  //if we are given a discussion id, go ahead and display topics within the discussion
	if(isset($_POST['discussion_id']) || isset($_GET['discussion_id'])) {
		if(isset($_POST['discussion_id'])) $discussion_id=$_POST['discussion_id'];
		else $discussion_id=$_GET['discussion_id'];
		
		//sanitize
		$discussion_id=stripslashes($discussion_id);
		$discussion_id=mysql_real_escape_string($discussion_id);

		$sql = "SELECT title FROM discussions WHERE id='$discussion_id'";
		$result = mysql_query($sql);
		if($result) {
			while ($row = mysql_fetch_array($result)) {
				$discussion_title = $row['title'];
			}

		//display navigation up top
		echo "<a href='?action=viewposts'>View Posts</a> > $discussion_title</p><h2>$discussion_title</h2>";
		}
    
		$sql = "SELECT * FROM posts WHERE discussion_id=$discussion_id AND reply_id = '0' ORDER BY date_posted desc";
		$result = mysql_query($sql);
		if($result) {
		echo "<table class='results_table'>
			<tr class='results_firstrow'>
				<th>Post Title</th>
				<th id='date_posted'>Date Posted</th>
				<th>Author</th>
				<th># Replies</th>
			</tr>";
			while($row = mysql_fetch_array($result)) {
				//retrieve the array of stuff	
				$title = $row['title'];
				$id = $row['post_id'];
				$date_posted = $row['date_posted'];
				$posted_by = $row['user_id'];
			
				//determine number of replies
				$sql = "SELECT count(*) as count FROM posts WHERE reply_id='$id'";
				$replies_result = mysql_query($sql);
				if($replies_result) {
					$row = mysql_fetch_assoc($replies_result);
					$replies = $row['count'];
				}
				else {
					$replies = 0;
				}
			
				echo "<tr id='postrow'><td><a href='?action=viewposts&post_id=$id'>$title</a>";
				if($user_type==2) {
					echo "<span class='delete_post'><a href='?action=delete&post_id=$id'>X</a></span>";
				}
				echo "</td><td id='date_posted'>$date_posted</td><td>$posted_by</td><td>$replies</td></tr>";
			}
		echo "</table>";
		}
	}
	
	//display post details when given a post_id
	elseif(isset($_GET['post_id'])) {
		$post_id=$_GET['post_id'];

		//sanitize
		$post_id = stripslashes($post_id);
		$post_id = mysql_real_escape_string($post_id);

		//retrieve post content
		$sql = "SELECT * FROM posts WHERE post_id='$post_id'";
		$result = mysql_query($sql);
		if($result) {
			$row = mysql_fetch_assoc($result);
			$post_title = $row['title'];
			$post_content = $row['content'];
			$author = $row['user_id'];
			$date_posted = $row['date_posted'];
			$discussion_id = $row['discussion_id'];
			$post_id = $row['post_id'];

			//retrieve discussion_title
			$sql = "SELECT title FROM discussions WHERE id='$discussion_id'";
			$result = mysql_query($sql);
			if($result) {
				$row = mysql_fetch_assoc($result);
				$discussion_title=$row['title'];
			}
			else $discussion_title="UNDEFINED";		//should never be the case
	
			//submit response if reply button pressed
			if($logged_in==1) {	//must be logged in to post reply
				if(isset($_POST['reply'])) {
					$author = $_SESSION['myusername'];
					$reply_title = $_POST['reply_title'];
					$reply_message = $_POST['reply_message'];
					
					//sanitize input
					$reply_title = stripslashes($reply_title);
					$reply_message = mysql_real_escape_string($reply_message);
        
					$sql = "INSERT INTO posts (title,content,user_id,discussion_id,reply_id,date_posted)
						VALUES ('$reply_title','$reply_message','$author','$discussion_id','$post_id',NOW())";
					$result = mysql_query($sql);
					if($result) {
						//echo "<p>Reply successful</p>";
					}
					else echo "<p>An error occurred</p>";
					
				}
			}

			echo "<a href='?action=viewposts'>View Posts</a> > 
				<a href='?action=viewposts&discussion_id=$discussion_id'>$discussion_title</a> > $post_title</p>

				<h2>$post_title</h2>
				<p>Author: $author, posted $date_posted</p>
				<p>Message:</p>
				<p>$post_content</p>

				<h3>Leave a reply:</h3>
				<form action='' method='POST'>
				<p>Title: <br />
				<input type='text' name='reply_title' value='' /></p>
				<p>Message: <br />
				<textarea name='reply_message' style='width: 300pt; height: 100pt;'></textarea></p>
				<p><input type='submit' name='reply' value='Reply' /> <input type='reset' value='Clear' /></p>
				</form>
				";
      
        //display reply posts
        $sql = "SELECT * FROM posts WHERE reply_id='$post_id' ORDER BY date_posted desc";
        $result = mysql_query($sql);
        if($result) {
          while ($row = mysql_fetch_array($result)) {
            $title = $row['title'];
            $author = $row['user_id'];
            $id = $row['post_id'];
            $content = $row['content'];
            $date_posted = $row['date_posted'];
            
            echo "<h2>$title</h2>
                  <p>Author: $author, posted $date_posted</p>
                  <p>$content</p>";
            
          }
        }
		}
	}
	else {
  //admin options, add discussion if form was submitted
  if($user_type==2) {
    if(isset($_POST['add_discussion'])) {
      $discussion_title = $_POST['discussion_title'];
      $sql = "INSERT INTO discussions (title) VALUES ('$discussion_title')";
      $result = mysql_query($sql);
      if(!$result) echo "<p>failed to add new discussion</p>";
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
	echo "View Posts</p>
	<h2>View Posts</h2><p>First, choose a discussion:</p>";
		for($i=0;$i<count($discussions_id); $i++) {
			echo "<p><a href='?action=viewposts&discussion_id=".$discussions_id[$i]."'>".$discussions_title[$i]."</a></p>";
		}
  //administrator options
  if($user_type==2) {
    echo "<h4>Add Discussion</h4>
    <form method='post' action='?action=viewposts'>
      <input name='discussion_title' />
      <input type='submit' value='Create' name='add_discussion' />
    </form>
    </form>
    ";

  }
	exit;
	}
?>
