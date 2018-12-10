<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		checkConnection();
}

function test(){
	echo "shit its working";
}

function checkConnection(){
	$servername = "localhost";
	$username = "root";
	$password = "admin";
	$dbname = "guvi";
	$conn = mysqli_connect($servername, $username, $password,$dbname);
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	if($_POST["submit"] == "signup"){
		$status = checkExist($conn);
		if(!$status){
			$insertState = insertData($conn);
			echo $insertState;
		}
		else{
			echo "User already registered";
		}
	}
	else if($_POST["submit"] == "login"){
		$status = checkExist($conn);
		if($status){
			$valid = validateLogin($conn);
			if($valid){
				sessionHandle();
				echo "Login successful";
			}
			else{
				echo "Invalid email or password";
			}
		}
		else{
			echo "Not registered yet?";
		}
	}
	else if($_POST["submit"] == "load"){
		session_start();
		if(isset($_SESSION["user"])){
			echo $_SESSION["user"];
		}
		else{
			echo "You need to login first";
		}
	}
	else if($_POST["submit"] == "update"){
		$upcheck = updateData($conn);
		echo $upcheck;
	}
	else if($_POST["submit"] == "logout"){
		session_start();
		session_destroy();
		if(!isset($_SESSION["user"])){
			echo "logout successful";
		}
	}
	closeConnection($conn);	
}

function updateData($conn){
	session_start();
	$name = $_POST["name"];
	$email = $_POST["email"];
	$age = $_POST["age"];
	$contact = $_POST["contact"];
	$degree = $_POST["degree"];
	$department = $_POST["department"];
	$gender = $_POST["gender"];
	$college = $_POST["college"];
	$user = $_SESSION["user"];
	if(!($stmt = $conn->prepare("UPDATE users SET username=?,email=?,age=?,contact=?,degree=?,
			department=?,gender=?,college=? WHERE email=?"))){
		return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if (!$stmt->bind_param("ssissssss",$name,$email,$age,$contact,$degree,$department,$gender,$college,$user)) {
    	return "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
    	return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->get_result();
	$response = array('name' => $name,'email' => $email,'age' => $age,'contact' => $contact,'degree' => $degree,
						'department' => $department,'gender' => $gender,'college' => $college);
	$_SESSION["user"] = $email;
	$fp = fopen($email.".json", 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);
	return "Data updation successful";
}

function sessionHandle(){
	session_start();
	$_SESSION["user"] = $_POST["email"];
}

function validateLogin($conn){
	$email = $_POST["email"];
	$pass = $_POST["pass"];
	if(!($stmt = $conn->prepare("SELECT password FROM users WHERE email = ?"))){
		return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if (!$stmt->bind_param("s",$email)) {
    	return "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
    	return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->get_result();
	$row = mysqli_fetch_assoc($result);
	if($row["password"] == $pass){
		return true;
	}
	return false;
}

function checkExist($conn){
	$email = $_POST["email"];
	if(!($stmt = $conn->prepare("SELECT email FROM users WHERE email = ?"))){
		return false;
	}
	if (!$stmt->bind_param("s",$email)) {
    	return false;
	}

	if (!$stmt->execute()) {
    	return false;
	}
	$result = $stmt->get_result();
	if(mysqli_num_rows($result) > 0){
		return true;
	}
	return false;
}
function createDatabase(){
	$sql = "CREATE DATABASE testDB";
	if ($conn->query($sql) === TRUE) {
    	echo "Database created successfully";
	} else {
    	echo "Error creating database: " . $conn->error;
	}
}

function insertData($conn){
	$name = $_POST["name"];
	$email = $_POST["email"];
	$password = $_POST["npass"];
	if(!($stmt = $conn->prepare("INSERT INTO users (username,password,email) VALUES (?,?,?)"))){
		return "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}
	if (!$stmt->bind_param("sss",$name,$password,$email)) {
    	return "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if (!$stmt->execute()) {
    	return "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	$result = $stmt->get_result();
	$response = array('name' => $name,'email' => $email );
	//$response[] = array_map('utf8_encode', $response);
	$fp = fopen($email.".json", 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);
	return "Signup successful";
}

function closeConnection($conn){
	mysqli_close($conn);
}

?>