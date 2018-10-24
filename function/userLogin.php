<?php 
require_once "../include/Constants.php";
require_once '../include/DbOperations.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

    $username = strip_tags(mysqli_real_escape_string($conn, trim($_POST['username'])));
    $password = strip_tags(mysqli_real_escape_string($conn, trim($_POST['password'])));

    $query = "SELECT * FROM students WHERE s_id = '".$username."' ";
    $tbl = mysqli_query($conn, $query);
    if(mysqli_num_rows($tbl)>0) {
        //when email is matched it also need to verify the password
        $row = mysqli_fetch_array($tbl, MYSQLI_ASSOC);
        $password_hash = $row['password'];
        if(password_verify($password, $password_hash)) {

            $db = new DbOperations(); 
 
            if($db->userLogin($username,$password_hash)){
                $user = $db->getUserByUsername($username);
                $response['error'] = false; 
                $response['id'] = $user['id'];
                $response['firstname'] = $user['firstname'];
                $response['lastname'] = $user['lastname'];
                $response['middlename'] = $user['middlename'];
                $response['s_id'] = $user['s_id'];
            }else{
                $response['error'] = true; 
                $response['message'] = "Invalid username or password";          
            }

        }else {
            $response['error'] = true; 
            $response['message'] = "Invalid username or password";    
        }
    }else {
        $response['error'] = true; 
        $response['message'] = "Invalid username or password";    
    }
}

echo json_encode($response);









/*require_once '../include/DbOperations.php';
 
$response = array(); 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if(isset($username) and isset($password)){
        $db = new DbOperations(); 
 
        if($db->userLogin($username, $password)){
            $user = $db->getUserByUsername($username);
            $response['error'] = false; 
            $response['id'] = $user['id'];
            $response['firstname'] = $user['firstname'];
            $response['lastname'] = $user['lastname'];
            $response['middlename'] = $user['middlename'];
            $response['s_id'] = $user['s_id'];
        }else{
            $response['error'] = true; 
            $response['message'] = "Invalid username or password";          
        }
 
    }else{
        $response['error'] = true; 
        $response['message'] = "Required fields are missing";
    }
}
 
echo json_encode($response);*/