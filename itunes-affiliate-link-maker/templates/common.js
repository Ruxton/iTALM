function italm_sendToEditor(thestr,stuff,imglink)
{
	var origthestr = thestr;
	var answer = confirm("Link name: "+thestr);

	if(!answer) {
		thestr = prompt("Ok, so whats the link name then?",thestr);
	}
	if(thestr == null)
	{
		thestr = origthestr;
	}
	italm_linkIt(thestr,stuff,imglink);
//	var title = prompt("Please enter a title for the link","");
//	var text = '<a href="'+stuff+'" title="'+title+'">';
//
//	if ( typeof top.tinyMCE != 'undefined' && ( ed = top.tinyMCE.activeEditor ) && !ed.isHidden() ) {
//		var Selector = ed.selection
//		var sel = Selector.getSel();
//		if(sel != "") {
//			var text = text+sel+'</a>';
//		}
//		else
//		{
//			var text = text+'<img src="'+imglink+'" alt="'+title+'" ></a>';
//		}
//
//		ed.focus();
//		if (top.tinymce.isIE)
//			ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
//
//		ed.execCommand('mceInsertContent', false, text);
//	}
//	else {
//		alert('no');
//	}
//	top.jQuery("#ita-dialog").dialog("close");
//
//	return false;
}

function italm_linkIt( thestr, thelink, linkimage )
{
	var mysack = new sack( "/wp-admin/admin-ajax.php" );

	mysack.execute = 1;
	mysack.method = 'POST';
	mysack.setVar( "action", "italm_ajax_it");
	mysack.setVar( "linkname", thestr );
	mysack.setVar( "linkurl", thelink );
	mysack.setVar( "linkimage", linkimage );
	mysack.encVar( "cookie", document.cookie, false );
	mysack.onError = function() { alert('Ajax error in history log' )};
	mysack.runAJAX();

	return true;

}