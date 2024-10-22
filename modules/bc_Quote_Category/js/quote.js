
$(document).ready(function () {
    if ($('#hidden').text() != '') {
        var n = $('#hidden').text();
        $('#category_list').val(n);
    }
    //save new category validation
    $('#btn_savenewcat').click(function () {
        if (trim($('#new_cat').val()) == '') {
            $('#lbl_newcat_hidden').text(' * Please enter quote category');
            savenewquote();
        } else {
            $('#lbl_newcat_hidden').text('');
        }
    });

    $('#save_quote_button').click(function () {
        if ($('#category_list').val() == '0') {
            $('#lbl_hidden_select').text('* Please select quote category').show();
        } else {
            $('#lbl_hidden_select').text('');
        }
        if (trim($('#new_quote').val()) == '') {
            $('#lbl_newquote_hidden').text(' * Please enter quote').show();
        } else {
            $('#lbl_newquote_hidden').text('');
        }
    });

});


function get_category_list(flag) {
    var qid = $('#category_list').val();
    //if (qid != '' && qid != 0)
    window.location.assign("index.php?module=bc_Quote_Category&action=loginquote&qid=" + qid + "&msg=" + flag);
}
function savenewquote() {

    var qid = $('#hidden').text();
    var quote = trim($('#new_quote').val());
    if (quote !== '' && qid !== '' && qid !== '0') {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'savenewquote', id: qid, name: quote},
            success: function (data)
            {
                window.location.assign("index.php?module=bc_Quote_Category&action=loginquote&qid=" + qid + "&quote=" + quote);
            },
            error: function (msg)
            {

            }
        });
    }
}
///////////////////////////////edit quote//////////////////////////////////////////////////////
function show_edit_table(n) {
    var n1 = $('[name="' + n + '"]').text();

    $('#new_quote_row').replaceWith("<tr id='edit_quote_row'><td>Edit Quote : </td><td><textarea id='edit_quote' style='width:550px; height:80px;' placeholder='Quote'></textarea></td><td><h3><label id='lbl_editquote_hidden'></label></h3></td></tr><tr><td colspan=3></td></tr>");
    $('#edit_quote').val(n1);
    $('#buttons').replaceWith("<input id='edit_quote_button' type='button' value='Update' onclick='update_quote()'/>");
    $('#edit_quote_button').click(function () {
        if (trim($('#edit_quote').val()) == '') {
            $('#lbl_editquote_hidden').text(' * Please enter quote to update').show();
        }
    });
    $('#edit_quote').bind('keypress', function (e) {
        //alert('hello');
        var code = e.keyCode || e.which;
        if (code == 13) { //Enter keycode
            //Do something
            $(this).append("<br/>");
        }
    });
}

function set_edit_value(id, name) {
    if (trim($('#edit_quote').val()) !== '') {
        $('#lbl_editquote_hidden').text(id).hide();
    }
}
function update_quote() {
    var id = $('#lbl_editquote_hidden').text();
    $('#lbl_quote_msg').hide();
    var name = trim($('#edit_quote').val());
    if (name !== '') {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'update_quote', id: id, name: name},
            success: function (data)
            {
                get_category_list(1);
                $('[name="' + id + '"]').text(name);
                $('#edit_quote_row').replaceWith("<tr id='new_quote_row'><td>New Quote : </td><td><textarea id='new_quote' style='width:550px; height:80px;' placeholder='Quote'></textarea></td><td><h3><label id='lbl_newquote_hidden'></label></h3></td></tr>");
                $('#buttons').replaceWith("<input id='save_quote_button' type='button' value='Save' onclick='savenewquote()'/>");

            },
            error: function (msg)
            {

            }
        });
    }
}
/////////////////////////////////////////////////////edit category/////////////////////////////////////////////////////
function show_editcat_table(id) {
    
    var n1 = $('[name="' + id + '"]').text();
    $('#newcat_row').replaceWith("<tr id='editcat_row'><td><br/>Edit Category :  <input type='text' id='edit_cat' style='width:200px;' placeholder='Quote Category'/></td><td><h3><br/>&nbsp;<label id='lbl_editcat_hidden'></label></h3></td></tr>");
    $('#buttons_cat').replaceWith("<input type='button' id='btn_update_cat' value='Update Category' onclick='update_category()'/>");
    $('#edit_cat').val(n1).show();
    $('#thead').text("Edit Quote Category");
    $('#btn_update_cat').click(function () {
        if (trim($('#edit_cat').val()) == '') {
            $('#lbl_editcat_hidden').text(' * Please enter quote category to update').show();
        }
    });
}

