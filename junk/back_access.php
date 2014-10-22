<?php
require 'config.php';
  require 'facebook.php';

 $app_id = "164181646991260";
 $app_secret = "59bff7a0b7013e4dd8b8ac043cc3cce5"; 
  $my_url = "http://apps.facebook.com/birthday-bash/";
     
  // known valid access token stored in a database 
  $access_token = "164181646991260|6d2b9d48539724573ffda895.1-1175675036|6n0dqs-znwBryy7m7yN6h1zrOf8";

  $code = $_REQUEST["code"];
   	
  // If we get a code, it means that we have re-authed the user 
  //and can get a valid access_token. 
  if (isset($code)) {
    $token_url="https://graph.facebook.com/oauth/access_token?client_id="
      . $app_id . "&redirect_uri=" . urlencode($my_url) 
      . "&client_secret=" . $app_secret 
      . "&code=" . $code . "&display=popup";
    $response = file_get_contents($token_url);
    $params = null;
    parse_str($response, $params);
    $access_token = $params['access_token'];
  }

  		
  // Attempt to query the graph:
  $graph_url = "https://graph.facebook.com/me?"
    . "access_token=" . $access_token;
  $response = curl_get_file_contents($graph_url);
  $decoded_response = json_decode($response);
	
  //Check for errors 
  if ($decoded_response->error) {
  // check to see if this is an oAuth error:
    if ($decoded_response->error->type== "OAuthException") {
      // Retrieving a valid access token. 
      $dialog_url= "https://www.facebook.com/dialog/oauth?"
        . "client_id=" . $app_id 
        . "&redirect_uri=" . urlencode($my_url);
      echo("<script> top.location.href='" . $dialog_url 
      . "'</script>");
    }
    else {
      echo "other error has happened";
    }
  } 
  else {
  // success
    echo("success" . $decoded_response->name);
    echo($access_token);
  }

  // note this wrapper function exists in order to circumvent PHP’s 
  //strict obeying of HTTP error codes.  In this case, Facebook 
  //returns error code 400 which PHP obeys and wipes out 
  //the response.
  function curl_get_file_contents($URL) {
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
    curl_close($c);
    if ($contents) return $contents;
    else return FALSE;
  }
?>
<html>
<head></head>
<body>
<!--
<div id="fb-root"></div>
<button id="fb-login" onclick="login()">Login</button>
<script>
  var button = document.getElementById('fb-login');

  // For help with AJAX, see http://www.w3schools.com/Ajax/Default.Asp
  function checkNonce(access_token) {
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
          if (xmlhttp.responseText == 1) {
            console.log('The user has been successfully ' +
                               're-authenticated.');
          } else {
            console.log('The nonce has been used before. ' +
                               'Re-authentication failed.');
          }
        }
    }
    xmlhttp.open('POST','checkNonce.php',true);
    xmlhttp.setRequestHeader('Content-type',
      'application/x-www-form-urlencoded');
    xmlhttp.send('access_token=' + access_token);
  }

  function login(){
    FB.login(function(response) {
      if (response) {
        console.log('Login success. Checking auth_nonce...');
        checkNonce(response.session.access_token);
      } else {
          console.log('Login cancelled.')
      }
    }, { auth_type: 'reauthenticate', auth_nonce: 'abcd1234' });
  }

  window.fbAsyncInit = function() {
    FB.init({appId: 'YOUR_APP_ID', status: true, cookie: true,
             xfbml: true});
    FB.getLoginStatus(function(response) {
      if (response.session) {
        button.innerHTML = 'Re-Authenticate';
        console.log('User is logged in.');
      } else {
          console.log('User is not logged in.');
      }
    });
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
</body>
</html> -->