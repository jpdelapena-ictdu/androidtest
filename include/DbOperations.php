<?php 
 
    class DbOperations{
 
        private $conn; 
 
        function __construct(){
 
            require_once dirname(__FILE__).'/DbConnect.php';
 
            $db = new DbConnect();
 
            $this->conn = $db->connect();
 
        }

        
        /*CRUD -> C -> CREATE */
        public function createUser($username, $firstname, $lastname, $middlename, $pass){
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO `students` (`id`, `s_id`, `firstname`, `lastname`, `middlename`, `password`) VALUES (NULL, ?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss",$username, $firstname, $lastname, $middlename, $password);

            if($stmt->execute()){
                return 1; 
            }else{
                return 2; 
            }
        }
 
        /*User Login*/
        public function userLogin($username,$password){
            $stmt = $this->conn->prepare("SELECT id FROM students WHERE s_id = ? AND password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->store_result(); 
            return $stmt->num_rows > 0; 
        }
 
        public function getUserByUsername($username){
            $stmt = $this->conn->prepare("SELECT * FROM students WHERE s_id = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }