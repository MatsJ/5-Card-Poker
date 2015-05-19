<?php

/**
 * Information for an image or video
 * 
 * Can be passed to database functions to 
 * add a new image or video to the database
 * as well as remove existing images and videos.
 * The same class is used for both images and videos,
 * the type will be specified by both type and fileType 
 */
class Media {
    public $type;
    public $fileName;
    public $fileType;
    public $data;
    public $size;
    public $date;
    public $animalId;
    
    /**
     * Creates a new media object
     * @param string $type
     * @param string $fileName
     * @param string $fileType
     * @param filePointer $data
     * @param string $size
     * @param dateTime $date
     * @param int $animalId
     */
    function __construct($type, $fileName, $fileType, $data, $size, $date, 
        $animalId
    ) {
        $this->type = $type;
        $this->fileName = $fileName;
        $this->fileType = $fileType;
        $this->data = $data;
        $this->size = $size;
        $this->date = $date;
        $this->animalId = $animalId;
    }
    
    public function addMedia($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO media(data,filetype,filename,size,date,animal_id,media_type) VALUES(?, ?, ?, ?, ?, ?, ?)");

            $stmt->bindParam(1, $this->data, PDO::PARAM_LOB);
            $stmt->bindParam(2, $this->fileType);
            $stmt->bindParam(3, $this->fileName);
            $stmt->bindParam(4, $this->size);
            $stmt->bindParam(5, $this->date);
            $stmt->bindParam(6, $this->animalId);
            $stmt->bindParam(7, $this->type);
            $stmt->execute();
            return TRUE;
        
        } catch(PDOException $e) {
            echo $e->getMessage();
            return FALSE;
        }   
    }
  
}

