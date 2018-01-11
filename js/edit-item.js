

/**
 * function to populate the form with the item to be edited
 */
function populateForm(){
//id of item to be edited is stored in 
    $.get(
        "ajax-php.php?action=get-item&item_id="+sessionStorage.item,
        function (data){
            //convert json string to JavaScript object
            data = JSON.parse(data);
            console.log(data);

            //extract details
            var name = data[0].name;
            var ic = data[0].impression_cost;
            var fc = data[0].fixed_cost;
            var option = data[0].options;
        
            //populate form with details
            $("#item-name").val(name);
            $("#ic").val(ic);
            $("#fc").val(fc);
            $("#option").val(option);
        }
    );
    
}

/**
 * post item details to be saved in db
 */
function saveItem(){
    var name = $("#item-name").val();
    var ic = $("#ic").val();    //impression cost
    var fc = $("#fc").val();    //fixed cost
    var option = $("#option").val();

    var item = {
        "id": sessionStorage.item,
        "name": name,
        "ic": ic,
        "fc": fc,
        "option": option
    };

    $.post(
        //url to post to
        "ajax-php.php?action=save-item",

        //data to post
        item,

        //on success callback
        function ( data ){
            //redirect to items table
            // data = JSON.parse(data);
            console.log(data);
            if(data==1){
                window.location.href="admin.html";

            }else{
                alert("Unable to save changes. please try again.");
            }
            
        }
    );
}