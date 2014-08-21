<?php
/**
 * WordPress Mobile Oauth Main API Hook
 * This file is used to validate, process and perform all actions
 *
 * This API will need to process the main Oauth API calls as well as any custom event methods
 *
 * - request_token
 * - authenticate
 * - access_token
 *
 * EXTREME CAUTION AND CARFULL HANDLING OF PERSONAL INFORMATION SHOULD BE TAKEN WHEN DEALING WITH
 * INFORMATION AND STORAGE ON A CLIENT DEVICE. PLEASE ENCYPT ALL DATA WITH UP TO DATA TEECHNOLOGY
 * IF YOU PLAN ON STORING PERSONAL INFORMATION ON USER DEVICES.
 *
 * @author Justin Greer <justin@justin-greer.com>
 * @package WordPress Mobile Oauth
 */
if( defined("ABSPATH") === false )
	die("Illegal use of the API");

// Get the Oauth Method 
global $wp_query;
$method = $wp_query->get('oauth');

print $method; exit;

/**
 * Request Token
 *
 * /oauth/request_token
 *
 * Reqeust must contain the following parameters
 * - oauth_consumer_key
 * - oauth_nonce
 * - oauth_signature
 * - oauth_signature_method
 * - oauth_timestamp
 * - oauth_version
 *
 * The call will return the following parameters
 * callback {
 * 	oauth_token:"NPcudxy0yU5T3tBzho7iCotZ3cnetKwcTIRlX0iwRl0",
 * 	oauth_token_secret:"NPcudxy0yU5T3tBzho7iCotZ3cnetKwcTIRlX0iwRl0",
 * 	oauth_callback_confirmed:"NPcudxy0yU5T3tBzho7iCotZ3cnetKwcTIRlX0iwRl0"
 * }
 */


/**
 * Authenticate
 * /oauth/authenticate
 * 
 * Authenticating requries the following parameters
 * - oauth_token (recieved from request_token method)
 * - Username
 * - Password
 *
 * The call will return the following parameters if
 * callback {
 * 	status: "success" | "failed" 
 * 	access_token: "NPcudxy0yU5T3tBzho7iCotZ3cnetKwcTIRlX0iwRl0" (only presented if status is success)
 * }
 *
 * The access_token paramter should be stored on the device in secure manner. The access_token is
 * what is needed to check if the users session is still good. Once the access token is collected
 * the access_token method should be used when requesting information about the user from through the API.
 *
 */


/**
 * Acces Token
 * /oauth/access_token
 *
 * Accessing any data for a user you will need a valid access_token 
 */
