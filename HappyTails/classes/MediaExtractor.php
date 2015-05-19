<?php

/**
 * MediaExtractor is used to both get and modify media (Images/Video)
 * All methods are static and can be accessed without having to instanciate
 * any objects.
 */
class MediaExtractor {
   
    /**
     * Returns the first media associated with the pet_id
     * as an associative array
     * @param Database $conn
     * @param string $pet_id
     * @param string $type
     */
    public static function getMedia($conn, $animal_id, $media_type) {
        $sql = "SELECT * FROM media WHERE animal_id=? AND media_type=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($animal_id,$media_type));
       
        //returns associative array of the returned pets
        if($result = $stmt->fetch()) {
            return $result;
        }
        else {
            return NULL;
        }
    }
    
    /**
     * Takes the associative array returned from getMedia and scales it
     * to the specified dimensions for use as a thumbnail
     * @param array $image
     * @param int $width
     * @param int $height
     * @return boolean
     */
    public static function getThumbnail($image, $width, $height) {
       
        $data = $image['data'];
        
        //create an image if imagecreatefromstring was successfull otherwise exit
        $im = imagecreatefromstring($data);
        if ($im !== false) {

            $new = imagecreatetruecolor($width, $height);
            $x = imagesx($im);
            $y = imagesy($im);
            imagecopyresampled($new, $im, 0, 0, 0, 0, $width, $height, $x, $y);
            imagedestroy($im);
            
            // ob_start to catch output
            ob_start();
            //create the thumbnail
            switch ($image['filetype']) {
                case 'image/png':
                    imagepng($new);
                    imagedestroy($new);
                    break;
                case 'image/jpeg':
                    imagejpeg($new, null, 75);
                    imagedestroy($new);
                    break;
                default:
                    ob_end_clean();
                    return FALSE;
            }
            //get the created thumbnail
            $rawImageBytes = ob_get_clean();
            return $rawImageBytes;
            
        } else {
            return FALSE; 
        }
    }
}
