$(document).ready(function(){
	var tr1 = $('.list.view.table-responsive thead').find('tr:first');
	if(tr1.length > 0) {
	    $('.list.view.table-responsive thead').find('th:first').css('border-radius', '0px 0px 0px 0px');
	    $('.list.view.table-responsive thead').find('th:last').css('border-radius', '0px 0px 0px 0px');

	    $('.paginationTable:first').find('td:first').css('border-radius', '5px 0px 0px 0px');
	    $('.paginationTable:first').find('td:last').css('border-radius', '0px 5px 0px 0px');

	    var tr2 = $('.list.view.table-responsive thead').find('tr.pagination-unique').css('border-radius', '10px 10px 0px 0px');
	    $('.paginationTable').css('border-radius', '10px 10px 0px 0px');
	    $(tr1).before(tr2);
    }
})