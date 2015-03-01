<html>
<body>
	<?php
		session_start();

		include("database.php");

		function deal($q, $session)
		{
			switch ($q["ACTION"]) 
			{
				case "PROFILE":
						return pullUserFromDatabase($q["USER"]);
					break;
				case "FRIENDS_LIST":
						return listOfFriends($q["USER"]->getId(), $session);
					break;
				case "LOANS_LIST":
						return listOfLoans($q["USER"]->getId(), $session);
					break;
				case "NEW":
						return array("exit_code"=>createNewLoan($q));
					break;
				case "CHANGE":
						return array("exit_code"=>changeLoan($q["LID"], $q));
					break;
				case "REVIEW_REQUEST":
						return array("exit_code"=>reviewRequest($q["LID"], $q["action"]));
					break;
			}
		}

		define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/fb/');
		require __DIR__ . '/autoload.php';

		use Facebook\FacebookSession;
		use Facebook\FacebookRequest;
		use Facebook\GraphUser;
		use Facebook\FacebookRequestException;
		use Facebook\FacebookRedirectLoginHelper;

		FacebookSession::setDefaultApplication('360281824177162','121b16cc09ab6bcfa05cc43db1b0350a');

		$req = $_REQUEST;

		if(array_key_exists("ACTION", $req) && array_key_exists("ACCESSTOKEN", $req))
		{
			$accessToken = $req["ACCESSTOKEN"];
			$session = new FacebookSession($accessToken);
			switch($req["ACTION"])
			{
				case "AUTH":
					if(is_null($session))
						printf("failed to authenticate");
					else
					{  
						$me = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
						$req["ACTION"] = "PROFILE";
						$req["USER"] = $me;
						$result = deal($req, $session);
						$req["ACTION"] = "LOANS_LIST";
						$result2 = deal($req, $session);
						echo json_encode(array_merge($result, $result2));
					} 
					break;

				default:
					$me = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
					$req["USER"] = $me;
					deal($req, $session);
					break;
			}
		}

	?>
</body>
</html>