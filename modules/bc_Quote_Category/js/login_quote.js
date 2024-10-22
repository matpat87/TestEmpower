

function sel() {
    $('#label').hide();
    $('select option').prop('selected', 'selected');
}
function dsel() {
    $('#label').hide();
    $('select option').removeAttr("selected");
}
function savecat() {
    var r;
    var quotes = new Array();
    $(".my:checked").each(function ()
    {
        quotes.push(this.value);

    });
    $('#label').text('');
    if (quotes.length == 0) {
        if (confirm('You must choose single category to display your quotes on login screen. Would you like to proceed without choosen any category?')) {
            location.assign('index.php?module=Administration&action=index');
        }
    } else {
        r = JSON.stringify(quotes);
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'bc_Quote_Category', action: 'savecat', id: r},
            success: function (data)
            {
                if (trim(data) != 0 || trim(data) == 0) {
                    alert('Quote categories saved successfully');
                    location.assign('index.php?module=Administration&action=index');
                }
            },
            error: function (msg)
            {

            }
        });
    }
}

function cancel() {
    $('#label').hide();
    location.assign('index.php?module=Administration&action=index');
}


