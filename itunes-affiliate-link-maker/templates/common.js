function italm_sendToEditor(stuff,imglink,thestr)
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

function italm_linkIt( thestr, thelink )
{
   var mysack = new sack(
       "<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/itunes-affiliate-link-maker/italm-ajax.php" );

  mysack.execute = 1;
  mysack.method = 'POST';
  mysack.setVar( "linkname", thestr );
  mysack.setVar( "linkurl", thelink );
  mysack.onError = function() { alert('Ajax error in history log' )};
  mysack.runAJAX();

  return true;

}