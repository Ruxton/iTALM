<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>iTunes Link Maker Plugin for Wordpress Output - <?php echo $term; ?></title>
<script type='text/javascript' src='<?php echo get_option('site_url'); ?>/wp-includes/js/tw-sack.js?ver=1.6.1'></script>
<script type="text/javascript" language="javascript" src="<?php echo get_option('site_url'); ?>/wp-content/plugins/itunes-affiliate-link-maker/templates/common.js">
</script>
<link rel="stylesheet" type="text/css" href="<?php echo get_option('site_url'); ?>/wp-content/plugins/itunes-affiliate-link-maker/templates/common.css">
</head>
<body>
<table class="ita-results" id="ita-results-head" width="100%">
  <tr>
    <th scope="col" width="482" ><?php _e('Name'); ?></th>
    <th scope="col" ><?php _e('Date'); ?></th>
  </tr>
</table>
    <div id="ita-results-scroll">
<table class="ita-results" id="ita-results-body" width="100%">
<?php
  $i = 0;
  $ita_linkImage = ita::setting('ita-linkimage');
  foreach($queryRes as $result) {
  ?>
    <tr>
      <td width="70%"<?php echo( $i == 0 ? ' class="odd"' : '' ); ?>><a href="<?php echo($result->linkUrl); ?>" onClick="italm_linkIt('<?php echo($result->linkName); ?>',this.href,'<?php echo($ita_linkImage); ?>');return false;"><?php echo($result->linkName); ?></a></td>
      <td width="30%"<?php echo( $i == 0 ? ' class="odd"' : '' ); ?>><?php echo date("F j, Y, g:i a O", $result->updateTime ); ?></td>
    </tr>
  <?php
    $i == 0 ? $i = 1 : $i = 0;
  }
?>
</table>
    </div>
</body>
</html>