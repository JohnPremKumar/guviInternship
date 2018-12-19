<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		checkConnection();
}
function test(){
	echo "hai";
}
function checkConnection(){
	$servername = "localhost";
	$username = "root";
	$password = "admin";
	$dbname = "guvi";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}
	else{
		getValues($conn);
	}
	closeConnection($conn);
}

function getValues($conn){
	if(!($stmt = $conn->prepare("SELECT Name,RegisterNo,Email,ContactNo,Age,Department,College FROM class ORDER BY id"))){
		echo "error";
	}
	if(!$stmt->execute()){
		echo "execute error";
	}
	$result = $stmt->get_result();
	$json = array();
	while($row = $result->fetch_assoc()){
		$json[] = array($row["Name"],$row["RegisterNo"],$row["Email"],$row["ContactNo"],$row["Age"],$row["Department"],$row["College"]);
	}
	echo json_encode($json);
}

function closeConnection($conn){
	mysqli_close($conn);
}
?>