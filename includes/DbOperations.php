<?php
    require 'tables/Tusers.php';

    class DbOperations{


        private static $DB = false;  
        //the database connection variable
        private $con;
        public $users; 

        //inside constructor
        //we are getting the connection link
        function __construct(){
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect; 
            $this->con = $db->connect();
            $this->users = new Users($this->con); 
        }

        public static function getDB()
        { 
          if(self::$DB === false)
          { 
            self::$DB = new DbOperations(); 
          } 
      
          return self::$DB; 
        } 

    }