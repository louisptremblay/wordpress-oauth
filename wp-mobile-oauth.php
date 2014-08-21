<?php
/**
 * Plugin Name: WordPress Mobile Oauth
 * Plugin URI: http://justin-greer.com/projects/wordpress-mobile-oauth-lite
 * Version: 1.0.0
 * Description: WordPress Mobile Oauth gives WordPress the ability to store sessions so that you can authicate mobile application users like Facebook and Google.
 * Author: Justin Greer
 * Author URI: http://justin-greer.com
 * License: GPL2
 * Text Domain: wp-mobile-oauth
 *
 * Lite Version Features:
 *
 * - Single Device Session Handling
 * - Registered users can login/register using their username and password.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 *
 * @package  WordPress Mobile Oauth Lite
 * @author  Justin Greer <justin@justin-greer.com>
 * @copyright  Justin Greer Interactive, LLC 2014
*/

$wp_mobile_oauth = new WP_Mobile_Oauth;
class WP_Mobile_Oauth
{

	/**
	 * WordPress Mobile Oauth Version
	 * @var String
	 */
	static $version = "1.0.0";

	/**
	 * WordPress Mobile Oauth Table Name
	 * @var String
	 */
	static $wp_mobile_oauth_table_name = "wp_mobile_oauth_sessions";

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
	 * Install WP Mobile Oauth
	 *
	 * @since 1.0.0
	 * @return No Return
	 */
	static function _install ()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . self::$wp_mobile_oauth_table_name;

		// Check to see if the sessions table is already installed
		if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
		{
			$sql = "CREATE TABLE " . $table_name . " (
			`session_id` int NOT NULL AUTO_INCREMENT,
			`session_token_id` varchar(36) NOT NULL,
			`session_user_id` int(11) NOT NULL,
			`session_created` datetime NOT NULL,
			UNIQUE KEY session_id (session_id)
			);";
	 
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}

	/**
	 * [_options_page description]
	 * @return [type] [description]
	 */
	function _options_page ()
	{
		// Options/Settings Page
		add_options_page('Mobile Oauth', 'Mobile Oauth', 'manage_options', "mobile-oauth-settings" , 'my_plugin_page');
		add_menu_page( 'Mobile OAuth', 'Mobile OAuth', 'manage_options', 'wp-mobile-oauth/pages/option-page.php', '', plugins_url( 'myplugin/images/icon.png' ), null );
	}

}

/**
 * Plugin Registration Hook
 * This runs when the plugin is activated
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, $wp_mobile_oauth::_install() );
