<?php
require_once "../include/Constants.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
$stmt = $conn->prepare("SELECT id, logo FROM page_contents");
$stmt->execute();
$stmt->bind_result($id, $logo);
$wallpaper = array(); 
	//traversing through all the result 
	while($stmt->fetch()){
		$temp = array();
		$temp['id'] = $id; 
		$temp['logo'] = $logo;
		array_push($wallpaper, $temp);
	}
echo json_encode(array('data' => $wallpaper));