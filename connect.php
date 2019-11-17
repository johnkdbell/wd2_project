<?php    
    define('DB_DSN','mysql:host=localhost;dbname=project;charset=utf8');
    define('DB_USER','johnkdbell');
    define('DB_PASS','harryxsnapeOTP1');     
    
    //define('DB_DSN','mysql:host=sql311.byethost.com;dbname=b16_24796034_project;charset=utf8');
    //define('DB_USER','b16_24796034');
    //define('DB_PASS','Garbodarbo69');     
    
    try 
    {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } 
    catch (PDOException $e) 
    {
        print "Error: " . $e->getMessage();
        die();
    }

?>