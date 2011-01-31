<?php

/**
 * This script when ran with WordPress (the plugin will take care of that) will
 * upgrade your datbase from the first few versions of iTALM to an 0.4+ style DB
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

if (trim($options["partnerUrl"]) != "") {
    $query = 'SELECT * FROM ' . $tableName . ' WHERE linkUrl LIKE(\'' . $options["partnerUrl"] . '%\');';
    $res = $wpdb->get_results($query, ARRAY_A);
    $updates = array();
    if (sizeof($res) > 0) {
        foreach ($res as $link) {
            $linkid = $link['linkid'];
            $newlink = urldecode(trim(str_replace($options['partnerUrl'], '', $link['linkUrl'])));
            $newlink = str_replace('&partnerId=' . $options['partnerId'], '', $newlink);
            $updates[$linkid]['url'] = $newlink;
            $updates[$linkid]['name'] = $link['linkName'];
        }
    }
}

// If proceed has been submitted
if (isset($_GET['proceed'])) {
    // Check for the proceed token, allow through if it's correct
    $token = get_option('italm-upgrade-token', '');
    if (trim($token) != "" && $_GET['proceed'] == $token) {
        foreach ($updates as $id => $link) {
            print "[" . $id . "] Updating " . $link['name'] . " to " . $link['url'] . "<br/>";
            $url = $link["url"];
            $newLinkName = ita_sanitize_title($link["name"]);
            if (!$wpdb->update($tableName, array('linkUrl' => $url, 'linkName' => $newLinkName), array('linkid' => $id), array('%s'), array('%d'))) {
            
            }
        }
        update_option('ita-partner', $options['partnerId']);
        update_option('ita-partnerurl', $options['partnerUrl']);
        update_option('ita-version', '0.1');
        $wpdb->query($wpdb->prepare("DELETE FROM wp_options WHERE option_name = %s;", 'italm-upgrade-token'));
    }

    // Display a notice if the proceed token isn't correct
    else {
        $err = '<div class="wrap"><h2>Error Upgrading iTALM</h2><div class="error" ><p><strong>Error Upgrading</strong> - Please return to <a href="' . admin_url("options-general.php?page=itunes-affiliate-link-maker/ita.class.admin.php&italm=upgrade") . '">upgrade page</a></p></div></div>';
        print($err);
    }
    print "All done.";
}

// Display upgrade notice and create a proceed token
else {
    $tokenval = md5(time() . get_option('siteurl'));
    update_option('italm-upgrade-token', $tokenval);
    include ita_getDisplayTemplate('dbupgrades/upgrade-0.1.php');
}
?>