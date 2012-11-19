<?php

// load libraries, etc
require_once('../utils/utilities.php');

// create output object
$out = new stdClass();

// function to return JSON
function output ($data) {
	header('Content-Type: application/json');
	echo json_encode($data);
	exit;	
}

function error ($code, $message='') {
	$error = array(
		'error' => array(
			'code'		=> $code,
			'message'	=> $message
		)
	);
	output($error);
}

// get input variables
$user_id = Input::getRequestStr('user_id', NULL, TRUE, '/[0-9]+/');

// check that a user ID was sent
if ( ! $user_id) error(1, 'no user id specified');

// check that the user ID exists
$sql = "SELECT id
		FROM users
		WHERE id='%s'";
$ins = array($user_id);
$res = Query::run($sql, $ins);
if ( ! mysql_num_rows($res)) {
	error(2, 'user does not exist');
}

// determine if any prizes are available
$sql = "SELECT id,prize_type
		FROM prizes
		WHERE unlocked_at<=NOW()
		AND claimed_by IS NULL
		ORDER BY unlocked_at ASC
		LIMIT 0,1";
$res = Query::run($sql);

if ( ! mysql_num_rows($res)) {
	// nothing was unlocked
	$out->status = 'sorry';
} else {
	// a prize was unlocked; get info about it
	$prize = mysql_fetch_object($res);
	
	// next check if this player has already claimed a prize of this type
	$sql = "SELECT COUNT(*)
			FROM prizes
			WHERE claimed_by='%s'
			AND prize_type='%s'";
	$ins = array($user_id, $prize->prize_type);
	$res = Query::run($sql, $ins);
	if (mysql_result($res, 0, 0) > 0) {
		// the user has already claimed a prize of this type
		$out->status = 'sorry';
	} else {
		// the user can claim this prize; mark it as claimed
		$sql = "UPDATE prizes SET
				claimed_by='%s',
				claimed_at=NOW()
				WHERE id=%i";
		$ins = array($user_id,$prize->id);
		Query::run($sql, $ins);
		
		// set the output
		$out->status = 'win';
		$out->prize = $prize;
		
		// fire off an email
		

	}
	
	
}

// output!
output($out);
