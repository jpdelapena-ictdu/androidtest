<?php 
 
require_once "../include/Constants.php";
$timezone = 'Asia/Manila';
date_default_timezone_set($timezone);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($_SERVER['REQUEST_METHOD']=='GET'){
	$uname = trim($_GET['username']);
	$newsFeed_ID = trim($_GET['newsFeed_id']);
	if(isset($uname)){
		$query = "SELECT * FROM students WHERE s_id = '".$uname."' ";
	    $tbl = mysqli_query($conn, $query);
	    if(mysqli_num_rows($tbl)>0) {

			$stmt = $conn->prepare("SELECT id, created_at, title, content FROM announcements WHERE id = ? LIMIT 1");

	        $stmt->bind_param("s", $newsFeed_ID);
	        
			$stmt->execute();

			$stmt->bind_result($id, $timestamp, $title, $content);


			$newFeeds = array(); 

			while($stmt->fetch()){
				$temp = array();
				//TimeToAgo & AgoToDate
				if (date("Y-m-d") == date("Y-m-d", strtotime($timestamp))) {
					$createdAt = timeToAgo($timestamp);
				} else {
					$createdAt = date("F d, Y", strtotime($timestamp)) . ' at ' .date("h:i a", strtotime($timestamp)) ;
				}
				$temp['id'] = $id;
				$temp['created_at'] = $createdAt;
				$temp['title'] = $title;
				$temp['content'] = $content;
				array_push($newFeeds, $temp);
			}

			//displaying the result in json format 
			echo json_encode($newFeeds);
		}else {
			echo json_encode(array('data' => "No Data"));
		}
	}
}

function timeToAgo($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date       = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "ago";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}