function set_editcat_value(id, name) {
    if (trim($('#edit_cat').val()) !== '') {
        $('#lbl_editcat_hidden').text(id).hide();
    }
}
function update_category() {
    var id = $('#lbl_editcat_hidden').text();
    var name = trim($('#edit_cat').val());
    if (name !== '') {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'update_category', id: id, name: name},
            success: function (data)
            {
                if (trim(data) == 'not') {
                    $('#lbl_editcat_hidden').text('  Quote Category name already exists.').show();
                } else {
                    $('#lbl_quotecat_msg').text('Updated successfully.').show();
                    $('[name="' + id + '"]').html("<a href='index.php?module=bc_Quote_Category&action=loginquote&qid=" + id + "&msg=0'>" + name + "</a>");
                    $('#editcat_row').replaceWith("<tr id='newcat_row'><td><br/>Quote Category :  <input type='text' id='new_cat' style='width:200px;' placeholder='Quote Category '/></td><td><br/>&nbsp;<h3><label id='lbl_newcat_hidden'></label></h3></td></tr>");
                    $('#btn_update_cat').replaceWith("<span id='buttons_cat'><input type='button' id='btn_savenewcat' value='Save' onclick='savenewcategory()'/></span>");
                    $('#thead').text("Add New Quote Category");
                }
            },
            error: function (msg)
            {

            }
        });
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function savenewcategory() {
    var qid = trim($('#new_cat').val());
    if (qid !== '') {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'savenewcategory', name: qid},
            success: function (data)
            {
                if (trim(data) == 'not') {
                    $('#lbl_newcat_hidden').text('  Quote Category name already exists.');
                } else {
                    location.assign('index.php?module=bc_Quote_Category&action=loginquotecategory&qcn=' + $('#new_cat').val());
                }
            },
            error: function (msg)
            {

            }
        });
    }
}
function backtoquote() {
    location.assign('index.php?module=bc_Quote_Category&action=loginquote');
}
function backtoadmin() {
    location.assign('index.php?module=Administration&action=index');
}
function cancel(qid) {
    $('#new_quote').val('');
    $('#edit_quote').val('');
    $('#category_list').val('0');
    $('#lbl_hidden_select').html('');
    $('#lbl_newquote_hidden').html('');
}
function cancelcat() {
    $('#new_cat').val('');
    $('#edit_cat').val('');
    $('#lbl_newcat_hidden').html('');
}

function delete_quote(d) {
    $('#edit_quote_row').replaceWith("<tr id='new_quote_row'><td>New Quote : </td><td><textarea id='new_quote' style='width:550px; height:80px;' placeholder='Quote'></textarea></td><td><h3><label id='lbl_newquote_hidden'></label></h3></td></tr>");
    $('#buttons').replaceWith("<input id='save_quote_button' type='button' value='Save' onclick='savenewquote()'/>");
    $('#edit_quote').hide();
    if (confirm('Are you sure want to delete this quote ?')) {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'delete_quote', del: d},
            success: function (data)
            {
                $('#lbl_quote_msg').text('Deleted successfully.').show();
                $('[name="' + d + '"]').parent().parent().css("display", "none");
            },
            error: function (msg)
            {

            }
        });
    }
}
function delete_category(d) {
    $('#editcat_row').replaceWith("<tr id='newcat_row'><td><br/>Quote Category :  <input type='text' id='new_cat' style='width:200px;' placeholder='Quote Category'/></td><td><h3><label id='lbl_newcat_hidden'></label></h3></td></tr>");
    $('#buttons_cat').replaceWith("<input type='button' id='btn_savenewcat' value='Save' onclick='savenewcategory()'/>");
    $('#thead').text("Add New Quote Category");

    if (confirm('Are you sure want to delete this quote category ?')) {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'delete_category', delc: d},
            success: function (data)
            {
                $('#lbl_quotecat_msg').text('Deleted successfully.').show();
                $('[name="' + d + '"]').parent().css("display", "none");
            },
            error: function (msg)
            {

            }
        });
    }
}

