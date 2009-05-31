function sendToEditor(stuff,imglink)
{
	var title = prompt("Please enter a title for the link","");	
	var text = '<a href="'+stuff+'" title="'+title+'">';	
	
	if ( typeof top.tinyMCE != 'undefined' && ( ed = top.tinyMCE.activeEditor ) && !ed.isHidden() ) {
		var Selector = ed.selection
		var sel = Selector.getSel();
		if(sel != "") {
			var text = text+sel+'</a>';
		}
		else
		{
			var text = text+'<img src="'+imglink+'" alt="'+title+'" ></a>';
		}

		ed.focus();
		if (top.tinymce.isIE)
			ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

		ed.execCommand('mceInsertContent', false, text);
	}
	else {
		alert('no');
	}
	top.jQuery("#ita-dialog").dialog("close");	
	
	return false;
}