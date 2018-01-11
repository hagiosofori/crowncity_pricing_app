<?php

//class to represent the db.
class DB{
    private $HOST_NAME = "localhost";
    private $DB_NAME = "pricing_app";
    private $DB_USER = "root";
    private $DB_PASS = "";

    public static $conn;


    //constructor to initialize the database connection.
    function __construct(){
        //check if the $conn is empty. if so, create a new one and store it in the member variable.
        if ( !isset(self::$conn) ){
            try{
                self::$conn = new PDO("mysql:host=$this->HOST_NAME;dbname=$this->DB_NAME", $this->DB_USER, $this->DB_PASS);
                //set the PDO error mode to exception
                //self::$conn->setAttribute(PDO::AFTER_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch(PDOException $e){
                echo "Connection failed: ". $e->getMessage();
            }
            
        }

    }


    //factory 
    public static function init(){
        if(!isset(self::$conn)){
             new self();
        }
        return self::$conn;
    }

}

?>