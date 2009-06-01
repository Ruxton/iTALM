<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>iTunes Link Maker Plugin for Wordpress Output - <?=$term?></title>
<script language="javascript" src="<?= get_option('site_url') ?>/wp-content/plugins/itunes-affiliate-link-maker/templates/common.js">
</script>
<link rel="stylesheet" type="text/css" href="<?= get_option('site_url') ?>/wp-content/plugins/itunes-affiliate-link-maker/templates/common.css">
</head>
<body>
<table class="ita-results" id="ita-results-head" width="100%">
    <tr>
			<th scope="col" width="227"><?php _e("Name"); ?></th>
            <th scope="col" width="221"><?php _e("Album"); ?></th>
            <th scope="col"><?php _e("Artist"); ?></th>
    </tr>
</table>
    <div id="ita-results-scroll">
<table class="ita-results" id="ita-results-body" width="100%">
<?php
if(sizeof($resArr) < 1)
{
    ?>
        <tr>
            <td class="odd" colspan="3"><?php printf( __("No result for the term: %s"),$term ); ?></td>
        </tr>
    <?php
}
else
{
    $i = 0;
	$ita_linkImage = ita::setting('ita-linkimage');
    foreach($resArr as $result) {

        $realAlbumURL = preg_replace(array('/i%3D[0-9]+%26/','/i=[0-9]+&/'),array('',''),$result->itemParentLinkUrl);
    ?>
            <tr>
                    <td width="34%"<?=( $i == 0 ? ' class="odd"' : '' )?>><a href="<?=$result->itemLinkUrl?>" onClick="italm_sendToEditor(this.href,'<?=$ita_linkImage?>','<?= $result->artistName.'-'.$result->itemName ?>');return false;"><?=$result->itemName?></a></td>
                    <td width="33%"<?=( $i == 0 ? ' class="odd"' : '' )?>><a href="<?= $albumOnly ? $realAlbumURL : $result->itemParentLinkUrl?>" onClick="italm_sendToEditor(this.href,'<?=$ita_linkImage?>','<?= $result->artistName.'-'.$result->itemParentName ?>');return false;"><?=$result->itemParentName?></a></td>
                    <td width="33%"<?=( $i == 0 ? ' class="odd"' : '' )?>><a href="<?=$result->artistLinkUrl?>" onClick="italm_sendToEditor(this.href,'<?=$ita_linkImage?>','<?=$result->artistName?>');return false;"><?=$result->artistName?></a></td>
            </tr>
    <?php
            $i == 0 ? $i = 1 : $i = 0;
    }
}
?>
</table>
    </div>
</body>
</html>