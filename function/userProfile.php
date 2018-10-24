<?php
require_once "../include/Constants.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
if($_SERVER['REQUEST_METHOD']=='GET'){
	$uname = trim($_GET['username']);
	if(isset($uname)){
		$query = "SELECT * FROM students WHERE s_id = '".$uname."' ";
	    $tbl = mysqli_query($conn, $query);
	    if(mysqli_num_rows($tbl)>0) {
	        $row = mysqli_fetch_array($tbl, MYSQLI_ASSOC);
	        $uid = $row['id'];
			$stmt = $conn->prepare("SELECT id, s_id, CONCAT(firstname, ' ', middlename, '. ', lastname) as fullname FROM students WHERE id = ? LIMIT 1");
	        $stmt->bind_param("s", $uid);
			$stmt->execute();
			$stmt->bind_result($id, $uid, $fullname);
			$profile = array(); 
			//traversing through all the result 
			while($stmt->fetch()){
				$temp = array();
				$temp['id'] = $id; 
				$temp['fullname'] = $fullname; 
				$temp['uid'] = $uid;
				array_push($profile, $temp);
			}
			echo json_encode(array('data' => $profile));
		}else {
			echo json_encode(array('data' => "No Data"));
		}
	}
}