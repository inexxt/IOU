<html>
<body>
<?php

session_start();

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/fb/');
require __DIR__ . '/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

$app_id = '360281824177162';
$app_secret = '121b16cc09ab6bcfa05cc43db1b0350a';
FacebookSession::setDefaultApplication($app_id,$app_secret);

try
{
	$helper = new FacebookRedirectLoginHelper('http://localhost/~bandi/auth.php');
} catch(Exception $e) { }

echo '<a href="' . $helper->getLoginUrl() . '">Login with Facebook</a>';

if(array_key_exists("code", $_REQUEST))
{
	$token_url = "https://graph.facebook.com/oauth/access_token?"
. "client_id=" . $app_id . "&redirect_uri=http://localhost/~bandi/auth.php&client_secret=" . $app_secret . "&code=" . $_REQUEST["code"];
	$response = file_get_contents($token_url);
	$params = null;
	parse_str($response, $params);
	$accessToken = $params['access_token'];
	header("Location: index.php?action=auth&accessToken=" . $accessToken);
	exit;
}

?>
</body>
</html>