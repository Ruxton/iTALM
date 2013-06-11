<?php
  $columns = itms::$entities[$media][$entity]['columns'];
  $i = 0;
  $ita_linkImage = ita::setting('ita-linkimage');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>iTunes Link Maker Plugin for Wordpress Output - <?php echo $term; ?></title>
<script type='text/javascript' src='<?php echo get_option('site_url'); ?>/wp-includes/js/tw-sack.js?ver=1.6.1'></script>
<script type="text/javascript" language="javascript" src="<?php echo get_option('site_url'); ?>/wp-content/plugins/itunes-affiliate-link-maker/templates/common.js">
</script>
<script type="text/javascript" language="javascript">var italmLinkImage='<?php echo ita::setting('ita-linkimage'); ?>';</script>
<link rel="stylesheet" type="text/css" href="<?php echo get_option('site_url'); ?>/wp-content/plugins/itunes-affiliate-link-maker/templates/common.css">
</head>
<body>
<table class="ita-results" id="ita-results-head" width="100%">
    <!-- headings for results, populated by javascript -->
</table>
    <div id="ita-results-scroll">
<table class="ita-results" id="ita-results-body" width="100%">
<?php if(sizeof($resArr) < 1) : ?>
  <tr>
      <td class="odd" colspan="3"><?php printf( __("No result for the term: %s"),$term ); ?></td>
  </tr>
<?php else : ?>
  <tr>
    <?php foreach( $columns as $colName => $column ) : ?>
      <th scope="col">
          <?php echo $colName; ?>
      </th>
    <?php endfor; ?>
  </tr>
  <?php foreach($resArr as $result) : ?>
    <tr>
    <?php foreach( $columns as $key => $column ) : ?>
      <?php
        if( $key == "Name" || $key == "Artist" || $key == "Track Name" || $key == "Album Name" || $key == "Developer" )
            $width = ' width="180"';
        else
            $width = '';
        $output = preg_replace('/\{([A-Za-z0-9\[\]]+)}/e',"\$result->\\1",$column);
      ?>
      <td<?php echo $width; ?>>
        <?php echo $output; ?>
      </td>
    <?php endfor; ?>
    </tr>
    <?php $i == 0 ? $i = 1 : $i = 0; ?>
  <?php endfor;?>
<?php endif; ?>
?>
</table>
    </div>
</body>
</html>