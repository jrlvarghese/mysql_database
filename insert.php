<?php
$username = $_POST['username'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phoneCode = $_POST['phoneCode'];
$phone = $_POST['phone'];

#code to check whether the input paramters are empty or not
if(!empty(username)||!empty(password)||!empty(gender)||!empty(email)||!empty(phoneCode)||!empty(phone)){
	$host = "localhost";
	$dbUsername = "id8506939_nick";
	$dbPassword = "nick12345";
	$dbName = "id8506939_register";
	// Create a connection
	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
	    echo "Connection error";
		die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
	}else{
		$SELECT = "SELECT email From register_table Where email = ? Limit 1";
		$INSERT = "INSERT Into register_table(username, password, gender, email, phoneCode, phone) values(?,?,?,?,?,?)";
		//echo $SELECT;
		// Prepare statement
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;
		if($rnum == 0){
			$stmt->close();
			
			$stmt = $conn->prepare($INSERT);
			$stmt->bind_param("ssssii", $username, $password, $gender, $email, $phoneCode, $phone);
			$stmt->execute();
			echo "New record inserted sucessfully";
		}else{
			echo "Someone already registered using this email";
		}
		$stmt->close();
		$conn->close();
	}
}else{
	# This is server side implementation of mandating all fields;
	# instead this can be implemented at the html end by using the 'required' tag in the <input 'required'>
	echo "All fields are required";
	die();
}
?>