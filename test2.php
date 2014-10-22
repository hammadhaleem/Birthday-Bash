<?php
	/*
		Released under GPLv2.
		@author pankajksharma <sharmapankaj1992 (at) gmail (dot) com>
	*/
	require 'autoload.php';

	\Facebook\FacebookSession::setDefaultApplication('164181646991260', 'a3ab361185e07ce39455e9de9994d197');
	session_start();
	date_default_timezone_set('UTC');
	$helper = new \Facebook\FacebookRedirectLoginHelper('http://localhost/Birthday-Bash/test2.php');
	try {
	  $session = $helper->getSessionFromRedirect();
	} catch(\Facebook\FacebookRequestException $ex) {
		print_r($ex);
	} catch(\Exception $ex) {
		print_r($ex);
	}
	if ($session) {
		//Let's be gready and get a new Token
		$longAccessToken = $session->getAccessToken()->extend('164181646991260', 'a3ab361185e07ce39455e9de9994d197');
		if ($longAccessToken) {
			//Sometimes you get lucky, make sure you save those things
			$_SESSION['fb_access_token'] = (string) $longAccessToken;
			echo $longAccessToken;
		}
	}
	echo "<br><br>";
	$request = new \Facebook\FacebookRequest($session, 'POST', '/100002395423625/photos',
		array(
			'source' => '@image.jpg',
			'message' => 'Happy Teachers day',
		)
	);
	$response = $request->execute();
	$graphObject = $response->getGraphObject();
	print_r($graphObject);
?>