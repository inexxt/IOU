<?php

function connect_db()
{
	$con = mysql_connect('localhost','root','');
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,"IOU_database");
	return $con;
}

function verify($UID, $pass)
{
	$con = connect_db();
	$sql="SELECT * FROM USERS WHERE UID = '".$UID."'";
	$result = mysqli_query($con,$sql);

	while($row = mysqli_fetch_array($result)) {
		mysqli_close($con);
		return $row['FirstName'];
	}
}

function pullUserFromDatabase($id)
{
	$con = connect_db();
	$sql="SELECT rating FROM USERS WHERE UID = '".$id."'";
	$result = mysqli_query($con, $sql);

	while($row = mysqli_fetch_array($result)) {
		mysqli_close($con);
		return $row;
	}
}
