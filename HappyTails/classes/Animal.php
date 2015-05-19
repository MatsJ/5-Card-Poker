<?php

/**
 * Used to create and display Animal profiles
 * 
 * Holds an animal's information.
 * Can be passed to database functions to
 * add a new animal into the database and
 * modify or delete an existing animal
 */
class Animal
{
    public $type;
    public $name;
    public $sex = '';
    public $age = '';
    public $breed = '';
    public $color = '';
    public $size = '';
    public $isServiceAnimal = '';
    public $description = '';
    public $city = '';
    public $state = '';
    public $clientId = '';
    
    /**
     * Creates new Animal object
     * @param type $type
     * @param type $name
     * @param type $sex
     * @param type $age
     * @param type $breed
     * @param type $color
     * @param type $size
     * @param type $isServiceAnimal
     * @param type $description
     * @param type $city
     * @param type $state
     * @param type $clientId
     */
    function __construct($type, $name, $sex, $age, $breed, $color, $size, 
        $isServiceAnimal, $description, $city, $state, $clientId
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->sex = $sex;
        $this->age = $age;
        $this->breed = $breed;
        $this->color = $color;
        $this->size = $size;
        $this->isServiceAnimal = $isServiceAnimal;
        $this->description = $description;
        $this->city = $city;
        $this->state = $state;
        $this->clientId = $clientId;
    }
    
    /**
     * Gets an associative array of the animal with the specified id
     * @param PDO $conn
     * @param int $animalId
     * @return Array
     */
    public static function getAnimalById($conn, $animalId) {
        $sql = "SELECT * FROM animal WHERE animal_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($animalId));
       
        //returns associative array of the returned pets
        if($result = $stmt->fetch()) {
            return $result;
        }
        else {
            return NULL;
        }
    }
    
    /**
     * Adds the animal to the db sepcified by $conn
     * @param PDO $conn
     * @return boolean
     */
    public function addAnimal($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO animal(type, name, sex, age, breed, color, size, is_service_animal, description, city, state, client_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($this->type, $this->name, $this->sex, $this->age, $this->breed, $this->color, $this->size, $this->isServiceAnimal, $this->description, $this->city, $this->state, $this->clientId));
            return TRUE;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }
    
    /**
     * gets the owner of the animal specified by animal_id as an associative array
     * from the PDO $conn.
     * @param int $animal_id
     * @param PDO $conn
     * @return boolean/Array
     */
    public static function getOwner($animal_id, $conn) {
        try {
            $sql = "SELECT * FROM animal WHERE animal_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($animal_id));
            $result = $stmt->fetch();
            $sql2 = "SELECT * FROM client WHERE client_id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute(array($result['client_id']));
            $owner = $stmt2->fetch();
            return $owner;
        } catch (PDOException $e) {
            echo $e->getMessage();
           return FALSE;
        }
    }
}
