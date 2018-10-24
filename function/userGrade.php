<?php
require_once "../include/Constants.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
if($_SERVER['REQUEST_METHOD']=='GET'){
	$uname = trim($_GET['username']);
	$usection = trim($_GET['section_id']);

	if(isset($uname)){
		$query = "SELECT * FROM students WHERE s_id = '".$uname."' ";
	    $tbl = mysqli_query($conn, $query);
	    if(mysqli_num_rows($tbl)>0) {
	        $row = mysqli_fetch_array($tbl, MYSQLI_ASSOC);
	        $uid = $row['id'];

	        $stmt = $conn->prepare("SELECT students.id, sections.name AS section_name, subjects.name as subject, grade, CONCAT(teachers.firstname, ' ', teachers.lastname) AS teacher_name FROM grades INNER JOIN students ON students.id = student_id INNER JOIN sections ON sections.id = grades.section_id INNER JOIN subjects ON subjects.id = grades.subject_id INNER JOIN teachers ON teachers.id = teacher_id WHERE grades.student_id = ? AND grades.section_id = ?");

	        $stmt->bind_param("ss", $uid, $usection);

			$stmt->execute();

			$stmt->bind_result($id, $subject, $section, $grade, $teachers);

			$studGrades = array(); 

			//traversing through all the result 
			while($stmt->fetch()){
				$temp = array();
				$temp['id'] = $id; 
				$temp['section'] = $section; 
				$temp['subject'] = $subject;
				$temp['grade'] = $grade; 
				$temp['teacher'] = $teachers; 
				array_push($studGrades, $temp);
			}
			//echo json_encode($sections);
			echo json_encode(array('data' => $studGrades));
		}else {
			echo json_encode(array('data' => "No Data"));
		}
	}
}