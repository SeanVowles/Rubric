// variables for $.getJSON parameters
var list_users_url = "http://localhost/rubric/json.rubric.php?action=list_all_users"
var module_url = "http://localhost/rubric/json.rubric.php?action=list_user_modules&user_id=";
var assignment_url = "http://localhost/rubric/json.rubric.php?action=list_user_assignments&user_id=";
var module_name = "&module_name=";

// page render logic
$('#module_dropdown').hide();
$('#assignment_dropdown').hide();

function error(data) {
    // if the status returned from the controller is 'OK' there is no error
    if (data.status && data.status === "OK") {
        return false;
    } else {
        // there is an error
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

$.getJSON(list_users_url, function(results) {
    // if there is no error
    if (!error(results)) {
        // generate a success message in a toastr success popup
        // store the selected object in a variable
        var select = $('#user_dropdown');
        // iterate though the dropdown
        $.each(results.data, function(index, value) {
            $.each(value, function(column, id) {
                $(select)
                    .append($("<option></option>")
                        .attr("value", id)
                        .text(id));
            });
        });
    } else {
        // displays error if failed
        alert('error');
        display_error(results);
    }
}); // $get.JSON

var user_id = ($('#user_dropdown').text());
var module_value = ($('#module_dropdown').text());
var assignment_name = ($('#assignment_name').text());

$('#user_dropdown').on('change', function() {
    user_id = ($('#user_dropdown').val());
    module_value = ($('#module_dropdown').val());

    // clear the options before being built
    $('#module_dropdown').fadeIn("slow")
        .find('option')
        .remove()
        .end();

    $.getJSON(module_url + user_id, function(results) {
        if (!error(results)) {
            var select = $('#module_dropdown');
            $.each(results.data, function(index, value) {
                $.each(value, function(column, module) {
                    $(select)
                        .append($("<option></option>")
                            .attr("value", module)
                            .text(module));
                });
                module_value = ($('#module_dropdown').val());
                $('#assignment_dropdown').fadeIn("slow")
                    .find('option')
                    .remove()
                    .end();


                $.getJSON(assignment_url + user_id + module_name + module_value, function(results){
                    if (!error(results)) {
                        var select = $('#assignment_dropdown');
                        $.each(results.data, function(index, value){
                            $.each(value, function(column, assignment){
                                $(select)
                                    .append($("<option></option>")
                                        .attr("value", assignment)
                                        .text(assignment));
                            }); // $.each inner array

                        }); // $.each outer array
                    } else {
                        alert('error');
                        display_error(results);
                    }
                }); // $.getJSON
            });
        } else {
            alert('error');
            display_error(results)
        }
    }); // $.getJSON
}); // user_dropdown change

$('#module_dropdown').on('change', function(){
    module_value = ($('#module_dropdown').val());
    $('#assignment_dropdown').fadeIn("slow")
        .find('option')
        .remove()
        .end();


    $.getJSON(assignment_url + user_id + module_name + module_value, function(results){
        if (!error(results)) {
            var select = $('#assignment_dropdown');
            $.each(results.data, function(index, value){
                $.each(value, function(column, assignment){
                    $(select)
                        .append($("<option></option>")
                            .attr("value", assignment)
                            .text(assignment));
                }); // $.each inner array

            }); // $.each outer array
        } else {
            alert('error');
            display_error(results);
        }
    }); // $.getJSON
})
