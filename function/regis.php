<?php 
 
require_once '../include/DbOperations.php';
 
$response = array(); 
 
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(
            isset($_POST['username']) and
                isset($_POST['firstname']) and
                isset($_POST['lastname']) and
                isset($_POST['middlename']) and
                    isset($_POST['password']))
        {
        //operate the data further 
 
        $db = new DbOperations(); 
 
        $result = $db->createUser(   
            $_POST['username'],  
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['middlename'],
            $_POST['password']
        );

        if($result == 1){
            $response['error'] = false; 
            $response['message'] = "User registered successfully";
        }elseif($result == 2){
            $response['error'] = true; 
            $response['message'] = "Some error occurred please try again";          
        }
 
    }else{
        $response['error'] = true; 
        $response['message'] = "Required fields are missing";
    }
}else{
    $response['error'] = true; 
    $response['message'] = "Invalid Request";
}
 
echo json_encode($response);