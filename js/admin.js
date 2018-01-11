/**
 * fetch items and populate table
 */
function fetchItems() {
    $.get(
        "ajax-php.php?action=get-all-items", 
        function (data){
            data = JSON.parse(data);
            console.log(data);
            
            for (i = 0; i < data.length; i++){
                var row = $.parseHTML("<tr><td>" + data[i].name + "</td><td>" + data[i].impression_cost + "</td><td>" + data[i].fixed_cost + "</td><td>" + data[i].options + "</td><td><button class='btn btn-warning btn-sm btn-block' id=" + data[i].id + " onclick='getItemToEdit(this)'>Edit</button></td></tr>");
                
                $("#items-table")[0].appendChild(row[0]);
            }
        }
    );
}

function getItemToEdit(button){
    //store the item to edit's id in the browser session, so it can be retrieved on the next page
    var itemId = button.id;
    sessionStorage.setItem('item', itemId);
    
    //redirect to edit page
    window.location.href="edit-item.html";
}






/**
 * create row, and
 * fill the item_name, impression cost, fixed cost, and option fields
 */
