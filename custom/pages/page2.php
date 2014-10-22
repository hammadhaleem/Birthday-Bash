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


  
  $filename=$_FILES["file"]["name"];
// echo "Upload: " . $_FILES["file"]["name"] . "<br />";
// echo "Type: " . $_FILES["file"]["type"] . "<br />";
 //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
// echo "Stored in: " . $_FILES["file"]["tmp_name"];
 $ext=end(explode('.',$filename));
  if($ext=='jpeg'||$ext=='jpg'||$ext=='png'||$ext=='jpg')
  {
  $filename=time().$filename;
$savepath='/upload/'.$filename;
  //echo $savepath;
   $isupload=move_uploaded_file($_FILES["file"]["tmp_name"],"./upload/".$filename) or die("Failed to upload file");
  
    $savepath="/upload/".$filename."/";
  // echo $savepath;
  // echo $isupload;
   if($isupload)
   {$msg='image uploaded';}
   else
   {$mgs='some error <br /> try again ';}
   }
    else
   {$mgs='some error <br /> try again<br />unsupported file type ';}
   
   
  
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
	
?>
<?php /*
$result = mysql_query(
		"SELECT
			`custom_image`
		FROM
			offline_access_users
		WHERE
				`user_id` = " .$user . "
		");
$row = mysql_fetch_array($result, MYSQL_ASSOC);


echo $user;
echo "<br />";
echo $row[`custom_image`];
echo "<img src=\".".$row[`custom_image`]." \" /> ";

*/
?>
                                                                                                          <!-- start of page -->
<script type="text/javascript">

var myform=new formtowizard({
	formid: 'feedbackform',
	persistsection: true,
	revealfx: ['slide', 500]
})

</script>



<form id="feedbackform"  action="?check" method="POST"  enctype="multipart/form-data"  >



<fieldset class="sectionwrap">
<legend>image upload</legend>


 <form name="newad" method="post" enctype="multipart/form-data"  action="">
 <table>
 	<tr><td><input type="file" name="file"></td></tr>
 	<tr><td>         <input name="Submit" type="submit" value="CLICK HERE TO COMPLETE THE SUBMISSION OF THIS FORM ">                 </td></tr>
 </table>	


