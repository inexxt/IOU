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
		case "NEW_LOAN":
				return array("exit_code"=>createNewEntry($q["fb_name1"], $q["fb_name2"], $q["amount"], $q["due_date"])));
			break;
		case "CHANGE_LOAN":
				return (array("exit_code"=>changeEntry($q["LID"], $q["fb_name1"], $q["fb_name2"], $q["amount"], $q["due_date"], $q["completed"])));
			break;
		case "REVIEW_REQUEST":
				return array("exit_code"=>reviewRequest($q["LID"], $q["action"]));
			break;
	}
}