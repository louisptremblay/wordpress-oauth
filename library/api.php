<?php
/**
 * WordPress Mobile Oauth Main API Hook
 * This file is used to validate, process and perform all actions
 *
 * This API will need to process the main Oauth API calls as well as any custom event methods
 *
 * The API needs to follow OAuth2 Draft 31
 * @link http://tools.ietf.org/html/draft-ietf-oauth-v2-31
 *
 * - authorize
 * - authenticate
 * - access_token
 *
 * EXTREME CAUTION AND CARFULL HANDLING OF PERSONAL INFORMATION SHOULD BE TAKEN WHEN DEALING WITH
 * INFORMATION AND STORAGE ON A CLIENT DEVICE. PLEASE ENCYPT ALL DATA WITH UP TO DATA TEECHNOLOGY
 * IF YOU PLAN ON STORING PERSONAL INFORMATION ON USER DEVICES.
 *
 * @author Justin Greer <justin@justin-greer.com>
 * @package WordPress Mobile Oauth
 *
 * @todo Resource is just a placeholder defining a example resource like user_info or friends_list
 * Need to build a filter and add a check for the incomming resource lookup. if found, do the 
 * function provided. If not present a valid JSON error messgae.
 *
 * @todo integrate into the DB so that OAuth uses the WP DB user information
 *
 * @todo Build filter system that will handle the resource loopup so that it is accesable to developers.
 *
 * @todo Look into added multiple device logins to the user profile
 *
 * @todo 
 * - Add option for lifetime of authorization and access tokens
 * - Add active logged in devices in user profile page
 * - Add logout device option from the list of all logged in devices
 * - Add option to log out all devices in user profile
 * - Ensure that all chnages use a developer friendly API system
 */
if( defined("ABSPATH") === false )
	die("Illegal use of the API");

require_once( dirname(__FILE__). '/OAuth2/Autoloader.php');
$dsn      = 'mysql:dbname='.DB_NAME.';host=localhost';
$username = DB_USER;
$password = DB_PASSWORD;

// error reporting (this is a demo, after all!)
ini_set('display_errors',1);error_reporting(E_ALL);

OAuth2\Autoloader::register();

// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

// Pass a storage object or array of storage objects to the OAuth2 server class
$server = new OAuth2\Server($storage);

// Add the "Client Credentials" grant type (it is the simplest of the grant types)
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

// Add the "Authorization Code" grant type (this is where the oauth magic happens)
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

global $wp_query;
$method = $wp_query->get("oauth");

/**
 * handle the incomming request
 */
switch($method)
{
	/**
	 * Request a Token
	 * In order to use this a POST request MUST be sent.
	 *
	 * POST /oauth/token
	 * testclient:testpass http://localhost/oauth/token -d 'grant_type=client_credentials'
	 */
	case "token":
		$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
		break;

	/**
	 * AUTHORIZE
	 * This method asks the user if they would like to authorize your application to use 
	 * their data from WordPress
	 */
	case "authorize";
		$request = OAuth2\Request::createFromGlobals();
		$response = new OAuth2\Response();

		if (!$server->validateAuthorizeRequest($request, $response)) {
		    $response->send();
		    die;
		}
		// display an authorization form
		if (empty($_POST)) {
		  exit('
		<form method="post">
		  <label>Do You Authorize TestClient?</label><br />
		  <input type="submit" name="authorized" value="yes">
		  <input type="submit" name="authorized" value="no">
		</form>');
		}
		$is_authorized = ($_POST['authorized'] === 'yes');


		$user_id = 123;
		$server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
		if ($is_authorized) {

		  // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
		  $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5, 40);

		  /**
		   * @todo Change this to report back a success messgae and authorization token in JSON formatt
		   */
		  exit("SUCCESS! Authorization Code: $code");
		}
		$response->send();
		break;

	// RESOURCE
	case "resource":
		if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
		    $server->getResponse()->send();
		    die;
		}
		echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
		break;
}