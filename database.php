<?php

function connect_db()
{
	$con = mysql_connect('localhost','root','');
	$con = mysql_connect('localhost','root','ee==mmcc22');
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,"IOU_database");
	return $con;
}

function createNewUser($graphUser)
{
	$conn = connect_db();
	$sql = "INSERT INTO USERS (UID, name, paid_on_time, not_paid_on_time) VALUES (" . $graphUser->getId() . ", " . $graphUser->getName() . ",0,0)";
	if($conn->query($sql) == TRUE)
		echo "Successfully created user. ";
	else
		echo "Failed creating user. ";
	$conn->close;
}

function pullUserFromDatabase($graphUser)
{
	$con = connect_db();
	$sql = "SELECT * FROM USERS WHERE UID = '" . $graphUser->getId() . "'";

	$result = mysqli_query($con, $sql);
	
	// 0 users found -> create new user
	if(mysql_num_rows($result) == 0)
		createNewUser($graphUser);

	$row = mysqli_fetch_array($result);
	mysqli_close($con);
	return $row;
}