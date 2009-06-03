jQuery(document).ready(function() {
	jQuery('#ita-maskenable').click( function() {
		if(jQuery('#ita-maskenable').is(':checked')) {
			jQuery('#ita-maskurl').attr("readonly",false);
		} else {
			jQuery('#ita-maskurl').attr('readonly',true);
		}
	} );
});

function itaToEditor( linkname, linkurl, linkimage ) {
	var title = prompt("Please enter a title for the link","");
	if ( title == "" || title == null ) {
		title = linkname;
    }
	var text = '<a href="'+linkurl+'" title="'+title+'">';

	if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
		var Selector = ed.selection
		var sel = Selector.getSel();
		if(sel != "") {
			text = text+sel+'</a>';
		}
		else
		{
			text = text+'<img src="'+linkimage+'" alt="'+title+'" ></a>';
		}

		ed.focus();
		if (tinymce.isIE)
			ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

		ed.execCommand('mceInsertContent', false, text);
	}
	else {
		alert('no');
	}
}