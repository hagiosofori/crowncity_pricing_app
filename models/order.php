<?php
require_once("db.php");


class Order{
    public $id;
    public $item;
    public $attribute;
    public $quantity;
    public $client_name;
    public $client_number;
    public $client_delivery_address;
    public $additional_notes;
    public $payment_token;
    public $payment_status;

    private static $db;


    function __construct($item, $attribute, $option, $quantity, $dimensions, $unit_price, $total_price){
        //initialize db
        self::$db = DB::init();

        try{
            //create a new order in the db
            $sql = "INSERT INTO Orders (item, attribute, selected_option, quantity, dimensions, unit_price, total_price) VALUES ($item, $attribute, $option, $quantity, '$dimensions', $unit_price, $total_price)";

            self::$db->exec( $sql );
            
            //use pdo to get the inserted row's id right after.
            //fetch the created row's id, and save in the id member variable.
            $this->id = self::$db->lastInsertId();
            echo 'last insert id '.$this->id;
            $this->item = $item;
            $this->attribute = $attribute;
            $this->quantity = $quantity;


        }catch(PDOException $e){
            echo '{"result": "Failed to execute query"}';
        }
        
    }


    /**
     * update client details of an order
     * @param $client_details : object containing name, phone, email, delivery address and additional notes
     */
    function update_client_info($client_details){
        //init db
        self::$db = DB::init();

        //extract details from object parameter
        $name = $client_details['name'];
        $phone = $client_details['phone'];
        $email = $client_details['email'];
        $delivery_address = $client_details['delivery_address'];
        $add_notes = $client_details['add_notes'];
        $id = $client_details['order_id'];

        
        //update the row with the current member variables.
        $sql = "UPDATE Orders SET client_name = '$name', 
                client_number = '$phone',
                client_email = '$email', 
                client_delivery_address = '$delivery_address', additional_notes = '$add_notes'
                WHERE id = $id";
        
        
        $stmt = self::$db->prepare($sql);
        try{
            $stmt->execute();
            return 1;
        }catch(PDOException $e){
            return 0;
        }
        


        //use pdo prepared statements
    }


    function delete(){
        //query to delete the order. return boolean indicating if successful or not.
    }


    /**
     * return order details given id
     */
    function get_order($order_id){
        $sql = "SELECT Orders.*, Items.name from orders, Items WHERE orders.id = $order_id AND Orders.item = Items.id";

        self::$db = DB::init();
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $order = $stmt-> fetchAll();

        return $order;
    }

}

?>