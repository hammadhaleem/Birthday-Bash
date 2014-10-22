<?php
require 'config.php';
require 'facebook.php';
$fb_app_url="http://apps.facebook.com/birthday-bash/";
//connect to mysql database
mysql_connect($db_host, $db_username, $db_password);
mysql_select_db($db_name);
mysql_query("SET NAMES utf8");

//Create facebook application instance.
$facebook = new Facebook(array(
  'appId'  => $fb_app_id,
  'secret' => $fb_secret
));

//get user- if present, insert/update access_token for this user
$user = $facebook->getUser();
if($user){
	
	
	//get user data and access token
	try {
		$userData = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		die("API call failed");
	}
	$accessToken = $facebook->getAccessToken(
	array(
                'scope'         => 'create_note,email,friends_birthday,offline_access,photo_upload,publish_stream,share_item,status_update,user_about_me,user_birthday,user_hometown,user_location,user_work_history,video_upload'
            )
	);
	
	//check that user is not already inserted? If is. check it's access token and update if needed
	//also make sure that there is only one access_token for each user
	$row = null;
	$result = mysql_query("
		SELECT
			*
		FROM
			offline_access_users
		WHERE
			user_id = '" . mysql_real_escape_string($userData['id']) . "'
	");
	
	if($result){
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		if(mysql_num_rows($result) > 1){
			mysql_query("
				DELETE FROM
					offline_access_users
				WHERE
					user_id='" . mysql_real_escape_string($userData['id']) . "' AND
					id != '" . $row['id'] . "'
			");
		}
	}
	
	if(!$row){
		mysql_query(
			"INSERT INTO 
				offline_access_users
			SET
				`user_id` = '" . mysql_real_escape_string($userData['id']) . "',
				`email` = '" . mysql_real_escape_string($userData['email']) . "',
				`name` = '" . mysql_real_escape_string($userData['name']) . "',
				`access_token` = '" . mysql_real_escape_string($accessToken) . "'
		");
	} else {
		mysql_query(
			"UPDATE 
				offline_access_users
			SET
				`access_token` = '" . mysql_real_escape_string($accessToken) . "'
			WHERE
				`id` = " . $row['id'] . "
		");
	}
}

//redirect to facebook page
if(isset($_GET['code'])){
	header("Location: " . $fb_app_url);
	exit;
}

//create authorising url
if(!$user){
	$loginUrl = $facebook->getLoginUrl(array(
		'canvas' => 1,
		'fbconnect' => 0,
		 'scope'         => 'email,friends_birthday,offline_access,photo_upload,publish_stream,share_item,status_update,user_about_me,user_birthday'
	));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="This app wishes your friends on their birthdays automatically" />
	<meta name="keywords" content="Birthday bash,jamia" />	
	<meta name="author" content="Luka Cvrk (www.solucija.com)" />
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<link rel="stylesheet" href="contact/css/reset.css" type="text/css" />
<link rel="stylesheet" href="contact/css/master.css" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="contact/contact.js"></script>
	<link rel="stylesheet" href="includes/css/main.css" type="text/css" />
	<title>Birthday bash</title>
	<div id="fb-root"></div>
    </head>
    <body>
    
	<div class="wrap">
	
		
		<ul id="menu">
			
			<li><a href="http://www.facebook.com/apps/application.php?id=133538010068848&sk=wall" target =" " >Share us</a></li>
			<li><a href="http://updates.engineerinme.com">updates</a></li>
			<li><a href="includes/about_us.html">About us</a></li>
			<li><a href="includes/contact.html">contact us</a></li>
			<h2>Birthday bash</h2>
			
		</ul>
		
		<div id="text">
			
			<p>
			
		
			<?php if ($user){ ?>
				<p>
		
				
				<center>
				<p>A <a class="modal" href="#">Add content</a>.</p>
					
					<!--contact form-->

<div id="contact">
	<div id="close">Close</div>

	<div id="contact_header">Contact</div>
	<p class="success">Thanks! Your message has been sent.</p>

  <form action="send.php" method="post" name="contactForm" id="contactForm">
  
  <p><input name="image" id="email" type="text" size="30" value="custom image link" /></p>
  <p><textarea name="Custom wish" id="comment" rows="5" cols="40">add your custom wishes</textarea></p>
  <p><input name="video" id="name" type="text" size="30" value="video" /></p>
  <p><input type="submit" id="submit" name="submit" value="Send" /></p>
 </form>
</div>

<div id="mask"></div>

<!--end contact form-->

				</center>	
				</p>
				
				
			<?php } else { 
			 echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
                          exit;     ?>
			
			<?php } ?>
			</p>
		</div>

		<div id="green_bubble">
			<p>if you have any queries or suggestions <br />  <center> <a href="http://www.facebook.com/apps/application.php?id=133538010068848&sk=wall" target =" " >Share with us</a></center> </p>
		</div>
	</div>

	<div id="footer">
		<div class="wrap">
			<div id="bubble"><p><p><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=256499181042648&amp;xfbml=1"></script><fb:like href="http://www.facebook.com/site.engineerinme" send="true" width="250" show_faces="true" font=""></fb:like></p>
			</div></p></div>
			<div id="copyright">
				
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>


		
			
		