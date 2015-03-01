<?php

function deal($q, $session)
{
// 	if(!verify($q["UID"], $q["our_cookie"]) return json_encode(array("exit_code"=>-1));

	switch ($q["ACTION"]) 
	{
		case "PROFILE":
				return userProfile($q["UID"], $session);
			break;
		case "FRIENDS_LIST":
				return listOfFriends($q["UID"], $session);
			break;
		case "LOANS_LIST":
				return listOfLoans($q["UID"], $session));
			break;
		case "NEW":
				return array("exit_code"=>createNewLoan($q["fb_name1"], $q["fb_name2"], $q["amount"], $q["due_date"])));
			break;
		case "CHANGE":
				return (array("exit_code"=>changeLoan($q["LID"], $q["fb_name1"], $q["fb_name2"], $q["amount"], $q["due_date"], $q["completed"])));
			break;
		case "REVIEW_REQUEST":
				return array("exit_code"=>reviewRequest($q["LID"], $q["action"]));
			break;
	}
}
