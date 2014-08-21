<?php
/**
 * WordPress Mobile Oauth Filters
 *
 * @author Justin Greer <justin@justin-greer.com>
 * @package WordPress Mobile Oauth
 */
add_filter("wpmo_api_methods", "wordpress_mobile_oauth_methods");
function wordpress_mobile_oauth_methods ()
{
	$methods = array(
		array(
			"name" => "request_access",
			"callback" => "wpmo_request_access_method"
			),
		array(
			"name" => "authenticate",
			"callback" => "wpmo_authenticate_method"
			),
		array(
			"name" => "access_token",
			"callback" => "wpmo_access_token_method"
			)
		);
	return apply_filters("wpmo_api_methods_filter", $methods);
}