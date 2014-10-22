<?php
require '../config.php';
require '../facebook.php';
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



 if(isset($_REQUEST['check']))
 {

  
 }
 echo $msg;
 echo $savepath;
  $userData['id']=$user;
  
if( isset($savepath ))
{
		/*mysql_query(
			"INSERT INTO 
				offline_access_users
			SET
				`user_id` = '" . mysql_real_escape_string($userData['id']) . "',
				`custom_image` = '". $savepath."',
				`name` = '" . mysql_real_escape_string($userData['name']) . "',
				`access_token` = '" . mysql_real_escape_string($accessToken) . "'
		");
	
		*/
		mysql_query(
			"UPDATE 
				offline_access_users
			SET
				
				`custom_image` = '". $savepath."'
			WHERE
				`user_id` = " .$user . "
		");
		echo 'done ' ;
	}
	
?><script type="text/javascript">

var myform=new formtowizard({
	formid: 'feedbackform',
	persistsection: true,
	revealfx: ['slide', 500]
})

</script>


<b><legend>Custom inputs</legend>

MESSAGE:<br />(if you enter any junk values then it would also be <br /> displayed in your message)<br /><textarea id="m1" type="text" style="width:550px;height:60px" /><br />


<b>custom mesaage:</b><br />

if you leave this blank then it would post a self genrated  random message </b>
