<?php
/*
 * This class is called when a user wants to contact the system admin.
 * It gets information from the user suc has name, email, subject of the message, 
 * and the message.
 */

class Contact {

    private $name;
    private $email;
    private $subject;
    private $message;

    function __construct($name, $email, $subject, $message) {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

}
