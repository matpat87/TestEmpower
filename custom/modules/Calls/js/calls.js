$(document).ready(function(){
	// Append custom addAllInvitees function to SAVE AND CONTINUE button 
	$(".button.saveAndContinue").attr('onclick', "addAllInvitees(); SUGAR.saveAndContinue(this);");

	// On page load, if no existing reminder is found, click add reminder button
	addReminder = setTimeout(function(){
		if($("#reminders").length > 0) {
			if($(".reminder_item").length < 1) {
				$("#reminder_add_btn").trigger('click');
				clearTimeout(addReminder);
			}	
		}
	}, 1000);
});

// Custom function to click on "Add All Invitees" on save
function addAllInvitees() { 
	$("#reminder_view").find('.add-btn').trigger('click');
	return true;
}
