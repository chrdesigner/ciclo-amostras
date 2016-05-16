<?php
    // Add a custom user role
     
    $promotor = add_role( 'promotor', __( 'Promotor' ),
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

	$marketing = add_role( 'marketing', __( 'Marketing' ),
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
	   if ( current_user_can( 'promotor' ) || current_user_can( 'marketing' ) ) {
	      add_filter( 'show_admin_bar', '__return_false' );
	   }
	}
	add_action( 'init', 'disable_admin_bar' , 9 );

	// Disable specific access to user roles
	add_action( 'init', 'blockusers_init' );
	function blockusers_init() {
		if ( is_admin() && current_user_can( 'promotor' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}elseif ( is_admin() && current_user_can( 'marketing' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}