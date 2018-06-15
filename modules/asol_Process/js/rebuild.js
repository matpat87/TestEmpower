$(document).ready(function () {

	// table_1
	$("#check_uncheck_all_modules_1").change(function () {
		$("#table_1 .logic_hook").prop('checked',this.checked);
	});
	
	$(".check_uncheck_this_module_1").change(function () {
		$("#table_1 .logic_hook[module='"+$(this).attr("module")+"']").prop('checked',this.checked);
	});
	
	// table_2
	$("#check_uncheck_all_modules_2").change(function () {
		$("#table_2 .logic_hook").prop('checked',this.checked);
	});
	
	$(".check_uncheck_this_module_2").change(function () {
		$("#table_2 .logic_hook[module='"+$(this).attr("module")+"']").prop('checked',this.checked);
	});
	
	// table_3
	$("#check_uncheck_all_modules_3").change(function () {
		$("#table_3 .logic_hook").prop('checked',this.checked);
	});
	
	$(".check_uncheck_this_module_3").change(function () {
		$("#table_3 .logic_hook[module='"+$(this).attr("module")+"']").prop('checked',this.checked);
	});
	
});