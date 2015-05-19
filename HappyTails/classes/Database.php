<?php

/*
 * This class is called by all the other classes wishing to connect to database.
 * It consists all the four major database functions: Create, Retrieve, Update, 
 * and Delete 
 */

class Database extends PDO {

   public $conn;
    
    function __construct(){
        // emtpy constructor
    }

    // function to connect to the database
    public function connect() {
        /*         * *****************Login info ***************** */
        $username = "s15g04";
        $password = "puppy_Love2!";

        try {
            $this->conn = new PDO('mysql:host=sfsuswe.com;dbname=student_s15g04', $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        
        return $this->conn;
    }

    // function to disconnect from the database
    public function disconnect() {
        try {
            $this->conn = null;
            return $this->conn;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    

}
