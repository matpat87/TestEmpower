$(document).ready(function(){
	// Append custom addAllInvitees function to SAVE AND CONTINUE button 
	$(".button.saveAndContinue").attr('onclick', "addAllInvitees(); SUGAR.saveAndContinue(this);");
});

// Custom function to click on "Add All Invitees" on save
function addAllInvitees() { 
	$("#reminder_view").find('.add-btn').trigger('click');
	return true;
}
