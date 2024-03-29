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
  
  //if we are given a discussion id, go ahead and display topics within the discussion
	if(isset($_POST['discussion_id']) || isset($_GET['discussion_id'])) {
		if(isset($_POST['discussion_id'])) $discussion_id=$_POST['discussion_id'];
		else $discussion_id=$_GET['discussion_id'];
		
		//sanitize
		$discussion_id=stripslashes($discussion_id);
		$discussion_id=mysql_real_escape_string($discussion_id);
    $discussion_id=strip_tags($discussion_id);

    $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
    if($stmt = $mysqli->prepare("SELECT title FROM discussions WHERE id=?")) {
      $stmt->bind_param("i",$discussion_id);
      $stmt->execute();
      $stmt->bind_result($discussion_title);
      while ($stmt->fetch()) {
        //not sure if i need anything here
      }
    }
		echo "<a href='?action=viewposts'>View Posts</a> > "; 
    echo "$discussion_title</p><h2>$discussion_title</h2>";
    
    //display all posts, if logged in, else show only public posts
    if($logged_in==1) $sql = "SELECT title,post_id,date_posted,user_id FROM posts WHERE discussion_id=? AND reply_id = '0' ORDER BY date_posted desc";
    //display public only posts
    else $sql = "SELECT title,post_id,date_posted,user_id FROM posts WHERE discussion_id=? AND reply_id = '0' AND privacy=0 ORDER BY date_posted desc";

    $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
    if($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i",$discussion_id);
    $stmt->execute();
    $stmt->bind_result($title,$id,$date_posted,$posted_by);
    
		echo "<table class='results_table'>
			<tr class='results_firstrow'>
				<th>Post Title</th>
				<th id='date_posted'>Date Posted</th>
				<th>Author</th>
				<th># Replies</th>
			</tr>";

      //get rows of data
			while($stmt->fetch()) {
        $mysqli2 = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
        
				$sql = "SELECT count(*) as count FROM posts WHERE reply_id=?";
        if($stmt2 = $mysqli2->prepare($sql)) {
          $stmt2->bind_param("i",$id);
          $stmt2->execute();
          $stmt2->bind_result($replies);
          while($stmt2->fetch()) {
            //useless comment
          }
        }
				else {
					$replies = 0;
				}
			
				echo "<tr id='postrow'><td><a href='?action=viewposts&post_id=$id'>$title</a>";
				if($user_type==2) {
					echo "<span class='delete_post'><a href='?action=delete&post_id=$id&discussion_id=$discussion_id'>X</a></span>";
				}
				echo "</td><td id='date_posted'>$date_posted</td><td>$posted_by</td><td>$replies</td></tr>";
			}
		echo "</table>";
    $stmt->close();
		}
    $mysqli->close();
	}
	
	//display post details when given a post_id
	elseif(isset($_GET['post_id'])) {
		$post_id=$_GET['post_id'];

		//sanitize
		$post_id = stripslashes($post_id);
		$post_id = mysql_real_escape_string($post_id);

		//retrieve post content
    $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
		$sql = "SELECT title,content,user_id,date_posted,discussion_id,post_id,privacy, COUNT(*) as valid FROM posts WHERE post_id=?";
    if($stmt = $mysqli->prepare($sql)) {
      $stmt->bind_param("i",$post_id);
      $stmt->execute();
      $stmt->bind_result($post_title,$post_content,$author,$date_posted,$discussion_id,$post_id,$privacy,$valid);
      while($stmt->fetch()) {

      }
      if($valid==0) {
        echo "<p>Invalid post requested</p>";
        exit;
      }

      if($logged_in==0 && $privacy!=0) {
        echo "<script>alert('You must be logged in to view this post.');</script>";
        exit;
      }

			//retrieve discussion_title
      $mysqli2 = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
			$sql = "SELECT title FROM discussions WHERE id=?";
      if($stmt = $mysqli2->prepare($sql)) {
        $stmt->bind_param("i",$discussion_id);
        $stmt->execute();
        $stmt->bind_result($discussion_title);
        while($stmt->fetch()) {
          //useless
        }
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
					$reply_title = mysql_real_escape_string($reply_title);
					$reply_message = stripslashes($reply_message);
					$reply_message = mysql_real_escape_string($reply_message);
          $reply_title = strip_tags($reply_title);
          $reply_message = strip_tags($reply_message);
          
          $mysqli2 = new mysqli('132.241.49.7',$admin_username,$admin_password,'cins548');
					$sql = "INSERT INTO posts (title,content,user_id,discussion_id,reply_id,date_posted) VALUES (?,?,?,?,?,NOW())";
          if($stmt = $mysqli2->prepare($sql)) {
            $stmt->bind_param("sssii",$reply_title,$reply_message,$author,$discussion_id,$post_id);
            $stmt->execute();
          }
					else echo "<p>An error occurred</p>";
				}
			}
      else echo "<script>alert('You must be logged in to post reply!')</script>";

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
      $mysqli3 = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
      $sql = "SELECT title,user_id,post_id,content,date_posted FROM posts WHERE reply_id=? ORDER BY date_posted desc";
      if($stmt = $mysqli3->prepare($sql)) {
        $stmt->bind_param("i",$post_id);
        $stmt->execute();
        $stmt->bind_result($title,$author,$id,$content,$date_posted);
        while($stmt->fetch()) {
          echo "<h2>$title</h2>
          <p>Author: $author, posted $date_posted</p>
          <p>$content</p>";
        }
      }
		}
	}
	else {
	  echo "View Posts</p>
	  <h2>View Posts</h2><p>First, choose a discussion:</p>";
    //admin options, add discussion if form was submitted
    if($user_type==2) {
      $mysqli = new mysqli('132.241.49.7',$admin_username,$admin_password,'cins548');
      if(isset($_POST['add_discussion'])) {
        $discussion_title = $_POST['discussion_title'];
        if($stmt = $mysqli->prepare("INSERT INTO discussions (title) VALUES (?)")) {
          $stmt->bind_param("s",$discussion_title);
          $stmt->execute();
        }
      }
    }
	  //retrieve list of discussion_names
    $mysqli = new mysqli('132.241.49.7',$read_username,$read_password,'cins548');
    if($result = $mysqli->query("SELECT * FROM discussions ORDER BY title")){
      while($row = $result->fetch_object()) {
			  $title = $row->title;
			  $id = $row->id;
			  echo "<p><a href='?action=viewposts&discussion_id=$id'>$title</a></p>";
      }
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
