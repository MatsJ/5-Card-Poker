<?php
/*
 * This class is used to store and display user's account information. 
 * It allows user to change email, time zone, password, and photo.
 * It also allows user to modify and remove postings. 
 */

class Account {

    private $email;
    private $timeZone;
    private $password;
    //private $photo;

    function __construct($email, $timeZone, $password) {
        $this->email = $email;
        $this->timeZone = $timeZone;
        $this->password = $password;
    }
    
    public function editAccount($conn, $client_id)
    {
        try {
            $sql = "UPDATE client SET email=?, password=? WHERE client_id=?";
            $stmt = $conn->prepare($sql);               
            $stmt->execute(array($this->email, $this->password, $client_id));
           //$stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    public static function removeAccount($conn, $client_id){
                $sql = "DELETE FROM client WHERE client_id = $client_id";
                $stmt = $conn->exec($sql);
                return $stmt;
    }
    
    public function showPosting($conn, $client_id){
        $sql=("SELECT animal_id, name FROM animal WHERE client_id=$client_id");
        $stmt = $conn->query($sql); 
        return $stmt;
        //$row =$stmt->fetchObject();
        //echo $row->animal_id;
    }
    
    public function removePosting($conn, $client_id, $animal_id){
        $sql = "DELETE FROM animal WHERE animal_id=$animal_id";
        $stmt = $conn->exec($sql);
        return $stmt;
    }

}
