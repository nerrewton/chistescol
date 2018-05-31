<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//incude data-fb
include_once 'data-fb.php';
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
//FacebookSession::setDefaultApplication( 'Your APP ID','Your APP Secret' );
//echo "appid: ".$AppId_fb." appSecret:  ".$AppSecret_fb."url: ".$UrlHostRedirect;
FacebookSession::setDefaultApplication( $AppId_fb, $AppSecret_fb );
// login helper with redirect_uri
    //$helper = new FacebookRedirectLoginHelper($UrlHostRedirect.'/fbconfig.php' );
    $helper = new FacebookRedirectLoginHelper('http://chistescol.com' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?fields=name,email,id,about,gender' );
  $response = $request->execute();

  // get response
      $graphObject = $response->getGraphObject();
      //$fbuname = $graphObject->getProperty('username');  // To Get Facebook Username
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $fbemail = $graphObject->getProperty('email');    // To Get Facebook email ID
      $fbgender = $graphObject->getProperty('gender');    // To Get Facebook gender
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;
      $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $fbemail;
      $_SESSION['GENDER'] = $fbgender;
  /* ---- header location after session ----*/
  header("Location: ../index.php");
} else {
  $params = array(
    'req_perms' => 'email, public_profile'
  );
  $loginUrl = $helper->getLoginUrl(array('scope' => 'email'));
 header("Location: ".$loginUrl);
}
?>
