<?php

// load required libraries
require_once('../utils/utilities.php');

// collect input
$userInfo = new stdClass();
$userInfo->id = Input::getRequestStr('id', '', TRUE);
$userInfo->fname = Input::getRequestStr('fname', '', TRUE);
$userInfo->lname = Input::getRequestStr('lname', '', TRUE);
$userInfo->address = Input::getRequestStr('address', '', TRUE);
$userInfo->city = Input::getRequestStr('city', '', TRUE);
$userInfo->prov = Input::getRequestStr('prov', '', TRUE);
$userInfo->pcode = Input::getRequestStr('pcode', '', TRUE);
$userInfo->phone = Input::getRequestStr('phone', '', TRUE);
$userInfo->email = Input::getRequestStr('email', '', TRUE);
$userInfo->optIn = Input::getRequestStr('newsletter', '', TRUE);

$sql = "INSERT INTO users (id, created_at, first_name, last_name, address, city, province, postal_code, phone, email, opt_in)
		VALUES ('%s', NOW(), '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
$ins = array( $userInfo->id, $userInfo->fname, $userInfo->lname, $userInfo->address, $userInfo->city, $userInfo->prov, $userInfo->pcode, $userInfo->phone, $userInfo->email, $userInfo->optIn );
$res = Query::run($sql, $ins);

echo $res;
exit;