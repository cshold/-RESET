<?php

// load required libraries
require_once('../utils/class.redskins.php');

// collect input
$signedRequestData = App::getSignedRequest();
$user = $signedRequestData['user_id'];

// setup the class
App::setup();

// destroy the player and associated data
$ins = array($user);
Query::run("DELETE FROM users WHERE id='%s'", $ins);

error_log("deactivating user ID $user\n", 3, 'deauthorize.txt');

// exit
exit;