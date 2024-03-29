<?php
  //check if site is being access by SSL, if not, redirect to SSL
  if(!$_SERVER['HTTPS']) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://132.241.49.6/");
    exit();
  }
  session_start(); 
  error_reporting(1);

	if(isset($_SESSION['logged_in'])) $logged_in = $_SESSION['logged_in'];
	else $logged_in=0;
	
  if(isset($_GET['action'])) $action = $_GET['action'];
	else $action="login";

	if($action=="logout") {
		session_destroy();
		session_start();
		$action="login";
		$logged_in=0;
	}

  //delete post function
  if($action=="delete" && $logged_in==1) {
    if(isset($_GET['post_id'])) {
      include 'delete.php';
    }
  }
  

?>
<!DOCTYPE html>
<html>
<head>
<title>Super Secret Discussion Forum</title>
<link rel="stylesheet" type="text/css" media="screen" href="style.css"/>
</head>
<body>
<?php	

	if($logged_in==0) {
		switch($action) {
			case 'login': 
				include 'login.php';
			break;
		
			case 'register':
				echo "<p><a href='index.php'>Click, to go back Home</a></p>";
				include 'register.php';
			break;

			case 'resetpw':
 				include 'resetpw.php';
			break;
  
      case 'viewposts':
				echo "<p><a href='index.php'>Click, to go back Home</a></p>";
        include 'viewposts.php';
      break;

			default:
				include 'login.php';
			break;
		}

	}
	elseif($logged_in==1) {
		//display logged in stuff here

		switch($action) {
	
			case 'newpost':
				echo "<p><a href='index.php'>Home</a> > New Post</p>";
				include 'newpost.php';
			break;

			case 'viewposts':
				echo "<p><a href='index.php'>Home</a> > ";
				include 'viewposts.php';
			break;

      case 'viewusers':
				echo "<p><a href='index.php'>Home</a> > ";
        include 'viewusers.php';
      break;

      case 'edituser':
				echo "<p><a href='index.php'>Home</a> > ";
        include 'edituser.php';
      break;

			default: 
				include "main_menu.php";
			break;
		}
	}
	else echo "An error occured.";
?>
</body>
</html>
