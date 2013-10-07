<?php
/*
Plugin Name:  iTunes Affiliate Link Manager
Plugin URI:   http://ignite.digitalignition.net/articlesexamples/itunes-affiliate-link-plugin/
Description:  Easily create links to the iTunes store with or without affiliate id's
Author:       Greg Tangey
Author URI:   http://ignite.digitalignition.net/
Version:      0.6.3
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

//define('WP_DEBUG', false);

include dirname(__FILE__)."/itms.php";
require_once(dirname(__FILE__).'/ita.class.base.php');

function ita_getDisplayTemplate($file) {
    if (file_exists(TEMPLATEPATH . '/'.$file)) {
        return TEMPLATEPATH . '/'.$file;
    } else {
        return dirname(__FILE__).'/templates/'.$file;
    }
}

// WordPress' js_escape() won't allow <, >, or " -- instead it converts it to an HTML entity. This is a "fixed" function that's used when needed.
// thanks to Viper007Bond
function ita_js_escape($text) {
  $safe_text = addslashes($text);
  $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe_text));
  $safe_text = preg_replace("/\r?\n/", "\\n", addslashes($safe_text));
  $safe_text = str_replace('\\\n', '\n', $safe_text);
  return apply_filters('js_escape', $safe_text, $text);
}

function ita_link($atts, $content = null )
{
  global $wpdb;
  $tableName = $wpdb->prefix.'italm';
  $ita_linkImage = itabase::setting('ita-linkimage');
  $ita_partnerid = itabase::setting('ita-partner');
  $ita_affiliateNetwork = itabase::setting('ita-affiliateNetwork');
  $ita_mask = itabase::setting('ita-maskenable');

  if( (trim($ita_partnerid) != "") && (trim($ita_affiliateNetwork) != ""))
  {
    $ita_partnerid = "&".$ita_affiliateNetwork."=".$ita_partnerid;
  }
  $return = "";

  extract (
    shortcode_atts (
      array (
        'link' => '',
        'title' => '',
        'text' => '',
      ), $atts
    )
  );

  $link = preg_replace('/&#038;(?![a-zA-Z1-4]{1,8};)/', '&$1', $link);
  $link = str_replace('&amp;', '&', $link);

  if($title != "")
  {
    $title = 'title="'.attribute_escape($title).'"';
    $alt = 'alt="'.attribute_escape($title).'"';
  }

  if($ita_mask != '1')
  {
    if( trim($ita_partnerid) != "" )
    {
      $link = $link.trim($ita_partnerid);
    }
  }
  else
  {
    $ita_scQuery = 'SELECT * FROM '.$tableName.' WHERE linkUrl = \''.$link.'\';';
    $linkResult = $wpdb->get_row($ita_scQuery,ARRAY_A);

    $maskedUrl = get_option('siteurl').'/'.itabase::setting('ita-maskurl').'/%s';
    if(sizeof($linkResult) > 0 )
    {
      $link = sprintf($maskedUrl, urlencode( str_replace(' ', '_', $linkResult['linkName'] ) ) );
    }
    else
    {
      if(trim($ita_partnerid) != "")
      {
        $link = $link.trim($ita_partnerid);
      }
    }
  }

  if($text == "")
  {
    $return = '<a href="'.$link.'" '.$title.'><img src="'.$ita_linkImage.'" width="61" height="16" '.$title.' /></a>';
  }
  else
  {
    $return = '<a href="'.$link.'" '.$title.'>'.$text.'</a>';
  }

  return $return;
}

add_shortcode('itunes', 'ita_link');

if (preg_match('/\/wp-admin\//', $_SERVER['REQUEST_URI'])) { // just load in admin
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
  if( itabase::setting('ita-maskenable') == '1')
  {
    $urlCheck = '/('.itabase::setting('ita-maskurl').')(\/[A-Z,a-z,0-9,_,-,(,),%-]*)*?$/';
    if ( preg_match($urlCheck, $_SERVER['REQUEST_URI']) ) {
      require_once(dirname(__FILE__).'/ita.class.public.php');
      $itaPub = new itapub( );
      remove_action('template_redirect', 'redirect_canonical');
      add_filter('request', array(&$itaPub, 'ita_request'));
      add_action('template_redirect', array(&$itaPub, 'ita_linkredir'));
    }
  }
}

function ita_sanitize_title($title) {
  $title = strip_tags($title);
  // Preserve escaped octets.
  $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
  // Remove percent signs that are not part of an octet.
  $title = str_replace('%', '', $title);
  // Restore octets.
  $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

  $title = remove_accents($title);
  if (seems_utf8($title)) {
    $title = utf8_uri_encode($title, 200);
  }

  $title = preg_replace('/&.+?;/', '', $title); // kill entities
  $title = preg_replace('/[^%a-zA-Z0-9 ()_-]/', '', $title);
  $title = preg_replace('/\s+/', '_', $title);
  $title = preg_replace('|-+|', '-', $title);
  $title = trim($title, '-');

  return $title;
}
