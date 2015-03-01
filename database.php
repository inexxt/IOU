<?php

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/fb/');
require __DIR__ . '/autoload.php';

require_once("friends_list.php");

function connect_db()
{
	$con = mysqli_connect('localhost','root','ee==mmcc22') or die('Could not connect: ' . mysqli_error($con));
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

function pullUserFromDatabase($graphUser)
{
	$con = connect_db();
	$sql = "SELECT * FROM USERS WHERE UID = '" . $graphUser->getId() . "'";

	$result = mysqli_query($con, $sql);
	
	// 0 users found -> create new user
	$rowcount = mysqli_num_rows($result);

	if($rowcount == 0)
		createNewUser($graphUser);

	$row = mysqli_fetch_array($result);
	mysqli_close($con);
	return $row;
}