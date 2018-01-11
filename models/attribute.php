<?php
 
require_once("db.php");

class Attribute{

    static function get_all_attributes(){
        $sql = "SELECT attributes.id as attribute, attribute_details.id, attribute_details.value FROM attributes, attribute_details WHERE attributes.id = attribute_details.attribute";
        $db = DB::init();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $attributes = $stmt->fetchAll();
        return $attributes;

    }
    
}
?>