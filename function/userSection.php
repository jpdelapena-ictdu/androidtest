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
			$stmt = $conn->prepare("SELECT students.id, section_student.section_id AS sectionID, sections.name AS section_name, years.name AS year_level, CONCAT(academic_years.start, '-', academic_years.end) AS school_year FROM students INNER JOIN section_student ON students.id = section_student.student_id INNER JOIN sections ON section_student.section_id = sections.id INNER JOIN years ON sections.year_id = years.id INNER JOIN academic_years ON sections.academic_year_id = academic_years.id WHERE students.id = ?");

	        $stmt->bind_param("s", $uid);

			$stmt->execute();

			$stmt->bind_result($id, $sectionId, $section, $year_level, $school_year);

			$sections = array(); 

			//traversing through all the result 
			while($stmt->fetch()){
				$temp = array();
				$temp['id'] = $id; 
				$temp['section_id'] = $sectionId;
				$temp['section'] = $section; 
				$temp['year_level'] = $year_level; 
				$temp['school_year'] = $school_year; 
				array_push($sections, $temp);
			}
			//echo json_encode($sections);
			echo json_encode(array('data' => $sections));
		}else {
			echo json_encode(array('data' => "No Data"));
		}

			//displaying the result in json format 
	}
}


/*require_once "../include/Constants.php";
require_once '../include/DbOperations.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array(); 

if($_SERVER['REQUEST_METHOD']=='GET'){
	$uname = trim($_GET['id']);
    if(isset($uname)){
		$sql_query = "SELECT students.id, sections.name AS section_name, years.name AS year_level, CONCAT(academic_years.start, '-', academic_years.end) AS school_year FROM students INNER JOIN section_student ON students.id = section_student.student_id INNER JOIN sections ON section_student.section_id = sections.id INNER JOIN years ON sections.year_id = years.id INNER JOIN academic_years ON sections.academic_year_id = academic_years.id WHERE students.id = '$uname'";
		$result = mysqli_query($conn, $sql_query);

		if(mysqli_num_rows($result) > 0) {
			$response['success'] = 1;
			$sections = array();
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($sections, $row);
			}
			$response['sections'] = $sections;
		}else {
			$response['success'] = 0;
			$response['message'] = 'No Data';
		}
		echo json_encode($response);
	}
}
?>*/