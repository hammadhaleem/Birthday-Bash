<?php
//https://developers.facebook.com/blog/post/500/
//check this out 
require 'config.php';
require 'facebook.php';


mysql_connect($db_host, $db_username, $db_password);
mysql_select_db($db_name);
mysql_query("SET NAMES utf8");


$facebook = new Facebook(array(
  'appId'  => $fb_app_id,
  'secret' => $fb_secret
));
$result = mysql_query("
		SELECT
			*
		FROM
			offline_access_users
	");
	
	if($result){
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
			$msg['access_token'] = $row['access_token'];
			$msg['from']= $row['user_id'];
			echo $row['verified'];
						
			   	if($row['verified']==0)
					{
						echo " <br/> unverified user  this may case error ";
						mysql_query(
			"INSERT INTO 
				unverified
			SET
				`user_id` = '" . mysql_real_escape_string( $row['user_id']) . "',
				`email` = '" . mysql_real_escape_string( $row['email']) . "',
				`name` = '" . mysql_real_escape_string( $row['name']) . "',
				`access_token` = '" . mysql_real_escape_string($row['access_token']) . "'
		                                                         ");
						mysql_query("DELETE FROM offline_access_users  WHERE verified='0'") ;
			              }	
					
			$user=$row['user_id'];
			mysql_query("UPDATE `offline_access_users` SET `verified`=0 WHERE `user_id`=$user "); 
 	
		   //   	executing facebook query for checking access tokens             
           		$fql2="select uid,name,birthday_date from user where uid in (select uid2 from friend where uid1='$row[user_id]')";
           		 $param2  =   array(
            	         'method'    => 'fql.query',
                         'query'     => $fql2,
                         'callback'  => '',
                        'format' => 'json',
                        'access_token' =>  $row['access_token'],
                           );
                          $fqlResult2   =   $facebook->api($param2);            
                         
	                 mysql_query("UPDATE `offline_access_users` SET `verified`=1 WHERE `user_id`=$user ") ; 
	                 
		}
		

	}
	               	?>
	
	
