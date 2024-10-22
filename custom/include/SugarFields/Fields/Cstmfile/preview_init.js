var ImgExtensions= /.+(gif|png|jpg|jpeg)$/i;
var ReaderSupport = typeof FileReader != 'undefined';
var isFirefox = typeof InstallTrigger !== 'undefined';
var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
var allowDrag = isFirefox || isSafari || isChrome;
//var allowDrag = false;

function $id(id) {
	return document.getElementById(id);
}

function FileDragHover(e) {
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.type == "dragover" ? "hover filedrag" : "filedrag");
}

function FileSelect(evt,input_id) {
	
	function Preview(contents){
		$('#'+input_id +'_O').html(contents);
	}

	evt.preventDefault();
	evt.stopPropagation();

    var files = evt.target.files || evt.dataTransfer.files; // FileList object
    if (!files.length) {
		Preview('');
		return;
    }
    
	var f=files[0];
	// Also Render thumbnail if image

    if (f.type.match('image.*')) {
		var reader = new FileReader();

		reader.onload = (function(theFile) {
			return function(e) {
				// Render image.
				Preview(['<img class="thumb" style="vertical-align: middle;max-width:25%;max-height:150px;" src="', e.target.result,
                     '" title="', escape(theFile.name), '"/>'].join(''));
			};
		})(f);

		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
	
    }
	else {
		Preview('');
	}

	if(evt.dataTransfer && evt.dataTransfer.files) {
		FileDragHover(evt);
		$id(input_id+'_file').files = evt.dataTransfer.files;
	}

	$('#'+input_id).val(f.name);
	
}

$(function(){

	$("input[type=file]").each(function(i,v) {
		var id=$(this).attr('id'),
			field_name = id.replace(/_file$/,'')
			outputId = $('#'+field_name+'_O'),
			fileid = outputId.data('fileid'),
			fname = outputId.data('fname'),
			filedrag = $id(field_name+'_drag');

		if ($(this).hasClass('CstmFile')){
		
			if (filedrag && allowDrag){
				filedrag.addEventListener("dragover", FileDragHover, false);
				filedrag.addEventListener("dragleave",FileDragHover, false);
				filedrag.addEventListener("drop", 
					function (evt){FileSelect(evt,field_name)}, false);
				filedrag.style.display = "block";
			}

	        $(this).closest('form').attr( "encoding", "multipart/form-data" );
			$(this).closest('form').attr('enctype','multipart/form-data')
			if (ReaderSupport){
				$(this).change(function(evt){
					FileSelect(evt,field_name);
				});	
			}
		}
	});	
});


