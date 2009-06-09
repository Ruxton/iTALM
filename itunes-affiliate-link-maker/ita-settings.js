jQuery(document).ready(function() {
	jQuery('#ita-maskenable').click( function() {
		if(jQuery('#ita-maskenable').is(':checked')) {
			jQuery('#ita-maskurl').attr("readonly",false);
		} else {
			jQuery('#ita-maskurl').attr('readonly',true);
		}
	} );
});

var tagopen = false;

function updateTime( linkurl )
{
	var bigsack = new sack("/wp-admin/admin-ajax.php" );

	bigsack.execute = 1;
	bigsack.method = 'POST';
	bigsack.setVar( "action", "italm_update_link");
	bigsack.setVar( "linkurl", linkurl );
	bigsack.encVar( "cookie", document.cookie, false );
	bigsack.onError = function() { alert('Ajax error in history log' )};
	bigsack.runAJAX();

	return true;
}

function itaToEditor( linkname, linkurl, linkimage ) {
	var title = prompt("Please enter a title for the link","");
	if ( title == "" || title == null ) {
		title = linkname;
    }
	var text = '[itunes link="'+linkurl+'" title="'+title+'"';

	if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
		var Selector = ed.selection
		var sel = Selector.getSel();
		if(sel != "") {
			text = text+' text="'+sel+'"]';
		}
		else
		{
			text = text+']';
		}
		ed.focus();
		if (tinymce.isIE)
			ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

		ed.execCommand('mceInsertContent', false, text);
	}
	else {
		//IE support
		var selectedText = '';
		if (document.selection) {
			sel = document.selection.createRange();
			selectedText = sel.text;
		}
		//MOZILLA/NETSCAPE support
		else if (edCanvas.selectionStart || edCanvas.selectionStart == '0') {
			var startPos = edCanvas.selectionStart;
			var endPos = edCanvas.selectionEnd;
			selectedText = edCanvas.value.substring(startPos,endPos)
		}
		if(selectedText != '')
		{
			text = text+' text="'+selectedText+'"]';
		}
		else
		{
			text = text+']';;
		}
		edInsertContent(edCanvas, text);
	}
}
function itaOk( )
{
	jQuery("#ita-dialog").dialog("close");
}