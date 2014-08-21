<?php
/**
 * Plugin Name: WordPress OAuth2 Server
 * Plugin URI: 
 * Version: 1.0.0
 * Description:
 * Author: Justin Greer
 * Author URI: http://justin-greer.com
 * License: GPL2
 * Text Domain: wp-oauth-server
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 *
 * @package WordPress OAuth2 Server
 * @author  Justin Greer <justin@justin-greer.com>
 * @copyright  Justin Greer Interactive, LLC 2014
*/

$OAuth_Server = new WP_OAuth_Server;
class WP_OAuth_Server
{

	/**
	 * WordPress Mobile Oauth Version
	 * @var String
	 */
	static $version = "1.0.0";

	/**
	 * WordPress Mobile Oauth construct method
	 */
	function WP_Mobile_Oauth ()
	{
		add_action("wp_loaded", array($this,"_includes"));
		add_action('admin_menu', array($this,"_options_page"));
		add_action('admin_init', array($this,"_setup"));
	}

	/**
	 * WordPress Mobile Oauth Includes Method
	 * Provides simple includes for things that are going to be needed in order for the plugin to
	 * work.
	 * @return [type] [description]
	 */
	function _includes ()
	{
		require_once( dirname(__FILE__) . '/classes/save.class.php');
		require_once( dirname(__FILE__) . '/library/rewrites.php');
		require_once( dirname(__FILE__) . '/library/filters.php');
		require_once( dirname(__FILE__) . '/pages/option-page.php');
	}

	function _setup ()
	{
		register_setting( 'mobile-oauth-settings', 'disable_mobile_oauth_api' );
	}

	/**
	 * Install WP OAuth2 Server Database Tables
	 * @todo Add install script once things settle down
	 */
	static function _install ()
	{
	
	}

	/**
	 * [_options_page description]
	 * @return [type] [description]
	 */
	function _options_page ()
	{
		// Options/Settings Page
		add_options_page('OAuth Server', 'OAuth Server', 'manage_options', "oauth-server-settings" , 'wp_oauth_server_options');
		//add_menu_page( 'OAuth Server', 'Mobile Sessions', 'manage_options', 'wp-mobile-oauth/pages/option-page.php', '', plugins_url( 'myplugin/images/icon.png' ), null );
	}

}

/**
 * Plugin Registration Hook
 * This runs when the plugin is activated
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, $wp_mobile_oauth::_install() );
