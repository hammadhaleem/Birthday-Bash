<?php
$to="hammadhaleem@facebook.com" ;
$from = "webmaster@facebook.com";
$headers = "From:" . $from;
$body =" SPaM AlErT";
if(mail($to,$subject,$body,$headers))
{
  echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
	
?>