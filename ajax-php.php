<?php
session_start();


require_once("models/item.php");
require_once("models/order.php");
require_once("models/attribute.php");

//script to receive ajax calls
$action = $_REQUEST['action'];

switch ( $action ){
    case 'get-all-items':
        items();
        break;
    case 'get-all-attributes':
        attributes();
        break;
    case 'post-order-form':
        save_order();
        break;
    case 'get-item':
        get_item();
        break;
    case 'save-item':
        save_item();
        break;
    case 'save-client-info':
        save_client_info();
        break;
    case 'get-order-details':
        get_order_details();
        break;
}


/**
 * fetch details of order currently being processed
 */
function get_order_details(){
    //extract order id from session
    $order_id = $_SESSION['order_id'];

    //get order details using id
    $order_details = Order::get_order($order_id);

    //return json representation of order details
    echo json_encode($order_details);
}




/**
 * save ordering client's info before checkout
 */
function save_client_info(){
    //extract client info from $_REQUEST
    $client_details["name"] = $_REQUEST['client-name'];
    $client_details["phone"] = $_REQUEST['client-phone'];
    $client_details["email"] = $_REQUEST['client-email'];
    $client_details["delivery_address"] = $_REQUEST['client-delivery-address'];
    $client_details["add_notes"] = $_REQUEST['additional-notes'];

    //create associative obj
    $client_details["order_id"] = $_SESSION['order_id'];

    //update order with client info
    $is_success = Order::update_client_info($client_details);

    echo $is_success;
}


/**
 * save details of item; admin function. 
 * details to be saved contained in $_REQUEST
 */
function save_item(){
    //extract item details from $_REQUEST
    $name = $_REQUEST['name'];
    $ic = $_REQUEST['ic'];
    $fc = $_REQUEST['fc'];
    $option = ( $_REQUEST['option'] == '' ) ? "null" : $_REQUEST['option'];
    $id = $_REQUEST['id'];

    //update item
    $is_success = Item::update($id, $name, $ic, $fc, $option);
    echo $is_success;

}



/**
 * fetch details of a single item. item_id is set in $_REQUEST
 */
function get_item(){
    $item_id = $_REQUEST['item_id'];
    $item = Item::get_item($item_id);
    $result = json_encode($item);

    echo $result;

}

/**
 * fetch all items in the db
 */
function items(){
    //call the function to get all items as an array of arrays
    $items = Item::get_all_items();
    $result = json_encode($items);
    echo $result;

}
/**
 * fetch all attributes in the db
 */
function attributes(){
    $attributes = Attribute::get_all_attributes();
    $result = json_encode($attributes);
    echo $result;

}

/**
 * save a user's order to the db
 */
function save_order(){
    //extract order details from $_REQUEST
    $item = $_REQUEST['item'];
    $attribute = $_REQUEST['attribute'];
    $unit_price = $_REQUEST['unit-price'];
    $total_price = $_REQUEST['total-price'];
    $quantity = $_REQUEST['quantity'];

    //initialize dimensions and options. either one of these will be filled for submission
    $dimensions = "null";
    $option = "null";
    
    //determining wether dimensions or option should have the value
    if ( $attribute == 3 ){
        $dimension_x = $_REQUEST['dimension-x'];
        $dimension_y = $_REQUEST['dimension-y'];
        
        $dimensions = $dimension_x.' x '.$dimension_y;
    }
    else{
        $option = $_REQUEST['option'];
    }
    

    //create Order
    $new_order = new Order($item, $attribute, $option, $quantity, $dimensions, $unit_price, $total_price);
    
    //store order id in $_SESSION
    $_SESSION['order_id']=$new_order->id;
    echo $new_order->id;

}


?>