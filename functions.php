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

// async script loader.
require_once get_template_directory() . '/classes/class-script-loader.php';

// theme setup.
require_once get_template_directory() . '/classes/class-theme-setup.php';

// blocks.
require_once get_template_directory() . '/blocks/class-block.php';
require_once get_template_directory() . '/blocks/resume/list-columns/class-list-columns.php';

$taw                 = new Theme_Setup();
$resume_list_columns = new Resume\List_Columns();
