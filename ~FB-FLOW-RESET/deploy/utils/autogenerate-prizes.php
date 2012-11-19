<?php

require_once('utilities.php');

// nuke.php?
if ( ! IS_DEVELOPMENT) {
	echo 'production?';
	exit;
}
	
// some constants..
define('PRIZE_TRIP_COUNT',		3);
define('PRIZE_GIFTCARD_COUNT',	42);
define('PRIZE_START_TIME',		strtotime('2012-08-20 00:00:00'));
define('PRIZE_END_TIME',		strtotime('2012-08-20 23:59:59'));

// function to generate a random timestamp
function getTimestamp () {
	$length = PRIZE_END_TIME - PRIZE_START_TIME;
	$offset = rand(0, $length);
	return $offset + PRIZE_START_TIME;
}

// clear the prize table
Query::run('TRUNCATE TABLE prizes');

// start generating prizes
for ($i=0, $imax=PRIZE_TRIP_COUNT; $i<$imax; $i++) {
	$sql = "INSERT INTO prizes
			(prize_type,unlocked_at)
			VALUES ('trip',FROM_UNIXTIME(%i))";
	$ins = array(getTimestamp());
	Query::run($sql, $ins);
}
for ($i=0, $imax=PRIZE_GIFTCARD_COUNT; $i<$imax; $i++) {
	$sql = "INSERT INTO prizes
			(prize_type,unlocked_at)
			VALUES ('giftcard',FROM_UNIXTIME(%i))";
	$ins = array(getTimestamp());
	Query::run($sql, $ins);
}

exit;