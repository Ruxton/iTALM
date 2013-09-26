<?php

class itabase
{
	public static $searchLimits = array(
		"10",
		"25",
		"50",
		"100",
		"150",
		"200"
	);

	//All the default settings that are used when none are stored in wp_options
	public static $defaultSettings = array(
		"ita-version" => "0.6",
		"ita-country" => "AU",
		"ita-partner" => "",
		"ita-affiliateNetwork" => "",
		"ita-defaultalbfix" => "1",
		"ita-itmslm" => "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/wsSearch?WOURLEncoding=ISO8859_1",
		"ita-defaultmedia" => "all",
		"ita-cleanup" => "0",
		"ita-linkimage" => "http://ax.itunes.apple.com/images/badgeitunes61x15dark.gif",
		"ita-maskurl" => "italm",
		"ita-maskenable" => "1",
		"ita-searchlimit" => "50",
	);

	/**
	 * Kind of an abstracted get_option, using the defaults above
	 */
	public static function setting( $key = '' )
	{
		return get_option($key,itabase::$defaultSettings[$key]);
	}
}



?>
