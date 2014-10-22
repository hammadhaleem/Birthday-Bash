<?php

$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
$date= (string)date('m/d');

require 'config.php';
require 'facebook.php';
$count=0;
$count1=0;
//connect to mysql database
//mysql_connect($db_host, $db_username, $db_password);
mysql_select_db($db_name);
mysql_query("SET NAMES utf8");

//Create facebook application instance.
$facebook = new Facebook(array(
  'appId'  => $fb_app_id,
  'secret' => $fb_secret
));

$output = '';

//if form below is posted- 
//lets try to send wallposts to users walls, 
//which have given us a access_token for that
echo 'date: ' . date('Y-m-d') . ' time: ' . date('H:i');

	
	//default message/post
	$msg =  array(
		
		'message'=>'Wishing you a very Happy Birthday!'
	);
	
	
	$result = mysql_query("
		SELECT
			*
		FROM
			offline_access_users
	");
	echo "<center> EACH TIME A RANDOM NUMBER IS SHOWN IT MEANS LOOP EXECUTED FOR ONE USER</center>";
	echo "<center>EACH TIME UID IS SHOWN IT MEANS THAT ONE USER IS WISHED</center>";
	if($result){
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$msg['access_token'] = $row['access_token'];
			$msg['from']= $row['user_id'];
			$count1=$count1 + 1;
			
srand ((double) microtime( )*1000000);
$random_number = rand(0,10);
echo $random_number ;
echo "<br />";
if($random_number!="NULL" || $random_number==0 )
{
switch ($random_number)
 {
    case 0:
        $msg['picture']="http://apps.engineerinme.com/bash/cards/card1.jpg";
        break;
    case 1:
        $msg['picture']="http://apps.engineerinme.com/bash/cards/card2.jpg";
        break;
    case 2:
        $msg['picture']="http://apps.engineerinme.com/bash/cards/card3.jpg";
        break;
    case 3:
      $msg['picture']="http://apps.engineerinme.com/bash/cards/card4.jpg";
        break;
    case 4:
       $msg['picture']="http://apps.engineerinme.com/bash/cards/card5.jpg";
        break;
    case 5:
       $msg['picture']="http://apps.engineerinme.com/bash/cards/card6.jpg";
        break;
    case 6:
       $msg['picture']="http://apps.engineerinme.com/bash/cards/card7.jpg";
        break;
    case 7:
       $msg['picture']="http://apps.engineerinme.com/bash/cards/card8.jpg";
        break;
    case 8:
       $msg['picture']="http://apps.engineerinme.com/bash/cards/card9.jpg";
        break;
    case 9:
      $msg['picture']="http://apps.engineerinme.com/bash/cards/card10.jpg";
    case 10:
      $msg['picture']="http://apps.engineerinme.com/bash/cards/card11.jpg";
        break;
        
}
}
else
{ 
echo "prob in random ";
}





	            
	             
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
	  		$dob=substr($friend[birthday_date],0,5);
		           // echo("<p>".$friend[birthday_date]."</p>");
		            // echo("<p>".$dob."</p>");
		             if(!strcmp($date,$dob))
		             {
		             	try{
		             	$facebook->api($friend[uid].'/feed', 'post', $msg);
		             	echo "<br />". $friend[uid];
		             	$count=$count+1;
		             	}
		             	catch (FacebookApiException $e)
		             	{

$to="hammadapj@gmail.com";		
$subject = "Facebook important message -- facebook apps";
$body = "error in uid =".$row[user_id]."/n".$e."\n\n sample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample text";
$from = "webmaster@birthday-bash";
$headers = "From:" . $from;

if(mail($to,$subject,$body,$headers))
{
  echo("<p>Message successfully sent!</p>");
     } else {
   echo("<p>Message delivery failed...</p>");
   }
		             		
		             		
		             	}
		             }	
		 }          
	            
	              
		}
	}
	?>
	
<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="et" lang="en">
	<head>
		<title>Posting</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
			body { font-family:Verdana,"Lucida Grande",Lucida,sans-serif; font-size: 12px}
		</style>
	</head>
	<body>
		
		<?php  echo $count;

$to="hammadapj@gmail.com";		
$subject = "Facebook important message -- facebook apps";
$body = " mail this no of people ".$count."\n  users accessed ".$count1."\n\nsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample textsample text";
$from = "webmaster@birthday-bash";
$headers = "From:" . $from;

if(mail($to,$subject,$body,$headers))
{
  echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
		 ?>
		 
	</body>
</html>