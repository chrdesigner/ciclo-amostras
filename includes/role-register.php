<?php
    // Add a custom user role
     
    $result = add_role( 'promotor', __(
     
	    'Promotor' ),
	     
	    array(
	     
		    'read' => true, // true allows this capability
		    'edit_posts' => true, // Allows user to edit their own posts
		    'edit_pages' => true, // Allows user to edit pages
		    'edit_others_posts' => true, // Allows user to edit others posts not just their own
		    'create_posts' => true, // Allows user to create new posts
		    'manage_categories' => true, // Allows user to manage post categories
		    'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
	     
	    )
	     
	);

	// Disable Admin Bar specific to user roles
	function disable_admin_bar() {
	   if ( current_user_can( 'promotor' ) ) {
	      add_filter( 'show_admin_bar', '__return_false' );
	   }
	}
	add_action( 'init', 'disable_admin_bar' , 9 );

	// Disable specific access to user roles
	function no_admin_access() {
	    $redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
	    if ( 
	        current_user_can( 'promotor' )
	    )
	    exit( 
	    	wp_redirect( $redirect )
	    );
	}
	add_action( 'admin_init', 'no_admin_access', 100 );