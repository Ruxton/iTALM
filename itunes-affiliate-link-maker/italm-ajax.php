<?php

// Put your author and license information here
// TO DO!

// Check request came from valid source here
// TO DO!

// read submitted information

$linkname = $_POST['linkname'];
$linkurl = $_POST['linkurl'];

// Put your vote processing code here
// In this example, assume
//  a) The processing code sets global
// variable $error to a message if there is an error
//  b) If there is no error, $results contains
// the HTML to put into the results DIV on the screen

$link = $wpdb->

$abstractedUrl = $linkurl;

// Compose JavaScript for return
die( "var italm-returnUrl = '".$abstractedUrl."';" );

?>
