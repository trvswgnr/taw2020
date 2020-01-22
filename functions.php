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
require_once 'classes/class-script-loader.php';

// theme setup.
require_once 'classes/class-theme.php';

// blocks.
require_once 'blocks/class-block.php';
require_once 'blocks/resume/list-columns/class-list-columns.php';
require_once 'blocks/resume/experience/class-experience.php';
require_once 'blocks/resume/chips/class-chips.php';
require_once 'blocks/resume/education/class-education.php';

$taw                 = new Theme();
$resume_list_columns = new Resume\List_Columns();
$resume_experience   = new Resume\Experience();
$resume_chips        = new Resume\Chips();
$resume_education    = new Resume\Education();

Theme::remove_empty_p();
Theme::add_block_category( 'Resume' );
