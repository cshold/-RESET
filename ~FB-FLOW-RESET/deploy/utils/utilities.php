<?php

require_once('configuration.php');

/******************************************************************************/

class Cookies {
	private static $receipts = array();
	public static function set ($name, $value, $expiry=COOKIE_EXPIRY_SESSION) {
		// abort if an identical cookie's headers were already sent
		if ( self::sent($name, $value) ) return;
		
		// send the cookie headers
		setcookie(
			$name,
			$value,
			$expiry,
			COOKIE_PATH,
			COOKIE_DOMAIN
		);
		
		// keep record of having sent it
		self::$receipts[$name] = $value;
	}
	public static function get ($name) {
		if ( ! self::exists($name)) return NULL;
		return $_COOKIE[$name];
	}
	public static function exists ($name) {
		return isset($_COOKIE[$name]);
	}
	public static function sent ($name, $value) {
		if ( ! array_key_exists($name, self::$receipts)) return FALSE;
		if ( self::$receipts[$name] != $value) return FALSE;
		return TRUE;
	}
}

/******************************************************************************/

class Input {
	private static function getKeyExists ($key) {
		// determine if it is a subobject
		if ( strpos($key, '.') !== FALSE) {
			list($obj, $key) = explode('.', $key);
			if ( ! isset( $_REQUEST[$obj] )) return FALSE;
			return isset( $_REQUEST[$obj][$key] );
		}
		
		// it is a simple key
		return isset( $_REQUEST[$key] );
	}
	private static function getKeyValue ($key) {
		// determine if it is a subobject
		if ( strpos($key, '.') !== FALSE) {
			list($obj, $key) = explode('.', $key);
			return $_REQUEST[$obj][$key];
		}
		
		// it is a simple key
		return $_REQUEST[$key];
	}
	public static function csvToArray ($c='', $castNumbers=TRUE) {
		if (!strlen($c)) return array();
		$a = explode(',', $c);
		if ($castNumbers) {
			for ($i=0, $imax=count($a); $i<$imax; $i++) {
				if (preg_match('/^\-?[0-9]+$/', $a[$i])) $a[$i] = intval($a[$i]);
				if (preg_match('/^\-?[0-9]*\.[0-9]*$/', $a[$i])) $a[$i] = floatval($a[$i]);
			}
		}
		return $a;
	}	
	public static function arrayToCSV ($a=array()) {
		return implode(',', $a);
	}	
	public static function getRequestStr ($key, $default='', $trim=TRUE, $regexp='/.*/', $decode=TRUE) {
		// check that the variable exists
		if ( ! self::getKeyExists($key)) return $default;
		// fetch the variable
		$var = self::getKeyValue($key);
		// autotrim, if applicable
		if ($trim) $var = trim($var);
		if ($decode) $var = urldecode($var);
		// validate using regular expression
		if (!preg_match($regexp, $var)) return $default;
		// return the variable
		return $var;
	}	
	public static function getRequestInt ($key, $default=0, $min=NULL, $max=NULL) {
		// check that the variable exists
		if ( ! self::getKeyExists($key)) return $default;
		// fetch the variable
		$var = intval(self::getKeyValue($key));
		// check that is it a number
		if (is_nan($var)) return $default;
		// check that is it in range
		if (!is_null($min)) {
			if ($var < $min) return $default;
		}
		if (!is_null($max)) {
			if ($var > $max) return $default;
		}
		// return the variable
		return $var;		
	}	
	public static function getRequestFloat ($key, $default=0, $min=NULL, $max=NULL) {
		// check that the variable exists
		if ( ! self::getKeyExists($key)) return $default;
		// fetch the variable
		$var = floatval(self::getKeyValue($key));
		// check that is it a number
		if (is_nan($var)) return $default;
		// check that is it in range
		if (!is_null($min)) {
			if ($var < $min) return $default;
		}
		if (!is_null($max)) {
			if ($var > $max) return $default;
		}
		// return the variable
		return $var;		
	}	
	public static function getRequestArr ($key, $int=TRUE) {
		// check that the variable exists
		if ( ! self::getKeyExists($key)) return array();
		// fetch the variable
		$var = self::getKeyValue($key);
		// convert values to integers, if applicable
		if ($int) {
			for ($i=0, $imax=count($var); $i<$imax; $i++) {
				$var[$i] = intval($var[$i]);
			}
		}
		// return the variable
		return $var;		
	}	
}

/******************************************************************************/

class Query {
	private static $db = NULL;
	private static $safeSQL = NULL;
	
	private static function openDb () {
		if (is_null(self::$db)) {
			self::$db = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
			@mysql_select_db(DB_DATABASE, self::$db);
			mysql_query('SET NAMES utf8', self::$db);
		}
		return self::$db;
	}	
	private static function getSafeSQL () {
		if (is_null(self::$safeSQL)) {
			require_once('safesql.php');
			self::$safeSQL = new SafeSQL_MySQL(self::openDb());
		}
		return self::$safeSQL;
	}
	public static function run ($sql, $inserts=array(), $echo=FALSE) {
		$sqlOut = self::getSafeSQL()->query($sql, $inserts);
		if ($echo) echo "<pre>$sqlOut</pre><br>";
		$res = mysql_query($sqlOut, self::openDb());
		return $res;
	}
}

/******************************************************************************/

class Timer {
	private $time;
	public function __construct () {
		$this->time = -microtime(TRUE);
	}
	public function stop ($format=TRUE) {
		$ms = (microtime(TRUE) + $this->time) * 1000;
		if ($format) return number_format($ms, 2);
		return $ms;
	}
}