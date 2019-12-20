<?php
/**
 * Theme Functions
 *
 * @package taw
 */

// local utility functions.
if ( file_exists( dirname( __FILE__ ) . '/functions-local.php' ) ) {
	require_once dirname( __FILE__ ) . '/functions-local.php';
}

// async script loader class.
require_once get_template_directory() . '/classes/class-script-loader.php';

// theme setup.
require_once get_template_directory() . '/classes/class-theme-setup.php';

$taw2020 = new Theme_Setup();
