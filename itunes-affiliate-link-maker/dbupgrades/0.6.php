<?php

/**
 * This script when ran with WordPress (the plugin will take care of that) will
 * upgrade your datbase from version 0.5.3 of iTALM to an 0.6 style DB
 */

// If proceed has been submitted
if (isset($_GET['proceed'])) {
    // Check for the proceed token, allow through if it's correct
    $token = get_option('italm-upgrade-token', '');

    if (trim($token) != "" && $_GET['proceed'] == $token) {
        $version = "0.6";
        delete_option('italm-partner-url');
        update_option('ita-version', $version);
        $wpdb->query($wpdb->prepare("DELETE FROM wp_options WHERE option_name = %s;", 'italm-upgrade-token'));
        include ita_getDisplayTemplate('dbupgrades/upgrade-SUCCESS.php');
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
    include ita_getDisplayTemplate('dbupgrades/upgrade-0.6.php');
}
?>
