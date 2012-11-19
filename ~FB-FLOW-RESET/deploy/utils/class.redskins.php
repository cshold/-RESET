<?php

// load required libraries
require_once('facebook/facebook.php');
require_once('configuration.php');
if ( ! class_exists('Utility'))
	require_once('utilities.php');

// general functions
function h ($t) { echo "<h2>$t</h2>"; }
function p ($o) { echo '<pre>'.print_r($o,TRUE).'</pre>'; }

// check if user is registered
function isRegistered ($user) {
	$sql = "SELECT *
			FROM users
			WHERE id='%s'";
	$ins = array($user);
	$res = Query::run($sql, $ins);

	// if no entries were found, return false
	if ( ! mysql_num_rows($res) ) return FALSE;
	
	$user =  mysql_fetch_object($res);		
	return $user;
}



/******************************************************************************/

class App {
	public static $app;
	public static $signedRequest;
	public static $apiRequests = 0;
	public static $log;

	public static function setup () {
		// if the application instance wasn't already created, create it now.
		if ( is_null( self::$app) ) {
			self::$app = new Facebook(array(
				'appId' => APP_ID,
				'secret' => APP_SECRET,
				'cookie' => true,
				'oauth' => true,
				'fileUpload' => true
			));
		}
	}
	public static function getUser () {
		self::setup();
		return self::$app->getUser();
	}
	public static function getSignedRequest () {
		self::setup();
		return self::$app->getSignedRequest();
	}
	public static function api ($query, $method='GET') {
		self::setup();
		self::$apiRequests++;
		try {
			$res = self::$app->api($query, $method);
		} catch (Exception $e) {
			$res = NULL;
		}
		return $res;
	}
	public static function apiPost ($query, $method='POST', $args) {
		self::setup();
		self::$apiRequests++;
		try {
			$res = self::$app->api($query, $method, $args);
		} catch (Exception $e) {
			$res = NULL;
		}
		return $res;
	}
	public static function getAccessToken () {
		self::setup();
		self::$app->getAccessToken();
		return self::$app->getAccessToken();
	}
	public static function setAccessToken ($accessToken) {
		self::setup();
		self::$app->setAccessToken($accessToken);
	}
}