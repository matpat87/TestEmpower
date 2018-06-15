<?php 

require_once("modules/asol_Process/___common_WFM/php/asol_utils.php");

?>

<style>

#description_container {
	height: 135px;
	width: 1035px;
}

.editable {
	padding: 10px;
	height: 100px;
	width: 1000px;
	overflow: auto;
	border: 1px solid gray;
	-webkit-appearance: textfield;
	background-color: #FFFFFF;
	border-color: #94C1E8;
}
.editable li { 
	list-style-type: inherit !important; 
}
</style>

<?php

$action = $_REQUEST['action'];

$description = html_entity_decode($focus->description);

echo "<div id='description_container'>";

switch ($action) {
	case 'DetailView':
		$readonly = 1;
		$textarea_id = 'description_aux';
		echo "<div class='editable' id='$textarea_id' name='$textarea_id' disabled=''>{$description}</div>";

		break;
	case 'wfeEditView':
	case 'EditView':
		$readonly = 0;
		$textarea_id = 'description';
		echo "<div class='editable' id='$textarea_id' name='$textarea_id' class='editable'>{$description}</div>";
		
		break;
}

echo "</div>";

?>

<script src="modules/asol_Project/resources/jQueryGantt-master/libs/tinymce/tinymce.min.js?version=<?php wfm_utils::echoVersionWFM() ?>" type="text/javascript"></script>

<script>

tinymce.init({
	selector : "div.editable",
	inline: true,
	theme : "modern",
	readonly : <?php echo $readonly; ?>,
	plugins : [ "advlist autolink lists link image charmap print preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars code fullscreen", "insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor" ],
	toolbar1 : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	toolbar2 : "print preview media | forecolor backcolor emoticons",
	image_advtab : true,
	templates : [ {
		title : 'Test template 1',
		content : '<b>Test 1</b>'
	}, {
		title : 'Test template 2',
		content : '<em>Test 2</em>'
	} ],
	autosave_ask_before_unload : false,
	entity_encoding : "raw",
	forced_root_block : false,
	relative_urls : false,
	remove_script_host : false,
	convert_urls : true
});

$("#description_container").resizable();
$("#description_container").resize(function () {
	$("#<?php echo $textarea_id; ?>").width($("#description_container").width() - 35);	
	$("#<?php echo $textarea_id; ?>").height($("#description_container").height() - 35);	
});

</script>
