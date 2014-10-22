<?php
	/*
		Released under GPLv2.
		@author pankajksharma <sharmapankaj1992 (at) gmail (dot) com>
	*/
	require 'autoload.php';

	\Facebook\FacebookSession::setDefaultApplication('164181646991260', 'a3ab361185e07ce39455e9de9994d197');
	session_start();
	$helper = new \Facebook\FacebookRedirectLoginHelper('http://localhost/Birthday-Bash/test2.php');
	header("Location:".$helper->getLoginUrl(array('user_birthday', 'friends_birthday', 'friends_likes', 'publish_actions'), 'v1.0'));
?>