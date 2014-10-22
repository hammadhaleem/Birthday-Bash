	
<center><h4>List of friends with birthdays this week </h4><br />
<h5> This would also act as a birthday calendar </h5>
<br /></center><table width="100%" border="1"  cellpadding="0" cellspacing="0">
<tr>
<td>on the right handside you will <br /> be able to see the birthdays<br /> of friends this week </td>
<td>

   <table width="100%" border="0"  cellspacing="0">
   <?php

$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$date= (string)date('m/d');

require '../config.php';
require '../facebook.php';
//mysql_connect($db_host, $db_username, $db_password);
mysql_select_db($db_name);
mysql_query("SET NAMES utf8");
 // .  
//Create facebook application instance.
$facebook = new Facebook(array(
  'appId'  => $fb_app_id,
  'secret' => $fb_secret
));



//if form below is posted- 
//lets try to send wallposts to users walls, 
//which have given us a access_token for that

		
			$user_1=$_SESSION['user_1'];
                         $access=$_SESSION['access'];
           $fql2="select uid,name,birthday_date from user where uid in (select uid2 from friend where uid1='$user_1')";
            $param2  =   array(
                'method'    => 'fql.query',
                'query'     => $fql2,
                'callback'  => '',
                'format' => 'json',
                'access_token' =>     $access,
            );
            $fqlResult2   =   $facebook->api($param2);            
          
	 	foreach($fqlResult2 as $friend)
	  	{
	  		$dob=substr($friend[birthday_date],0,5);
		         //echo("<p>".$friend[birthday_date]."</p>");
		            // echo("<p>".$dob."</p>");
		             if(!strcmp($date,$dob))
		             {
		             	try{
		             	//$facebook->api($friend[uid].'/feed', 'post', $msg);
		             	//echo "<br />". $friend[uid];
		             	$count=$count+1;
		         	$dob=substr($friend[birthday_date],0,5);
                                echo " <tr><td><img  src=\"https://graph.facebook.com/". $friend[uid]."/picture\" ></td><td>  <a href='http://facebook.com/".$friend[uid]."'. target = ' ' >".$friend['name']." </td><td>  ".$dob." </td></tr></a> " ;
		             	}
		             	catch (FacebookApiException $e)
		             	{continue; 	
		             	}           	
		             }

		 }
 
	
	?>

    </table>
 
</td>
</tr>
<tr><td>
<a href= "http://engineerinme.com" target = " "  >Engineernme.com</a> 
</td><td>
<a href= "https://apps.facebook.com/birthday-bash/ "  >click to move to app home page </a>
</td>
</tr>
</table>
<br /><center>
<h3>click on step two tab to move to step two </h3>
