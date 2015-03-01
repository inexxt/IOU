<html>
<body>
	<?php
		session_start();

		require_once("database.php");

		function deal($q, $session)
		{
			switch ($q["ACTION"]) 
			{
				case "PROFILE":
						return pullUserFromDatabase($q["USER"], $session);
					break;
				case "FRIENDS_LIST":
						return listOfFriends($q["USER"]->getId(), $session);
					break;
				case "LOANS_LIST":
						return listOfLoans($q["USER"]->getId(), $session);
						print_r($q);
					break;
				case "NEW_LOAN":
						return array("exit_code"=>createNewLoan($q));
					break;
				case "CHANGE_LOAN":
						return array("exit_code"=>changeLoan($q["LID"], $q));
					break;
				case "REVIEW_LOAN":
						return array("exit_code"=>reviewRequest($q["LID"], $q["action"]));
					break;
			}
		}

		use Facebook\FacebookSession;
		use Facebook\FacebookRequest;
		use Facebook\GraphUser;
		use Facebook\FacebookRequestException;
		use Facebook\FacebookRedirectLoginHelper;

		FacebookSession::setDefaultApplication('360281824177162','121b16cc09ab6bcfa05cc43db1b0350a');

		$req = $_POST;
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
						$req["ACCESSTOKEN"] = $accessToken;
						$result = deal($req, $session);
						$req["ACTION"] = "LOANS_LIST";
						$result2 = deal($req, $session);

						echo json_encode(array($result, $result2));
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