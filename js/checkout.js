

/** 
 * when the button is clicked, post the form details to be saved in the db
 * 
 * on success, fetch all necessary data, create and post the hubtel invoice.
 * 
 * then, when the invoice returns, redirect the user to hubtel to complete payment
 */


/**
 * create hubtel invoice and post
 * then save invoice token, and redirect to checkout
 */
function createHubtelInvoice(data){
    data = JSON.parse(data);

    console.log(data);
    //create hubtel invoice
    var invoice = {
        "invoice":{
            "items":{
                "item_0":{
                    "name": data[0].name,
                    "quantity": data[0].quantity,
                    "unit_price": data[0].unit_price,
                    "total_price": data[0].total_price,
                    "description": 'Client Order',
                }
            },
            "total_amount": data[0].total_price,
            "description": "Client order"
        },
        "store":{
            "name": "Brandit Design Company",
            "tagline": "Ghana's number 1 design and print shop",
            "logo_url": '',
            "website_url": "https:/brandit.expres/printshop",
        },
        "actions":{
            "cancel_url": "",
            "return_url": "",
        }
    }

    console.log(invoice);

    var clientId = "cowuvotv";
    var clientSecret = "qpjnqjcb";
    
    //post the invoice 
    $.ajax({
        method: "POST",

        url: "https://api.hubtel.com/v1/merchantaccount/onlinecheckout/invoice/create",
        
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa(clientId + ":" + clientSecret));
        },
        
        data: invoice,

        success: function ( data ){
            //save the returned token in the db
            console.log(data);
            //redirect to the hubtel checkout.

            //find a way to check the status of the transaction on return.
            //cancel and return urls can be different, for setting the status of the checkout.
        }

        }
    );

    
}

// /**
//  * fetch data for populating the invoice
//  * @param {*info on success of posting form data} data 
//  */
// function fetchInvoiceData(data){
//     ;
// }



 function postFormDetails(){
    var form = $("#form").serialize();

    $.post(
        "ajax-php.php?action=save-client-info", //url to post data
        form, //data to be posted
        function ( data ){
            console.log( data );
            $.get(
                "ajax-php.php?action=get-order-details",
                function ( data ){
                    createHubtelInvoice(data);
                }
            );
        } //function to be called on success
    );
}






