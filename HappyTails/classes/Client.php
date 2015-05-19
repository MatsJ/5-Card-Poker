<?php

/**
 * Used to long register and verify user accounts
 * 
 * Holds all the information of a User's account.
 * can be passed to the database functions to add a new account,
 * remove an existing account, modify an account, and verify and accounts
 * validity.
 */
class Client
{
    public $type = '';
    public $userName = '';
    public $password = '';
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $phoneNumber = '';
    public $city = '';
    public $state = '';
    
    /**
     * Creates a new Client object
     * @param string $type
     * @param string $userName
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param int $phoneNumber
     * @param string $city
     * @param string $state
     */
    public function __construct($type, $userName, $password, $firstName, $lastName, $email, 
        $phoneNumber, $city, $state
    ) {
        $this->type = $type;
        $this->userName = $userName;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->city = $city;
        $this->state = $state;
    }
    
    /**
     * Adds the client object to the database
     * @param PDO $conn
     * @return boolean
     */
    public function addClient($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO client(type, username, first_name, last_name, password, email, phone_number, city, state) VALUES(?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($this->type, $this->userName, $this->firstName, $this->lastName, $this->hashPassword($this->password, SALT1, SALT2), $this->email, $this->phoneNumber, $this->city, $this->state));
            return TRUE;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    /**
     * Checks whether or not $client exists in the database $db
     * returns false if account exists, true if it does not
     * @param Client $client
     * @param PDO $db
     * @return boolean
     */
    public function accountAvailable($conn) {
        try {
            $stmt = $conn->prepare("SELECT * FROM client WHERE username=? OR email=?");
            $stmt->execute(array($this->userName, $this->email));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($rows)==1) {
                $_SESSION['error'] = "username and/or password already in use";
                return FALSE;
            }
            return TRUE;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        } 
    }

    /**
     * Checks whther and account exists with the credentials of $client in $db
     * returns true of the account exists and logs the user in.
     * @param Client $client
     * @param PDO $db
     * @return boolean
     */
    public function login($db)
    {
        try {
            $stmt = $db->prepare("SELECT * FROM client WHERE username=? AND password=?");
            $stmt->execute(array($this->userName, $this->hashPassword($this->password, SALT1, SALT2)));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(sizeof($rows)==1) {
                $row = $rows[0];
                $_SESSION['username'] = $row['username']; 
                $_SESSION['client_id'] = $row['client_id'];
                $_SESSION['loggedin'] = true; 
                return TRUE;
            }
            return FALSE;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    /**
     * Hashes the password with the salts specified in config.php
     * returns the hashed password.
     * @param string $password
     * @param string $salt1
     * @param string $salt2
     * @return string
     */
    public function hashPassword($password, $salt1="2345#$%@3e", $salt2="taesa%#@2%^#") { 
        return sha1(md5($salt2 . $password . $salt1)); 
    } 
    
    public static function staticHashPassword($password, $salt1="2345#$%@3e", $salt2="taesa%#@2%^#") { 
        return sha1(md5($salt2 . $password . $salt1)); 
    } 

    /**
     * checks if a user is currently logged in by checking the current session
     * variables
     * returns true if a user is logged in
     * @return boolean
     */
    public static function loggedIn() { 
        if (isset($_SESSION['username']) && isset($_SESSION['loggedin']) && isset($_SESSION['client_id'])) { 
            return true; 
        } 
        return false; 
    } 

    /**
     * logs out the current user by unsetting session variables
     * returns true if user is logged out
     * @return boolean
     */
    public static function logout() { 
        unset($_SESSION['username']); 
        unset($_SESSION['client_id']);
        unset($_SESSION['loggedin']); 
        return true; 
    } 
}
