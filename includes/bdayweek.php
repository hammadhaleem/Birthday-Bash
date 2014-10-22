
		 
	</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="description" content="eim" />
	<meta name="keywords" content="engineerinme,jamia" />	
	<meta name="author" content="Luka Cvrk (www.solucija.com)" />
	<link rel="stylesheet" href="css/main.css" type="text/css" />
	<title>Engineerinme</title>
</head><body>
	<div class="wrap">
	
		
		<ul id="menu">
			<li><a href="../index.php">Home</a></li>
			<li><a href="https://www.facebook.com/site.engineerinme">Share us</a></li>
			<li><a href="about_us.html">about us</a></li>
			<li><a href="http://updates.engineerinme.com" target= " ">updates</a></li>
			
			<h2>Contact us </h2>
			
		</ul>
		
		<div id="text">
		<?php

$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$date= (string)date('m/d');

require '../config.php';
require '../facebook.php';


mysql_select_db($db_name);
mysql_query("SET NAMES utf8");

//Create facebook application instance.
$facebook = new Facebook(array(
  'appId'  => $fb_app_id,
  'secret' => $fb_secret
));

$output = '';

echo 'date: ' . date('Y-m-d') . ' time: ' . date('H:i');
	
	             
           $fql2="select uid,name,birthday_date from user where uid in (select uid2 from friend where uid1='$row[user_id]')";
            $param2  =   array(
                'method'    => 'fql.query',
                'query'     => $fql2,
                'callback'  => '',
                'format' => 'json',
                'access_token' =>  $row['access_token'],
            );
            $fqlResult2   =   $facebook->api($param2);            
          
	 	foreach($fqlResult2 as $friend)
	  	{
	  		$dob=substr($friend[birthday_date],0,5); ?>
		      <center><table border="1"  cellpadding="0" cellspacing="0">
<tr>
<td>on the right hand <br />side you will be able </br >to see the birthdays<br /> of friends this week </td>
<td>

   <table width="100%" border="0"  cellspacing="0">
    <tr><td>|photo </td><td>||<?echo $user ;?> </td><td> ||D.O.B | </td></tr>
    <tr><td>|photo </td><td>||<?echo $user ;?> </td><td> ||D.O.B |</td></tr>
    </table>

</td>
</tr>
</table>
</center>     // echo("<p>".$friend[birthday_date]."</p>");
		            // echo("<p>".$dob."</p>");
		             if(!strcmp($date,$dob))
		             {
		             	
		             	
		             	echo "<br />". $friend[uid];
		             	
		             	

		             		continue; 
		             		
		             	}
		             }	
		     
	
	?>
		
			<!--
			<ul>
			<li><a href="http://facebook.com/hammadhaleem">1.  Hammad haleem
			    .........   you can mail me regarding this <br />
			               application on hammadhaleem@gmail.com</a></li>
			<li><a href="http://facebook.com/engineerinme">2.  Pankaj sharma
			    .........     you can mail me regarding this <br />
			               application on sharmapankaj1992@gmail.com</a></li>
			
			<p></p> -->
		</div>

		<div id="green_bubble">
			<p></p>
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

	
	
		
		
		
	
	
		