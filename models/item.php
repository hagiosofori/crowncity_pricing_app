<?php

require_once("db.php");

class Item{
    public $id;
    public $name;
    public $attribute;
    public $impression_cost; //must be to 4 decimal points
    public $fixed_cost; //must be to 2 decimal points.
    public $option;
    private static $db;

    function __construct(){
        self::$db = DB::init();
        
        //create new record in db, and get the id.
        try{
            //set pdo error mode to exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //create item and get key.
            $sql = "INSERT INTO Items () VALUES ()";
            $db->exec($sql);

            $this->id = $db->$conn->lastInsertId();
        }catch(PDOException $e){
            echo "Connection failed: ".$e;

        }
        
    }


    function update($id, $name, $ic, $fc, $option){
        self::$db = DB::init();

        $sql = "UPDATE Items SET name='$name', impression_cost=$ic, fixed_cost=$fc, options='$option' WHERE id=$id";

        $stmt = self::$db->prepare($sql);

        try{
            self::$db->setATtribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt->execute();

            return 1;
        }catch(PDOException $e){
            return 0;
        }
    }


    function delete(){

    }


    static function get_all_items(){
        $sql = "SELECT items.*, attributes.id AS 'attribute_name' FROM `items`, attributes WHERE attributes.id = items.id";
        self::$db = DB::init();
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $items = $stmt->fetchAll();
    
        return $items;
        
    }


    static function get_item($item_id){
        $sql = "SELECT items.* FROM `items` WHERE items.id=$item_id";
        self::$db = DB::init();
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $item = $stmt->fetchAll();
    
        return $item;
        
    }

    
}

?>