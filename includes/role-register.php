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