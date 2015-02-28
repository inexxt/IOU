
<?php

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
		unset($row["1UID"], $row["2UID"]);
		$response["borrowers"][] = $row;
	}
	foreach($response as $row) {
		$row["borrower"] = pullUserFromDatabase($row["2UID"])
	}
	
	$sql="SELECT * FROM LOANS WHERE 2UID = '".$id."'";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result)) {
		$response[] = $row;
	}
	foreach($response as $row) {
		unset($row["1UID"], $row["2UID"]);
		$row["lenders"][] = pullUserFromDatabase($row["2UID"])
	}
	
	mysqli_close($con);
	
	return $row;
}

?>
