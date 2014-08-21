<?php
/**
 * WordPress Mobile Oauth Filters
 *
 * @author Justin Greer <justin@justin-greer.com>
 * @package WordPress Mobile Oauth
 */
add_filter("wp_mobile_oauth_methods", "wordpress_mobile_oauth_methods");
function wordpress_mobile_oauth_methods ()
{
	$methods = array(
			"authorize" => array(new WPMO_API, "authorize")
		);
	return apply_filters("wpmo_api_methods_filter", $methods);
}