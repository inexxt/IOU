<?php

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/fb/');
require __DIR__ . '/autoload.php';

require_once("friends_list.php");

function connect_db()
{
	$con = mysqli_connect('localhost','root','') or die('Could not connect: ' . mysqli_error($con));
	mysqli_select_db($con,"IOU_database");
	return $con;
}

function createNewUser($graphUser)
{
	$conn = connect_db();
	$sql = "INSERT INTO USERS VALUES ('" . $graphUser->getId() . "', '" . $graphUser->getName() . "',0,0)";
	if(!$conn->query($sql))
		echo "Failed creating user. " . $conn->error;
	$conn->close();
}

function calculateTotal($id, $session, $which)
{
	$list = listOfLoans($id, $session);
	$borrowSum = 0;
	$owedSum = 0;
	if($which == "Owed")
	{
		foreach($list["borrower"] as $bor)
		{
			$borrowedSum += $bor["amount"];
		}
		return $borrowedSum;
	}
	
	if($which == "Borrowed")
	{
		foreach($list["lender"] as $bor)
		{
			$owedSum += $bor["amount"];
		}
		return $owedSum;
	}
}

function pullUserFromDatabase($graphUser, $session)
{
	$con = connect_db();
	$sql = "SELECT * FROM USERS WHERE UID = '" . $graphUser->getId() . "'";

	$result = mysqli_query($con, $sql);
	
	// 0 users found -> create new user
	$rowcount = mysqli_num_rows($result);

	if($rowcount == 0)
		createNewUser($graphUser);

	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	mysqli_close($con);
	$row[] = $graphUser;
	$row["totalOwed"] = calculateTotal($graphUser->getId, $session, "Owed");
	$row["totalBorrowed"] = calculateTotal($graphUser->getId, $session, "Borrowed");
	return $row;
}