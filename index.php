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

FacebookSession::setDefaultApplication('360281824177162','121b16cc09ab6bcfa05cc43db1b0350a');

$req = $_REQUEST;

if(array_key_exists("action", $req) && array_key_exists("accessToken", $req))
{
	$accessToken = $req["accessToken"];
	$session = new FacebookSession($accessToken);
	switch($req["action"])
	{
		case "AUTH":
			if(is_null($session))
				printf("failed to authenticate");
			else
			{  
				$me = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
				$result = array_merge(deal(array("ACTION"=>"PROFILE", "UID"=>$me->getId()), $session), deal(array("ACTION"=>"LOANS_LIST", "UID"=>$me->getId()), $session));
				echo json_encode($result);
			} 
			break;
		default:
			$me = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
			deal(array("ACTION"=>strtoupper($req["action"]), "UID"=>$me->getId(), $session);
			break;
	}
}

?>
</body>
</html>