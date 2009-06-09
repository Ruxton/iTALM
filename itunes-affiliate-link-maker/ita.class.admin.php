<?php
class ita extends itabase {

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
		add_action('admin_init', array(&$this, 'italm_upgrade'));
		add_action('wp_ajax_italm_ajax_it', array(&$this,'italm_ajax_it') );
		add_action('wp_ajax_italm_update_link', array(&$this,'italm_update_link') );
		add_action( 'edit_form_advanced', array(&$this, 'italm_quicktags') );
		add_action( 'edit_page_form', array(&$this, 'italm_quicktags') );
		wp_enqueue_script('sack');
	}

	function italm_quicktags( )
	{
		$output = '<input type="button" id="ita_button" class="ed_button" onclick="ita_button_click()" title="ita" value="iTunes" />';
		?>
<script type="text/javascript">
// <![CDATA[
	jQuery(document).ready(function(){
		// Add the buttons to the HTML view
		jQuery("#ed_toolbar").append('<?php echo ita_js_escape( $output ); ?>');
	});
	function ita_button_click( )
	{
		jQuery("#ita-dialog").dialog({ autoOpen: false, width: 750, minWidth: 750, height: 400, minHeight: 350, maxHeight: 750, title: 'iTunes Affiliate Link Maker', resizable: false });

		// Show the dialog now that it's done being manipulated
		jQuery("#ita-dialog").dialog("open");

		// Focus the input field
		jQuery("#ita-dialog-input").focus();
	}
// ]]>
</script>
		<?php
	}

	function italm_upgrade( )
	{
		global $wpdb;
		$tableName = $wpdb->prefix.'italm';
		
		$partnerStuff = itabase::setting('ita-partner');

		$temp = split('&',$partnerStuff);
		array_shift($temp);
		$options = array( );
		foreach($temp as $option)
		{
			$res = split('=',$option);
			$name = $res[0];
			$options[$name] = ($name == "partnerUrl") ? urldecode($res[1]) : $res[1];
		}


		$query = 'SELECT * FROM '.$tableName.' WHERE linkUrl LIKE(\''.$options["partnerUrl"].'%\');';
		var_dump($query);
	}

	function italm_update_link( )
	{
		global $wpdb;
		
		$tableName = $wpdb->prefix . 'italm';

		$linkUrl = $_POST['linkurl'];

		$wpdb->update($tableName, array( 'updateTime' => time() ), array( 'linkUrl' => $linkUrl ), array('%d'), array('%s') );
	}

	function italm_ajax_it( )
	{
		global $wpdb;

		$tableName = $wpdb->prefix . 'italm';

		$linkname = isset( $_POST['linkname'] ) ? $_POST['linkname'] : '';
		$linkUrl = isset( $_POST['linkurl'] ) ? $_POST['linkurl'] : '';
		$linkImage = isset( $_POST['linkimage'] ) ? $_POST['linkimage'] : '';

		$linkResult = $wpdb->get_row('SELECT * FROM '.$tableName.' WHERE linkUrl = \''.$linkUrl.'\';', ARRAY_A);
		
		$maskedUrl = get_option('siteurl').'/'.ita::setting('ita-maskurl').'/%s';

		if(sizeof($linkResult) < 1 )
		{
			$wpdb->insert($tableName, array( 'linkName' => $linkname, 'linkUrl' => $linkUrl, 'updateTime' => time() ), array('%s','%s','%d') );
			$linkResult = $wpdb->get_row('SELECT * FROM '.$tableName.' WHERE linkUrl = \''.$linkUrl.'\';', ARRAY_A);
		}
		else
		{
			$wpdb->update($tableName, array( 'updateTime' => time() ), array( 'linkUrl' => $linkUrl ), array('%d'), array('%s') );
		}

		if(ita::setting('ita-maskenable') == '1')
		{
			$maskedUrl = sprintf($maskedUrl, str_replace(' ', '_', $linkResult['linkName'] ) );
		}
		else
		{
			$maskedUrl = $linkUrl;
		}

		die( 'top.itaToEditor(\''.$linkname.'\',\''.$linkUrl.'\',\''.$linkImage.'\');top.itaOk( );' );
	}

	function italm_install( )
	{
		global $wpdb;

		// Build table name with prefix
		$tableName = $wpdb->prefix . "italm";

		// Check to see if table exists firsts.
		if($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName)
		{
			$sql = "CREATE TABLE " . $tableName . " (
				  linkid mediumint(9) NOT NULL AUTO_INCREMENT,
				  updateTime bigint(11) DEFAULT '0' NOT NULL,
				  linkName VARCHAR(150) NOT NULL,
				  linkUrl VARCHAR(300) NOT NULL,
				  PRIMARY KEY (`linkid`),
				  UNIQUE KEY `linkName` (`linkName`)
				);";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		}
		else
		{
		}
	}

	/**
	 * Runs when you uninstall the plugin from wordpress or have the cleanup on de-activation box checked
	 * @global <type> $wpdb
	 */
	function italm_uninstall()
	{
		global $wpdb;

		$tableName = $wpdb->prefix . "italm";

		foreach(ita::$defaultSettings as $key=>$setting )
		{
			$option_name = $key;
			$wpdb->query( $wpdb->prepare( "DELETE FROM wp_options WHERE option_name = %s;",$option_name ) );
		}
		
		if($wpdb->get_var("SHOW TABLES LIKE '$tableName'") == $tableName)
		{
			$sql = "DROP TABLE " . $tableName . ";";
			//require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$wpdb->query($sql);
		}
	}

	/**
	 * Runs when you have the cleanup on de-activation box checked and runs uninstall.
	 */
	function italm_deactivate( )
	{
		if(ita::setting('ita-cleanup') == 1)
		{
			$this->italm_uninstall( );
		}
	}


	/**
	 * Talks to iTMS, gets JSON response, dislays table in iFrame
	 * exits.
	 */
	function ita_handle_search( )
	{
		global $wpdb;
		$tableName = $wpdb->prefix.'italm';
		if( isset( $_POST['ita-omg'] ) || isset( $_GET['ita-omg'] ) )
		{
			if(! isset( $_POST['ita-term'] ) )
			{
				$queryRes = $wpdb->get_results('SELECT * FROM '.$tableName.' ORDER BY updateTime DESC LIMIT 20',OBJECT );
				if(sizeof($queryRes) < 1)
					die('Error, no term');
				else
				{
					include ita_getDisplayTemplate("itms-result-history.php");
				}
			}
			else
			{
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
			}
			exit;
		}
	}

	/**
	 * Registering settings for the settings page
	 */
	function ita_register_settings( )
	{
		register_setting('ita-options','ita-partner');
		register_setting('ita-options','ita-partnerurl');
		register_setting('ita-options','ita-defaultcountry');
		register_setting('ita-options','ita-defaultalbfix');
		register_setting('ita-options','ita-itmslm');
		register_setting('ita-options','ita-defaultmedia');
		register_setting('ita-options','ita-cleanup');
		register_setting('ita-options','ita-linkimage');
		register_setting('ita-options','ita-maskurl');
		register_setting('ita-options','ita-maskenable');
		register_setting('ita-options','ita-searchlimit');
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
            $plugin_array['ita'] = plugins_url('itunes-affiliate-link-maker/ita.js');
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
		$page = add_options_page('iTunes Affiliate Link Maker', 'iTALM', 8, __FILE__, array(&$this,'ita_settings_page') );
		add_action( 'admin_print_scripts',array(&$this,'ita_admin_head'));
	}

	function ita_admin_head( )
	{
		wp_enqueue_script('ita-settings',plugins_url('itunes-affiliate-link-maker/ita-settings.js'));
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