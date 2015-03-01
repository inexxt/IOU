<?php

require_once("database.php");

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

function userProfile($id, $session)
{
	$request = new FacebookRequest(
		$session,
		'GET',
		'/me'
	);
	$response = $request->execute();
	$userProfile = $response->getGraphObject();
	$userProfile["rating"] = pullUserFromDatabase($id)["rating"];
	return $userProfile;
}

function listOfFriends($id, $session)
{
	$request = new FacebookRequest(
		$session,
		'GET',
		'/me/friends'
	);

	$response = $request->execute();
	$friends = $response->getGraphObject();

	$responce_friends = array();
	
	foreach ($friends["data"] as $value)
	{
		$friend = array (
						"id" => $value["id"],
						"name" => $value["name"],
						"rating" => pullUserFromDatabase($id)["rating"],
						);
		$responce_friends[] = $friend;
	}
	return $responce_friends;
}


function listOfLoans($id, $session)
{
	$con = connect_db();
	
	$sql = "SELECT * FROM LOANS WHERE 1UID = '".$id."'";
	$result = mysqli_query($con, $sql);

	$response = array();

	while($row = mysqli_fetch_array($result)) 
	{
		$response[] = $row;
	}
	foreach($response as $row)
	{
		$row["borrower"][] = pullUserFromDatabase($row["2UID"]);
		//unset($row["1UID"], $row["2UID"]);
	}
	
	$sql="SELECT * FROM LOANS WHERE 2UID = '".$id."'";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result)) {
		$response[] = $row;
	}
	foreach($response as $row)
	{
		$row["lender"][] = pullUserFromDatabase($row["2UID"]);
		//unset($row["1UID"]);
		//unset($row["2UID"]);
	}
	
	mysqli_close($con);
	return $response;
}


function listOfHistoryLoans($id, $session)
{
	$con = connect_db();
	
	$sql="SELECT * FROM LOANS WHERE (1UID = '".$id."' 2UID = '".$id."') AND COMPLETED = 1";
	$result = mysqli_query($con, $sql);

	while($row = mysqli_fetch_array($result)) 
	{
		$response[] = $row;
	}
	
	mysqli_close($con);
	return $response;
}

function createNewLoan($q)
{
	$con = connect_db();
	print("bb\n</br>");
	$idList = array_values($q);
	
	unset($q["ACCESSTOKEN"]);
	unset($q["USER"]);
	unset($q["ACTION"]);
	
	print_r($q);
	foreach($idList as $v)
	{
		print_r($v);
		print("</br>");
	}
	$sql="INSERT INTO LOANS (".implode(',',array_keys($q)).") VALUES ('".implode("','",array_values($q))."')";
	print($sql);
	$result = mysqli_query($con, $sql);
	print($result);
	return $result;
}

?>
