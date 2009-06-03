<?php
/*
Plugin Name:	iTunes Affiliate Link Manager
Plugin URI:		http://ignite.digitalignition.net/articlesexamples/itunes-affiliate-link-plugin/
Description:	Easily create links to the iTunes store with or without affiliate id's
Author:			Greg Tangey
Author URI:		http://ignite.digitalignition.net/
Version:		0.2.3
*/

/*  Copyright 2009  Greg Tangey  (email : greg@digitalignition.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('WP_DEBUG', true);

include dirname(__FILE__)."/itms.php";
require_once(dirname(__FILE__).'/ita.class.base.php');

function ita_getDisplayTemplate($file) {
    if (file_exists(TEMPLATEPATH . '/'.$file)) {
        return TEMPLATEPATH . '/'.$file;
    } else {
        return dirname(__FILE__).'/templates/'.$file;
    }
}


function ita_link($atts, $content = null )
{
	global $ita_linkImage,$ita_prelink;
	$return = "";

	extract (
		shortcode_atts (
			array (
				'link' => '',
				'title' => '',
			), $atts
		)
	);
	if($title != "")
	{
		$title = 'title="'.attribute_escape($title).'"';
		$alt = 'alt="'.attribute_escape($title).'"';
	}
		
	if($content == null)
	{
		$return = '<a href="'.$ita_prelink.$link.'" '.$title.'><img src="'.$ita_linkImage.'" width="61" height="16" '.$title.' /></a>';
	}
	else
	{
		$return = '<a href="'.$ita_prelink.$link.'" '.$title.'>'.$content.'</a>';
	}

	return $return;
}

//add_shortcode('itunes', 'itunes_link');
if (ereg('/wp-admin/', $_SERVER['REQUEST_URI'])) { // just load in admin
    wp_enqueue_script( 'jquery-ui-dialog' );
    wp_enqueue_style( 'ita-jquery-ui', plugins_url('/itunes-affiliate-link-maker/ita-jquery-ui.css'), array(), '0.11', 'screen' );
    require_once(dirname(__FILE__).'/ita.class.admin.php');

	$ita =& new ita();

    if(ita::setting('ita-cleanup') == '1')
		register_deactivation_hook(__FILE__, array(&$ita,'italm_deactivate'));
		
	register_uninstall_hook(__FILE__,array(&$ita,'italm_uninstall'));
	register_activation_hook(__FILE__,array(&$ita,'italm_install'));

	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain( 'italm', '', $plugin_dir );
}
else
{
	$urlCheck = '/('.itabase::setting('ita-maskurl').')(\/[A-Z,a-z,0-9,_,-,(,)-]*)*?$/';

	if ( preg_match($urlCheck, $_SERVER['REQUEST_URI']) ) {
		require_once(dirname(__FILE__).'/ita.class.public.php');

		$itaPub = new itapub( );

		remove_action('template_redirect', 'redirect_canonical');
		add_filter('request', array(&$itaPub, 'ita_request'));
		add_action('parse_query', array(&$itaPub, 'ita_parse_query'));
		add_action('parse_request', array(&$itaPub, 'ita_parse_query'));
		add_action('template_redirect', array(&$itaPub, 'ita_linkredir'));
	}
}
