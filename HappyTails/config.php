<?php
/**
 * Config.php 
 * 
 * This is required at the beginning of every php file
 * It initializes the database and includes the necessary
 * class files and functions
 */

//start session, login will be handled by session variables
session_start();

// include all classes
spl_autoload_register(function($class) {
    require_once 'classes/' . $class . '.php';
});
 
//password salts for password protection
define('SALT1', '24859f@#$#@$');
define('SALT2', '^&@#_-=+Afda$#%');

// connect to the database
$db = new Database;
$conn = $db->connect();

//clear session error + output
$_SESSION['error'] = "";
$output = "";
