$(document).ready(function() {
    disableFields();
    
    if (! $("input[name='record'][type=hidden]").val()) {
        retrieveAndSetProductMasterData();
        setFieldValuesToBlank();
    }

    var fieldValues = {
        'industry': $('select#industry_c').val(),
        'sub_industry': $('select#sub_industry_c').val(),
        'record_id': $('input[name=record]').val()
    };

    // $('select#industry_c').on('change', (e) => {
    //     var obj_values = {
    //         ...fieldValues,
    //         'industry': e.target.value
    //     }
    //     populateSubIndustryDropdown(obj_values)
    // }).trigger('change');

    $('select#sub_industry_c').on('change', (e) => {
        
        var obj_values = {
            ...fieldValues,
            'sub_industry': e.target.value
        }
        populateIndustryDropdown(obj_values)
    }).trigger('change');

    // intervalChecker(); // depracated with the new Industry module added OnTrack #787
})

function disableFields() {
    $("#product_master_non_db, #product_number_c, #version_c").addClass('custom-readonly')
    // $('#industry_c').css('pointer-events', 'none');
    // $('#industry_c').find('option').prop("hidden", true)
};

function setFieldValuesToBlank() {
    // $("#industry_c").val('');
};

function retrieveAndSetProductMasterData() {
    $.post('index.php?', {
        module: 'CI_CustomerItems',
        action: 'retrieve_product_master',
        to_pdf: true,
        product_master_id: $("input[name='aos_products_ci_customeritems_1aos_products_ida'][type=hidden]").val()
    }).done( function(response) {
        var parsedResponse = JSON.parse(response);

        for (const [key, value] of Object.entries(parsedResponse.data)) {
            $(`input[name='${key}']`).val(value);
        }
    });
};

function intervalChecker() {
    var marketId = $("#mkt_markets_ci_customeritems_1mkt_markets_ida").val();

    setInterval(() => {
        var isMarketIdChanged = checkMarketRelateFieldChanges(marketId);

        if (isMarketIdChanged) {
            marketId = $("#mkt_markets_ci_customeritems_1mkt_markets_ida").val();
            setMarketIndustry(marketId);
        }
    }, 200);
};

function checkMarketRelateFieldChanges(marketId) {
    return (marketId !== $("#mkt_markets_ci_customeritems_1mkt_markets_ida").val()) ? true : false;
};

function setMarketIndustry(marketId) {
    $.post('index.php', {
        module: 'CI_CustomerItems',
        action: 'retrieve_market_industry',
        to_pdf: true,
        market_id: marketId
    }).done( (response) => {
        var parsedResponse = JSON.parse(response);
        $("#industry_c").val(parsedResponse.data.industry);
    });
};

const populateSubIndustryDropdown = ({industry, record_id}) => {
    $.ajax({
        type: "GET",
        url: "index.php?module=CI_CustomerItems&action=get_sub_industry_dropdown&to_pdf=1",
        data: {
            'industry': industry,
            'customer_product_id':record_id
        },
        dataType: 'json',
        success: function(result) {
            let options = '';
            
            for (const [key, value] of Object.entries(result.dropdown_list)) {
                if (value != null) {
                    options += (key == result.current_value)
                        ? `<option value='${key}' selected>${value}</option>`
                        : `<option value='${key}'>${value}</option>`;
                }
            }

            $('select#sub_industry_c').html(options);

        },
        error: function(result){
            console.log(result);
        }
    });
}

const populateIndustryDropdown = ({sub_industry, record_id}) => {
    
    $.ajax({
        type: "GET",
        url: "index.php?module=CI_CustomerItems&action=get_industry_dropdown&to_pdf=1",
        data: {
            'sub_industry': sub_industry,
            'customer_product_id':record_id
        },
        dataType: 'json',
        success: function(result) {
            let options = '';
            
            for (const [key, value] of Object.entries(result.dropdown_list)) {
                if (value != null) {
                    options += (key == result.current_value)
                        ? `<option value='${key}' selected>${value}</option>`
                        : `<option value='${key}'>${value}</option>`;

                }
            }

            $('select#industry_c').html(options);

        },
        error: function(result){
            console.log(result);
        }
    });
}
