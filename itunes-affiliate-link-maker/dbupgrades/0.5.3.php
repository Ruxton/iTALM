<?php

/**
 * This script when ran with WordPress (the plugin will take care of that) will
 * upgrade your datbase from version 0.4 or so of iTALM to an 0.5+ style DB
 */

$partnerStuff = itabase::setting('ita-partner');
$temp = split('&', $partnerStuff);
array_shift($temp);
$options = array();
foreach ($temp as $option) {
    $res = split('=', $option);
    $name = $res[0];
    $options[$name] = ($name == "partnerUrl") ? urldecode($res[1]) : $res[1];
}

// If proceed has been submitted
if (isset($_GET['proceed'])) {
    // Check for the proceed token, allow through if it's correct
    $token = get_option('italm-upgrade-token', '');

    if (trim($token) != "" && $_GET['proceed'] == $token) {
        $version="0.5.3";
        update_option('ita-version', $version);
        include ita_getDisplayTemplate('dbupgrade/upgrade-SUCCESS.php');
    }

    // Display a notice if the proceed token isn't correct
    else {
        $err = '<div class="wrap"><h2>Error Upgrading iTALM</h2><div class="error" ><p><strong>Error Upgrading</strong> - Please return to <a href="' . admin_url("options-general.php?page=itunes-affiliate-link-maker/ita.class.admin.php&italm=upgrade") . '">upgrade page</a></p></div></div>';
        print($err);
    }
}

// Display upgrade notice and create a proceed token
else {
    $tokenval = md5(time() . get_option('siteurl'));
    update_option('italm-upgrade-token', $tokenval);
    include ita_getDisplayTemplate('dbupgrades/upgrade-0.5.3.php');
}
?>
