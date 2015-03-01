
<?php

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/fb/');
require __DIR__ . '/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

include("database.php");

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
	
	foreach ($friends["data"] as $value) {
		$friend = array (
						"id" = $value["id"],
						"name" = $value["name"],
						"rating" = pullUserFromDatabase($id)["rating"],
						);
		$responce_friends[] = $friend;
	}
	return $responce_friends;
}


function listOfLoans($id, $session)
{
	$con = connect_db();
	
	$sql="SELECT * FROM LOANS WHERE 1UID = '".$id."'";
	$result = mysqli_query($con, $sql);

	while($row = mysqli_fetch_array($result)) 
	{
		$response["borrowers"][] = $row;
	}
	foreach($response as $row) {
		$row["borrower"][] = pullUserFromDatabase($row["2UID"])
		unset($row["1UID"], $row["2UID"]);
	}
	
	$sql="SELECT * FROM LOANS WHERE 2UID = '".$id."'";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result)) {
		$response[] = $row;
	}
	foreach($response as $row) {
		$row["lender"][] = pullUserFromDatabase($row["2UID"])
		unset($row["1UID"], $row["2UID"]);
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
	
	$sql="INSERT INTO LOANS WHERE VALUES ".array_values($q);
	$result = mysqli_query($con, $sql);
	return $result;
}

?>
