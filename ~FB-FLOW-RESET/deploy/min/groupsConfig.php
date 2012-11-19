<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

require_once('../utils/configuration.php');

return array(

	/* CSS */
    'cssGroup' => array('//css/reset.css', '//css/style.css'),
	
	/* JS */
    'allJs' => array('//js/lib/jquery.1.7.2.min.js', '//js/lib/pollyfills.min.js', '//js/app.js')


);