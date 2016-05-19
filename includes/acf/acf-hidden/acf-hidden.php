<?php
	/*
		Plugin Name: Advanced Custom Fields: Hidden Field
		Plugin URI: http://1trickpony.com
		Description: A hidden field for Advanced Custom Fields
		Version: 1.0.0
		Author: erictr1ck
		Author URI: http://1trickpony.com
		License: GPLv2 or later
		License URI: http://www.gnu.org/licenses/gpl-2.0.html
	*/

	function include_field_types_hidden( $version ) {
		
		include_once('acf-hidden-v5.php');
		
	}
	add_action('acf/include_field_types', 'include_field_types_hidden');	

	function register_fields_hidden() {
		
		include_once('acf-hidden-v4.php');
		
	}
	add_action('acf/register_fields', 'register_fields_hidden');	