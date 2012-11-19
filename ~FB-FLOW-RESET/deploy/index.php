<?php

require_once('utils/class.redskins.php');

// output headers
header('Content-Type: text/html; charset=utf-8');
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');


/*
 * --------------------------------------------------------------------
 * Set up application and set commonly used variables
 * --------------------------------------------------------------------
*/
App::setup();

// debug mode?
define('DEBUG', DEBUG_ALLOWED && !! Input::getRequestInt('debug', 0, 0, 1));

// Application vars
$fbAccessToken = App::getAccessToken();
$fbSignedRequest = App::getSignedRequest(); // This returns an invalid decoded 'code' immediately after authentication. Rely on cookie instead (next line)
// Get signed request from the cookie, or the POST if the cookie is not set (Safari)
$signedRequest = isset( $_COOKIE['fbsr_'.APP_ID] ) ? $_COOKIE['fbsr_'.APP_ID] : (isset($_REQUEST['signed_request']) ? $_REQUEST['signed_request'] : null);

// Facebook user vars
$user = App::getUser();
$userId = null;

// Contest vars
$returning = false;
$registering = false;
$firsttime = true;

/*
 * --------------------------------------------------------------------
 * We may have a user id, but don't know for sure if they have authenticated.
 * Not including this check will cause cookie-based issues for returning users that just deauthorized.
 * --------------------------------------------------------------------
*/
if ($user) {
	$user = App::api('/me?fields=id,name,first_name,last_name,email');
	if (!$user)	$user = null;
}

// Set user-specific vars
if ($user) {
	$userId = $user['id'];
	
	// User is definitely authenticated, so set to registering returning
	if ( isRegistered($user) ) $returning = true;
	else { $registering = true; }
}


// Create class names to add to <html>
$headClassNames = array();
if ( $returning ) $headClassNames[] = 'returning';

?>

<!DOCTYPE html>
<html class="<?=implode(' ', $headClassNames)?>">
<head>
	<title>McCain Red Skins</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<link rel="stylesheet" href="min/?g=cssGroup&debug=<?=(DEBUG?1:0)?>">
</head>
<body>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
	FB.init({
		appId: '<?=APP_ID?>',
		cookie: true,
		status: true,
		channelUrl: '<?=CHANNEL_URL?>',
		xfbml: true,
		oauth: true
	});
	FB.Canvas.setSize({height: 1250});
	
	FB.Event.subscribe('edge.create', function(targetUrl) {
		_gaq.push(['_trackEvent', 'Click', 'Facebook Like']);
	});
};
(function(d){
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}(document));
</script>
<script src="min/?g=allJs&debug=<?=(DEBUG?1:0)?>"></script>
<script>
$(document).ready(function(){
	redskins.App.init({
		returning: '<?=$returning?>',
		accessToken: '<?=$fbAccessToken?>',
		signedRequest: '<?=$signedRequest?>',
		tabUrl: '<?=TAB_URL?>',
		userId: '<?=$userId?>'
	});
});
</script>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?=ANALYTICS_ACCOUNT?>']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<div class="wrapper">
	
<?php


/* -------------------------

This is where all the content happens. There are three stages:

(1) A first-time user. Not authorized.
(2) Authorized user that has not yet filled out the entry form.
(3) Returning visitors that are authorized and registered.

Each section is completely exclusive from one another. By default, (1) is shown. When the user
authenticates and the page is reloaded, (2) will be shown if they have not yet entered. 

------------------------- */

// (1) First-time user
if (!$registering && !$returning) {
	p('First-time visit. Not authorized.');
	
	include('inc/first-visit.php');
}


// (2) Authorized user but not in the database - show registration form
if ($registering) {
	p('Authorized, not in the database. Show registration form.');
	
	include('inc/entry.php');
	include('inc/spin.php');
}

// (3) Returning, authorized user
if (!$registering && $returning) {
	p('Returning visit. Authorized.');
	
	include('inc/spin.php');
}

?>

</body>
</html>