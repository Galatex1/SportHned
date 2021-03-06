<?php
class Users{
    //the database connection variable
    private $con; 

    //inside constructor
    //we are getting the connection link
    function __construct( $con){    
        $this->con = $con; 
    }

/*  The Create Operation 
            The function will insert a new user in our database
        */
        public function createUser($email, $password, $firstname, $lastname){
           if(!$this->isEmailExist($email)){
                $stmt = $this->con->prepare("INSERT INTO users (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $password, $firstname, $lastname);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }
           }
           return USER_EXISTS; 
        }


        /* 
            The Read Operation 
            The function will check if we have the user in database
            and the password matches with the given or not 
            to authenticate the user accordingly    
        */
        public function userLogin($email, $password){
            if($this->isEmailExist($email)){
                $hashed_password = $this->getUsersPasswordByEmail($email); 
                if(password_verify($password, $hashed_password)){
                    return USER_AUTHENTICATED;
                }else{
                    return USER_PASSWORD_DO_NOT_MATCH; 
                }
            }else{
                return USER_NOT_FOUND; 
            }
        }

        /*  
            The method is returning the password of a given user
            to verify the given password is correct or not
        */
        private function getUsersPasswordByEmail($email){
            $stmt = $this->con->prepare("SELECT password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($password);
            $stmt->fetch(); 
            return $password; 
        }

        /*
            The Read Operation
            Function is returning all the users from database
        */
        public function getAllUsers(){
            $stmt = $this->con->prepare("SELECT id, email, firstname, lastname, verified, created FROM users;");
            $stmt->execute(); 
            $stmt->bind_result($id, $email, $firstname, $lastname, $verified, $created);
            $users = array(); 
            while($stmt->fetch()){ 
                $user = array(); 
                $user['id'] = $id; 
                $user['email']=$email; 
                $user['firstname'] = $firstname; 
                $user['lastname'] = $lastname;
                $user['verified'] = $verified; 
                $user['created'] = $created;  
                array_push($users, $user);
            }             
            return $users; 
        }

        /*
            The Read Operation
            This function reads a specified user from database
        */
        public function getUserByEmail($email){
            $stmt = $this->con->prepare("SELECT id, email, firstname, lastname, verified, created FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->bind_result($id, $email, $firstname, $lastname, $verified, $created);
            $stmt->fetch(); 
            $user = array(); 
            $user['id'] = $id; 
            $user['email']= $email; 
            $user['firstname'] = $firstname; 
            $user['lastname'] = $lastname;
            $user['verified'] = $verified; 
            $user['created'] = $created;  
            return $user; 
        }


        /*
            The Update Operation
            The function will update an existing user
            from the database 
        */
        public function updateUser($email, $firstname, $lastname, $id){
            $stmt = $this->con->prepare("UPDATE users SET email = ?, firstname = ?, lastname = ? WHERE id = ?");
            $stmt->bind_param("sssi", $email, $firstname, $lastname, $id);
            if($stmt->execute())
                return true; 
            return false; 
        }

        /*
            The Update Operation
            This function will update the password for a specified user
        */
        public function updatePassword($currentpassword, $newpassword, $email){
            $hashed_password = $this->getUsersPasswordByEmail($email);
            
            if(password_verify($currentpassword, $hashed_password)){
                
                $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt = $this->con->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->bind_param("ss",$hash_password, $email);
                if($stmt->execute())
                    return PASSWORD_CHANGED;
                return PASSWORD_NOT_CHANGED;
            }else{
                return PASSWORD_DO_NOT_MATCH; 
            }
        }

        /*
            The Delete Operation
            This function will delete the user from database
        */
        public function deleteUser($id){
            $stmt = $this->con->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            if($stmt->execute())
                return true; 
            return false; 
        }


        /*
            The Update Operation
            This function will set verified state to user
        */
        public function setVerified($id, $verified){
            $stmt = $this->con->prepare("UPDATE users SET verified = ? WHERE id = ?");
            $stmt->bind_param("ii", $verified, $id);
            if($stmt->execute())
                return true; 
            return false; 
        }

        /*
            The Read Operation
            The function is checking if the user exist in the database or not
        */
        private function isEmailExist($email){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }

        public function userExists($id){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }
}