<?php

function deal($q, $session)
{
	switch ($q["ACTION"]) 
	{
		case "PROFILE":
				return pullUserFromDatabase($q["UID"]);
			break;
		case "FRIENDS_LIST":
				return listOfFriends($q["UID"], $session);
			break;
		case "LOANS_LIST":
				return listOfLoans($q["UID"], $session));
			break;
		case "NEW":
				return array("exit_code"=>createNewLoan($q));
			break;
		case "CHANGE":
				return (array("exit_code"=>changeLoan($q["LID"], $q));
			break;
		case "REVIEW_REQUEST":
				return array("exit_code"=>reviewRequest($q["LID"], $q["action"]));
			break;
	}
}

