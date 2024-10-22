jQuery(document).ready(function(){

    // trigger an input mask in Order Number field
    jQuery("#number").mask("AA-00000", {
        translation: {
            "A": { pattern: /[A-Za-z]/ },
        },
        onKeyPress: function(value, e,field, options) {
            var a = e.target.value.toUpperCase(); // toUpperCase() is used to make the input format uniform
            e.target.value = a;
        },
        placeholder: "XX-XXXXX (ex. SO-12345)"
    });
});