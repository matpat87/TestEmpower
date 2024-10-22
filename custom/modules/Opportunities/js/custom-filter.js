jQuery(document).ready(function() {
    if (jQuery("form#search_form").length > 0) {

        $("select#sub_industry_c_advanced")
            .on("change", (e) => {
                handleSubIndustryFilter();
            }).trigger("change");
    }
});


const handleSubIndustryFilter = () => {
    
    const selectedSubIndustriesArr = document.querySelectorAll('select#sub_industry_c_advanced option:checked')
    const subIndustriesValues = Array.from(selectedSubIndustriesArr).map(sub_industry => sub_industry.value);
    
    const selectedIndustriesArr = document.querySelectorAll('select#industry_c_advanced option:checked')
    const industriesValues = Array.from(selectedIndustriesArr).map(industry => industry.value);
    
    jQuery.ajax({
        type: "GET",
        url: "index.php?module=Opportunities&action=get_industry_dropdown&to_pdf=1",
        data: {
            'sub_industry': subIndustriesValues,
            'industry': industriesValues,
            'advanced_filter_form': true
        },
        dataType: 'json',
        success: function(result) {
            let options = '';
            
            $('select#industry_c_advanced').empty();
            for (const [key, value] of Object.entries(result.dropdown_list)) {
                if (value != null) {
                    options += (result.current_value != undefined && Array.isArray(result.current_value) && result.current_value.includes(key))
                        ? `<option value='${key}' selected>${value}</option>`
                        : `<option value='${key}'>${value}</option>`;

                }
            }

            $('select#industry_c_advanced').html(options);

        },
        error: function(result){
            console.log(result);
        }
    });

}
