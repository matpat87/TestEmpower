$(document).ready(function() {

	$("a").click(function(event) {
        var the_id = event.target.id;

        if (the_id == 'tab0') {
        	$('.panel-content').show();
        } else if (the_id == 'tab1') {
        	$('.panel-content').hide();
        }
    });

});