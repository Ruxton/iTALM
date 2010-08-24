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
<!--    <tr>
			<th scope="col" width="227"><?php _e("Name"); ?></th>
            <th scope="col" width="221"><?php _e("Album"); ?></th>
            <th scope="col"><?php _e("Artist"); ?></th>
    </tr> -->
</table>
    <div id="ita-results-scroll">
        <pre>
<?php //var_dump($resArr); ?>
</pre>
<?php //exit; ?>
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
    $columns = itms::$entities[$media][$entity]['columns'];
    $i = 0;
	$ita_linkImage = ita::setting('ita-linkimage');
    ?>
        <tr>
    <?php
    foreach( $columns as $colName => $column ) {
        ?>
            <th scope="col">
                <?php echo $colName; ?>
            </th>
        <?php
    }
    ?>
        </tr>
    <?php
    foreach($resArr as $result) {

        $realAlbumURL   = preg_replace(array('/i%3D[0-9]+%26/','/i=[0-9]+&/'),array('',''),$result->collectionViewUrl);
		$trackURL       = $result->trackViewUrl;
		$artistLink     = $result->artistViewUrl;
		
		$trackName      = $result->trackName;
		$albumName      = $result->collectionName;

		switch ($result->mediaType) {
			case "music-video":
				$trackName = $trackName.' (Music Video)';
				$albumName = $albumName.' (Album)';
				break;
			case "tv-episode":
				$trackName = $trackName.' (TV)';
				$albumName = $albumName.' (TV Season)';
				break;
			case "podcast":
				$trackName = $trackName.' (Podcast)';
				$albumName = $albumName.' (Podcast Directory)';
				break;
			case "feature-movie":
				$trackName = $trackName.' (Movie)';
				break;
			case "audiobook":
				$trackName = $trackName.' (Audiobook)';
				break;
            case "music":
			default:
				$albumName = $albumName.' (Album)';
				break;
		}

        ?>
            <tr>
        <?php
        foreach( $columns as $key => $column ) {
            if( $key == "Name" || $key == "Artist" || $key == "Track Name" || $key == "Album Name" || $key == "Developer" )
                $width = ' width="200"';
            else
                $width = '';
            $output = preg_replace('/\{([A-Za-z0-9\[\]]+)}/e',"\$result->\\1",$column);
            ?>
                <td<?php echo $width; ?>>
                    <?php
                        echo $output;
                    ?>
                </td>
            <?php
        }
        ?>
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