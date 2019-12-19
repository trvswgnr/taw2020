<?php
/**
 * Theme Functions
 *
 * @package taw
 */

// get utility functions.
if ( file_exists( dirname( __FILE__ ) . '/functions-local.php' ) ) {
	require_once dirname( __FILE__ ) . '/functions-local.php';
}
require_once 'classes/class-theme-setup.php';
$taw2020 = new Theme_Setup();
