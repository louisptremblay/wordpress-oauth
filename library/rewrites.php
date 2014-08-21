<?php
/**
 * WordPress Mobile Oauth Rewrites
 * 
 * @author Justin Greer <justin@justin-greer.com>
 * @package WordPress Mobile Oauth
 */
class WP_Mobile_Oauth_Rewrites {

    /**
     * [create_rewrite_rules description]
     * @param  [type] $rules [description]
     * @return [type]        [description]
     */
    function create_rewrite_rules($rules) 
    {
        global $wp_rewrite;
        $newRule = array('oauth/(.+)' => 'index.php?oauth='.$wp_rewrite->preg_index(1));
        $newRules = $newRule + $rules;
        return $newRules;
    }
	
    /**
     * [add_query_vars description]
     * @param [type] $qvars [description]
     */
    function add_query_vars($qvars) 
    {
        $qvars[] = 'oauth';
        return $qvars;
    }
	
    /**
     * [flush_rewrite_rules description]
     * @return [type] [description]
     */
    function flush_rewrite_rules() 
    {
        global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
    }
	
	/**
     * [template_redirect_intercept description]
     * @return [type] [description]
     */
    function template_redirect_intercept() 
    {
        global $wp_query;
        if ( $wp_query->get('oauth') ) 
        {
            require_once( dirname(__FILE__) . '/api.php' );
            exit;
        }
    }

}
$WP_Mobile_Oauth_Rewrites = new WP_Mobile_Oauth_Rewrites();

/**
 * Create all the hooks the link this all together with WordPress
 */
add_filter( 'rewrite_rules_array' , array( $WP_Mobile_Oauth_Rewrites , 'create_rewrite_rules' ));
add_filter( 'query_vars' , array( $WP_Mobile_Oauth_Rewrites , 'add_query_vars'));
add_filter( 'wp_loaded' , array( $WP_Mobile_Oauth_Rewrites , 'flush_rewrite_rules'));

add_action( 'template_redirect', array( $WP_Mobile_Oauth_Rewrites, 'template_redirect_intercept') );