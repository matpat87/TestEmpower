/**
 * Created by shad on 10/15/16.
 */
$(document).ready(function () {
    $("#cancel_restore").on("click", function(e){
    e.preventDefault();
        var record = $('#deployment_record').val();
        window.location.href = 'index.php?module=jckl_DashboardDeployments&action=DetailView&record='+record;
    });
});
