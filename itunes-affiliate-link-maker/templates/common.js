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
    return false;
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