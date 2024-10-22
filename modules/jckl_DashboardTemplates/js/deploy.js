/**
 * Created by shad on 8/28/16.
 */

$(document).ready(function () {
    /*$('#deploy_type').selectize({
        create: true,
        sortField: 'text'
    });

    $('#select_deployment_ids').selectize({
        maxItems: 500,
        sortField: 'text'
    });*/

    $('#deploy_type').select2({
        theme: "bootstrap",
        placeholder: "Select One",
    });

    $('#select_deployment_ids').select2({
        theme: "bootstrap",
        placeholder: "Select one or more options. Limit 100",
        maximumSelectionLength: 100,

    });


    $("#select_all").click(function(){

            $("#select_deployment_ids > option").prop("selected","selected");
            $("#select_deployment_ids").trigger("change");

    });

});