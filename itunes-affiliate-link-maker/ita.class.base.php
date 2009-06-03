<?php

class itabase
{
	//All the default settings that are used when none are stored in wp_options
	public static $defaultSettings = array(
		"ita-country" => "AU",
		"ita-partner" => "",
		"ita-defaultalbfix" => "1",
		"ita-itmslm" => "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/itmsSearch?WOURLEncoding=ISO8859_1&output=json",
		"ita-defaultmedia" => "all",
		"ita-cleanup" => "0",
		"ita-linkimage" => "http://ax.itunes.apple.com/images/badgeitunes61x15dark.gif",
		"ita-maskurl" => "italm",
		"ita-maskenable" => "1",
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
