// local array to count amount of score inputs
var index_count = [];
var assignment_id;
var percent_to_2dp

// load the user dropdown by default with the page
$.getJSON("http://localhost/rubric/json.rubric.php?action=list_all_users" ,function(result){
    $.each(result.data, function(index, value) {
        $.each(value, function(column, c) {
            $('#user_dropdown')
                .append($("<option></option>")
                .attr("value", c)
                .text(c));
        }) // $.each value
    }) // $.each data
}); // end $.getJSON

$('#user_dropdown').on('change', function(){
    // clear module dropdown before rebuilding
    $('#module_dropdown')
        .find('option')
        .remove()
        .end()
        .append($("<option></option>")
        .text("--- Select Module ---"));

    // clear assignment dropdown
    $('#assignment_dropdown')
        .find('option')
        .remove()
        .end()
        .append($("<option></option>")
        .text("--- Select Assignment ---"));

    get_user_modules();
}); // user_dropdown change

$('#module_dropdown').on('change', function(){
    $('#assignment_dropdown')
        .find('option')
        .remove()
        .end()
        .append($("<option></option")
        .text("--- Select Assignment ---"));

        get_user_module_assignments();
}); // end module_dropdown change

$('#assignment_dropdown').on('change', function(){
    // when an assignment is chosen build the table
    build_rubric_table();
}); // end assignment_dropdown change

// $.getJSON functions

function get_user_modules()
{
    var user_id = ($('#user_dropdown :selected').val());

    $.getJSON("http://localhost/rubric/json.rubric.php?action=list_user_modules&user_id=" + user_id, function(result){
        $.each(result.data, function(index, value){
            $.each(value, function(column, c){
                $('#module_dropdown')
                    .append($("<option></option>")
                    .attr("value", c)
                    .text(c));
            }); // $.each value
        }) // $.each data
    }); // end $.getJSON
} // end function get_user_modules

function get_user_module_assignments()
{
    var user_id = ($('#user_dropdown :selected').val());
    var module_name = ($('#module_dropdown :selected').val());

    $.getJSON("http://localhost/rubric/json.rubric.php?action=list_user_assignments&user_id=" + user_id + "&module_name=" + module_name, function(result){
        $.each(result.data, function(index, value){
            $.each(value, function(column, c){
                $('#assignment_dropdown')
                    .append($("<option></option>")
                    .attr("value", c)
                    .text(c));
            }); // $.each value
        }); // $.each data
    }); // end $.getJSON
} // end function get_user_module_assignments


function build_rubric_table()
{
    // clear table contents before building
    delete_table();

    // capture values to pass to query
    var user_id = ($('#user_dropdown :selected').val());
    var module_name = ($('#module_dropdown :selected').val());
    var assignment_name = ($('#assignment_dropdown :selected').val());

    $.getJSON("http://localhost/rubric/json.rubric.php?action=get_assignment_rubric&user_id=" + user_id + "&module_name=" + module_name + "&assignment_name=" + assignment_name, function(result){

        html = '<table id="rubric_table" class="table table-bordered table-striped table-condensed"> <thead> <tr>';
        html = html + '<th>Criteria</th>';
        html = html + '<th>Fail</th>';
        html = html + '<th>Pass</th>';
        html = html + '<th>Merit</th>';
        html = html + '<th>Distinction</th>';
        html = html + '<th>Criteria Weight</th>';
        html = html + '<th>Grade given</th>'
        html = html + '</tr></thead>';

        html = html + '<tbody>'

        // build the column array
        $.each(result.data, function(index, value){
            var row_number = index;

            html = html + '<tr>';

            $.each(value, function(column, c){
                if (column != "weight") {
                    html = html + '<td>' + c + '</td>'
                }
                else if (column == "weight") {
                    html = html + '<td id="weight' + row_number + '">'  + c + '</td>';
                }
            }); // $.each column

            html = html + '<td>'+ '<input type="number" class="form-control" id="score' + row_number +'" />' + '</td>';
            index_count.push(row_number + 1);
            html = html + '</tr>';
        }); // $.each data

        html = html + '</tbody>';
        html = html + '<tfoot><tr class="info">';
        html = html + '<td></td> <td></td> <td></td> <td></td> <td></td> <td></td>';
        html = html + '<td> <label for="total_score"> Total: </label> <span id="total_score"> </span> </td>';
        html = html + '</tr></tfoot>';
        html = html + '</table>'; // end the html builder
        $('.table_container').append(html);

    }); // end $.getJSON
} // end function build_rubric_table

$('#calculate_score').click(function(){
    var user_id = $('#user_dropdown :selected').val();
    var assignment_name = $('#assignment_dropdown :selected').val();

    var results = [] // array to hold percentages
    var result = 0;
    var sum = 0; // calculations on array

    $.each(index_count, function(index, amount){
        var score = 0; // varaible for pushing array
        var weight = 0; // variable for pushing array
        var sum = 0;

        score = parseFloat($('#score' + index).val());
        weight = parseFloat($('#weight' + index).text());
        // percentage weight / score * 100
        result = (score / 100) * weight;
        results.push(result);
    });

    $.each(results, function(index, value) {
        sum += value;
    });

    percent_to_2dp = (sum);

    percent_to_2dp = parseFloat(percent_to_2dp).toFixed(2);

    $('#total_score').empty();
    $('#total_score').append(percent_to_2dp);

    $.getJSON("http://localhost/rubric/json.rubric.php?action=get_assignment_id_from_name&assignment_name=" + assignment_name, function(result) {
        $.each(result.data, function(index, value) {
            assignment_id = value.assignment_id;
        }); // $.each data
    }); // $.getJSON
}); // end calculate score click function

$('#save_score').click(function() {
    user_id = $('#user_dropdown :selected').val();

    $.ajax({
        url: "http://localhost/rubric/json.rubric.php?action=update_user_assignment_grade&grade=" + percent_to_2dp + "&user_id=" + user_id + "&assignment_id=" + assignment_id
    }); // ajax save
}); // end save function

function delete_table()
{
    $('#rubric_table').remove();
}
