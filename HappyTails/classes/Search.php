<?php
/*
 * This class is called whenever a user wants to do a search. 
 * It allows user to search by pet type, breed, gender, age, size, color,
 * location, if a pet is service animal. Search can be performed by one or more 
 * combinations of the filters.
 */

class Search {

    private $petType;
    private $breed;
    private $sex;
    private $age;
    private $size;
    private $color;
    private $location;
    private $isServiceAnimal;
    
    function __construct($petType, $breed, $sex, $age, $size, $color, $state, $isServiceAnimal) {
        $this->petType = $petType;
        $this->breed = $breed;
        $this->sex = $sex;
        $this->age = $age;
        $this->size = $size;
        $this->color = $color;
        $this->state = $state;
        $this->isServiceAnimal = $isServiceAnimal;      
    }
    
    /**
     * This function is for use with the newest tails section.
     * It gets the 12 newest pets from the database.
     * @param PDO $conn
     * @return Array
     */
    public static function getMostRecent($conn){
        $sql= "SELECT * FROM animal ORDER BY animal_id DESC LIMIT 12" ;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
       
        //returns associative array of the returned pets
        $result = $stmt->fetchAll();
        return $result;
    }
    
    /**
     * Dynamically generates the sql string depending on the searchfilter
     * and queries the database, returning those animals as an assocaitive array.
     * @param PDO $conn
     * @return Array
     */
    public function searchFilter($conn){
       
        $filter = array();
        //check for selected filter fields and
        //add them to the array
        if(!empty($this->petType)) {
            $filter["type"] = $this->petType;
        }
        if(!empty($this->breed)) {
            $filter["breed"] = $this->breed;
        }
        if(!empty($this->age)) {
            $filter["age"] = $this->age;
        }
        if(!empty($this->sex)) {
            $filter["sex"] = $this->sex;
        }
        if(!empty($this->size)) {
            $filter["size"] = $this->size;
        }
        if(!empty($this->color)) {
            $filter["color"] = $this->color;
        }
        if(!empty($this->state)) {
            $filter["state"] = $this->state;
        }
        
        if(!empty($this->isServiceAnimal)) {
            $filter["is_service_animal"] = $this->isServiceAnimal;
        }
        
        $sql= "SELECT * FROM animal" ;
        
        //builds the sql statement 
        $i = 1;
        if(count($filter)>0) {
            $sql .= " WHERE ";
        }
        foreach ($filter as $key => $value) {
            $sql .= "{$key}=? ";
            if($i < count($filter)) {
                $sql .= " AND ";
            }
            $i++;
        }
         
        $stmt = $conn->prepare($sql);
        $stmt->execute(array_values($filter));
       
        //returns associative array of the returned pets
        $result = $stmt->fetchAll();
        return $result;
    }
}
