function error(data)
{
    if (data.status && data.status === 'OK') {
        return false;
    } else {
        return true;
    }
}

function display_error(data) {
    switch (data.status) {
        case "ERROR":
        // displays the error in a red popup box
            alert('error from display_error function');
        break;
        // displays the warning in a yellow popup box
        case "WARNING":
            alert('warning from display_error function');
        break;
        default:
        // displays messages that are not errors or warnings but may contain appropriate information
            alert('success from display_error function')
    }
}

$.getJSON("http://localhost/rubric/json.users.php?action=list_users", function(result) {
        // if there is no error
        if (!error(result)) {
            // generate a success message in a toastr success popup
            // store the selected object in a variable
            var select = $('#user_table');
            // iterate though the dropdown
            $.each(result.data, function(key, val) {
                // add each option to the select list
                $(select)
                    .append($("<p></p>")
                    .attr("value", val)
                    .text(val));
            });
        }
        else {
            // displays error if failed
            alert('error');
            display_error(result);
        }
    });

    function getTableData(table) {
    $('#user_table').fadeIn();
    // HTTP get request passing the table name into the action
    $.getJSON(url + table, function(result){
        // if there is no error
        if(!error(result)) {
            // check if there is data returned
            // delete all previous markup (the page is truely dynamic)
            clearHTML();
            // checks the number of rows from the JSONSchema class
            if(result.numOfRows > 0) {
                // start building the table html
                 html = '<table id="user_table" class="table table-striped table-bordered"> <thead> <tr>';

                 // init empty array for columns
                 var columnArray = [];

                 // loop through each column in the row and build table header
                 $.each(result.data[0], function(column) {
                     // markup for table head
                     html = html + '<th>' +  column + '</th>';
                     // push the column into the array
                     columnArray.push(column);
                 });
                 // builds the select dropdown for the columns by passing in the columnArray as a parameter
                 buildColumnSelectList(columnArray);
                 // end table header
                 html = html + '</tr> </thead>';

                 // loop through each row in the table
                 $.each(result.data, function(index, row){
                     // build a new row for each index
                     html = html + '<tr>';

                     // loop through each column in row
                     $.each(row, function(item, value){
                        html = html + '<td>' + value + '</td>';
                     });
                     // end the row
                     html = html + '</tr>';
                 });

                 // close the table
                 html = html + '</table>';
                 $('#tableSection .container .panel-body').after(html);
            }
            else if (result.numOfRows < 1) {
                $.getJSON('controller.php?action=getColumnsInTable&table=' + table, function(result){
                    html = '<table id="returnedData" class="table table-striped table-bordered"> <thead> <tr>';
                    var columnArray = [];
                    $.each(result.data.columns, function(index, colName) {
                        html = html + '<th>' +  colName + '</th>';
                        columnArray.push(colName);
                    });
                    buildColumnSelectList(columnArray);
                    html = html + '</tr></thread>';
                    html = html + '<tbody><tr><td></td></tr></tbody>'
                    html = html + '</table>';
                    $('#tableSection .container .panel-body').after(html);
                });
            }
        }
    });
}
