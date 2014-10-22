<?php
/**
 * Facebook api and our application config
 */
$fb_app_id  = '164181646991260';
$fb_secret  = '59bff7a0b7013e4dd8b8ac043cc3cce5';
$fb_app_url  = 'http://apps.facebook.com/birthday-bash';
// phpinfo();
$db_host = '127.0.0.1';
$db_name = 'test';
$db_username = '';
$db_password = '';
$con=mysql_connect($db_host, $db_username, $db_password);
if (!$con)
  {
  die('PLEASE RELOAD THE PAGE   Could not connect: ' . mysql_error());
  }
?>