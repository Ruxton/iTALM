<?php
class ita {

	//All the default settings that are used when none are stored in wp_options
	public static $defaultSettings = array(
		"ita-country" => "AU",
		"ita-partner" => "",
		"ita-defaultalbfix" => "1",
		"ita-itmslm" => "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStoreServices.woa/wa/itmsSearch?WOURLEncoding=ISO8859_1&output=json",
		"ita-defaultmedia" => "all",
		"ita-cleanup" => "0",
		"ita-linkimage" => "http://ax.itunes.apple.com/images/badgeitunes61x15dark.gif",
	);

	/**
	 * Kind of an abstracted get_option, using the defaults above
	 */
	public static function setting( $key = '' )
	{
		return get_option($key,ita::$defaultSettings[$key]);
	}

	/**
	 * Constructor function, adds actions & filters for tinymce buttons, popup dialog,
	 * itms search handling, settings and their menus
	 */
	public function ita()
	{
		add_filter('mce_buttons', array(&$this,'register_ita_buttons'));
		add_filter('mce_external_plugins', array(&$this,'add_ita_tinymce_plugin'));
		add_action('admin_footer', array(&$this, 'ita_jquery_dialog_div') );
		add_action('admin_menu', array(&$this, 'ita_menus') );
		add_action('admin_init', array(&$this, 'ita_register_settings'));
		add_action('admin_init', array(&$this, 'ita_handle_search'));
	}

	/**
	 * Runs when you uninstall the plugin from wordpress or have the cleanup on de-activation box checked
	 * @global <type> $wpdb
	 */
	function ita_uninstall()
	{
		global $wpdb;
		foreach(ita::$defaultSettings as $key=>$setting )
		{
			$option_name = $key;
			$wpdb->query( $wpdb->prepare( "DELETE FROM wp_options WHERE option_name = %s;",$option_name ) );
		}
	}

	/**
	 * Runs when you have the cleanup on de-activation box checked and runs uninstall.
	 */
	function ita_deactivate( )
	{
		if(ita::setting('ita-cleanup') == 1)
		{
			$this->ita_uninstall( );
		}
	}


	/**
	 * Talks to iTMS, gets JSON response, dislays table in iFrame
	 * exits.
	 */
	function ita_handle_search( )
	{
		if( isset( $_POST['ita-omg']))
		{
			if(! isset( $_POST['ita-term'] ) )
					die('Error, no term');

			if( isset($_POST['ita-album-only']))
				$albumOnly = true;
			else
				$albumOnly = false;

			if( isset($_POST['ita-media']))
				$media = $_POST['ita-media'];
			else
				$media = 'all';

			if( isset($_POST['ita-country']))
				$country = $_POST['ita-country'];
			else
				$country = ita::setting('ita_country');


			$term = $_POST['ita-term'];
			$itms = new itms( );

			$results = $itms->getResults($term,$media,$country);
			$resArr = $results->results;

			include ita_getDisplayTemplate("itms-results.php");
			exit;
		}
	}

	/**
	 * Registering settings for the settings page
	 */
	function ita_register_settings( )
	{
		register_setting('ita-options','ita-partner');
		register_setting('ita-options','ita-defaultcountry');
		register_setting('ita-options','ita-defaultalbfix');
		register_setting('ita-options','ita-itmslm');
		register_setting('ita-options','ita-defaultmedia');
		register_setting('ita-options','ita-cleanup');
		register_setting('ita-options','ita-linkimage');
	}

	/**
	 * TinyMCE Button Setup
	 * @param Array $buttons
	 * @return Array
	 */
	function register_ita_buttons($buttons) {
            array_push($buttons, "ita");
            return $buttons;
	}


	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	function add_ita_tinymce_plugin($plugin_array) {
            $plugin_array['ita'] = get_option('siteurl').'/wp-content/plugins/italm/ita.js';
            return $plugin_array;
	}
	
	/**
	 * Outputs the jQuery Popup Dialog
	 */
	function ita_jquery_dialog_div( )
	{
            include ita_getDisplayTemplate('ita-admin-popup.html');
	}

	/**
	 * Adds menu to the settings page
	 */
	function ita_menus( )
	{
		add_options_page('iTunes Affiliate Link Maker', 'iTALM', 8, __FILE__, array(&$this,'ita_settings_page') );

	}

	/**
	 * Outputs the settings page
	 */
	function ita_settings_page( )
	{
		include ita_getDisplayTemplate('ita-admin-settings.html');
	}
}
?>