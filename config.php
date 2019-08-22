<?php
/*
 * Basic Site Settings and API Configuration
 */

// Database configuration
define('DB_HOST', 'MySQL_Database_Host');
define('DB_USERNAME', 'MySQL_Database_Username');
define('DB_PASSWORD', 'MySQL_Database_Password');
define('DB_NAME', 'MySQL_Database_Name');
define('DB_USER_TBL', 'users');


// Facebook API configuration
define('FB_APP_ID', 'Insert_Facebook_App_ID');
define('FB_APP_SECRET', 'Insert_Facebook_App_Secret');
define('FB_REDIRECT_URL', 'Callback_URL');

// Start session
if(!session_id()){
    session_start();
}

// Include the autoloader provided in the SDK
require_once __DIR__ . '/facebook-php-graph-sdk/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

// Call Facebook API
$fb = new Facebook(array(
    'app_id' => FB_APP_ID,
    'app_secret' => FB_APP_SECRET,
    'default_graph_version' => 'v3.2',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
          $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}