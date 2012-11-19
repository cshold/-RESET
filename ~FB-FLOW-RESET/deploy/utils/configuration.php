<?php

// set the timezone
date_default_timezone_set('America/Toronto');

// set the line ending detection
ini_set('auto_detect_line_endings', '1');

// set the environment
define('HTTP_HOST',				$_SERVER['HTTP_HOST']);
define('HTTP_PROTOCOL',			isset($_SERVER['HTTPS']) ? 'https://' : 'http://');
define('ENV_DEVELOPMENT',		'development');
define('ENV_STAGING',			'staging');
define('ENV_PRODUCTION',		'production');

// set environment based on the URL
define('ENVIRONMENT',	   		preg_match('/capitaloneapp\.ca/i', HTTP_HOST)
									? ENV_PRODUCTION
									: (preg_match('/capitaloneapp-staging\.fatboxes\.com/i', HTTP_HOST) ? ENV_STAGING : ENV_DEVELOPMENT));

define('IS_DEVELOPMENT',		(ENVIRONMENT == ENV_DEVELOPMENT));
define('IS_STAGING',			(ENVIRONMENT == ENV_STAGING));
define('IS_PRODUCTION',			(ENVIRONMENT == ENV_PRODUCTION));
define('DEBUG_ALLOWED',			(TRUE && ! IS_PRODUCTION));
				
// set other constants
define('ROOT_DIR',				$_SERVER['DOCUMENT_ROOT']);
define('BASE_URL',		   		HTTP_PROTOCOL.$_SERVER['SERVER_NAME']);
define('SMTP_HOSTNAME',			'localhost');
define('ANALYTICS_ACCOUNT',		IS_PRODUCTION ? 'UA-34146386-1' : 'UA-34146386-2');

// Environment-specific constants
switch (TRUE) {
	case IS_PRODUCTION:
		define('DB_HOSTNAME',			'10.10.255.50');
		define('DB_USERNAME',			'');
		define('DB_PASSWORD',			'');
		define('DB_DATABASE',			'');
		break;
	case IS_STAGING:
		define('DB_HOSTNAME',			'10.10.255.50');
		define('DB_USERNAME',			'');
		define('DB_PASSWORD',			'');
		define('DB_DATABASE',			'');
		break;
	case IS_DEVELOPMENT:
	default:
		define('DB_HOSTNAME',			'localhost');
		define('DB_USERNAME',			'root');
		define('DB_PASSWORD',			'root');
		define('DB_DATABASE',			'mccain_redskins_contest');
		break;
}


// Environment-specific Facebook App constants

// ---------------------------------
//	APP_URL -> actual URL where the app lives
//	TAB_URL -> URL user is directed to after authentication
// ---------------------------------

switch (TRUE) {
	case IS_PRODUCTION:
		define('APP_ID',			'471130106240244');
		define('APP_SECRET',		'610cd34b65d11591312a3f72864d0c88');
		define('APP_URL',			HTTP_PROTOCOL.'capitaloneapp.ca/travel_buddy/');
		define('CHANNEL_URL',		HTTP_PROTOCOL.'capitaloneapp.ca/travel_buddy/util/facebook/fb_ca_chain_bundle.crt');
		define('TAB_URL',			HTTP_PROTOCOL.'www.facebook.com/CapitalOneCanada?sk=app_471130106240244');
		break;
	case IS_STAGING:
		define('APP_ID',			'336755443071605');
		define('APP_SECRET',		'e2b58d5c95b54d92a86a08f68c4bd634');
		define('APP_URL',			HTTP_PROTOCOL.'capitaloneapp-staging.fatboxes.com/travel_buddy');
		define('CHANNEL_URL',		HTTP_PROTOCOL.'capitaloneapp-staging.fatboxes.com/travel_buddy/util/facebook/fb_ca_chain_bundle.crt');
		define('TAB_URL',			HTTP_PROTOCOL.'www.facebook.com/SandboxCapOne?sk=app_336755443071605');
		break;
	case IS_DEVELOPMENT:
		define('APP_ID',			'403595616357042');
		define('APP_SECRET',		'09dd4034c7a7eb9b58c162ab466f1d12');
		define('APP_URL',			HTTP_PROTOCOL.'redskins.dev');
		define('CHANNEL_URL',		HTTP_PROTOCOL.'capitaloneapp-staging.fatboxes.com/travel_buddy/util/facebook/fb_ca_chain_bundle.crt');
		define('TAB_URL',			HTTP_PROTOCOL.'www.facebook.com/pages/The-Coding-Matrix/200499686640651?sk=app_403595616357042');
		break;
}

// set error reporting
if ( ! IS_PRODUCTION ) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
} else {
	error_reporting(0);
	ini_set('display_errors', 'Off');
}

// modify the include path, if not already modified
if (strpos(ini_get('include_path'), 'utils') === FALSE) {
	ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.'./utils');
	ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.'./utils/swiftmailer');
	ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.'./utils/facebook');
}