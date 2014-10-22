<?php
echo("Hello World!");
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

echo("Hello World!");

if(isset($_POST['save']))
{
	$comment=$_POST['comment'];
	$len=strlen($comment);
	if($len<=5)
	{
		$message="Don't you feel it's too short! Try somewhat long message!!";
		$flag=0;
	}
	
	else	
	{
		$result=mysql_query(
			"UPDATE
				offline_access_users
			SET
				`custom_message` = '" . mysql_real_escape_string($message) . "',
	                WHERE
				`user_id` = " . $user . "
				
		");
		if(!$result)
			echo("Try reloading this Page!");
		else
			$flag=1;
	}
}			
else
{
	echo("Pankaj Mera");
	//exit(0);
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
<title>Birthday bash</title>
<link rel="stylesheet" href="contact/css/reset.css" type="text/css" />
<link rel="stylesheet" href="contact/css/master.css" type="text/css" />
<script type="text/javascript">
function validateForm()
{
var x=document.forms["savingform"]["comment"].value;
if (x==null || x=="")
  {
  alert("First name must be filled out");
  return false;
  }
}
</script>
<?php
/*
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="contact/contact.js"></script>-->
*/
?>
	<link rel="stylesheet" href="includes/css/main.css" type="text/css" />	
	<div id="fb-root"></div>
    </head>
    <body>
    
	<div class="wrap">
	
		
		<ul id="menu">
			
			<li><a href="http://www.facebook.com/apps/application.php?id=133538010068848&sk=wall" target =" " >Share us</a></li>
			<li><a href="#">Configure</a></li>
			<li><a href="includes/about_us.html">About us</a></li>
			<li><a href="includes/contact.html">contact us</a></li>
			<h2>Birthday bash</h2>
			
		</ul>
		
		<div id="text">
			
			<p>		
				
if($flag==0)
{		
?>
				<p>
				<center>
						
					<h3><?php echo($message); ?> </h3>
					
					<!--contact form-->


  <form action="" method="post" name="savingform" id="savingform" onsubmit="return validateForm()">
  <p>Put Your Custom message here:</p>
  <p><textarea name="comment" id="comment" rows="5" cols="40" value=""> </textarea></p>
  <input type="hidden" name="save" />
  <p><input type="submit" id="submit" name="submit" value="save" /></p>
 </form>

<div id="mask"></div>

<!--end contact form-->
				
				
				</center>
<?php
}
else
{
	echo("Changes are saved!!");
}
	}			
			 else
			  { 
			 echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
                           		 } ?>
			</p>
		</div>

		<div id="green_bubble">
			<p>if you have any queries or suggestions <br />  <center> <a href="https://www.facebook.com/apps/application.php?id=164181646991260" target =" " >Share with us</a></center> </p>
		</div>
	</div>

	<div id="footer">
		<div class="wrap">
			<div id="bubble"><p><p><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=256499181042648&amp;xfbml=1"></script><fb:like href="http://www.facebook.com/site.engineerinme" send="true" width="270" show_faces="true" font=""></fb:like></p>
			</div></p></div>
			<div id="copyright">
				
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>
*/
?>
