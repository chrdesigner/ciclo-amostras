<?php

	if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "nova_clinica") {
	 	
	 	$title = $_POST['post_title'];

	    $nova_clinica = array(
		    'post_title'      => $title,
		    'post_status'     => 'publish', 
		    'post_type'  	  => 'clinica'
	    );
	    
	    $pid = wp_insert_post($nova_clinica);

		add_post_meta($pid, 'post_title', $title, true);

	    $post = get_post($pid);

	    wp_redirect( $post->guid);
	}

	do_action('wp_insert_post', 'wp_insert_post');



	add_action( 'acf/save_post', 'update_clinica', 10, 2 );
	function update_clinica( $post_id ) {
	    
	    if ( get_post_type( $post_id ) != 'clinica' || get_post_type( $post_id ) == 'acf' ) return;
	    
	    $fields = get_field_objects( $post_id );

	    remove_action( 'acf/save_post', 'update_clinica' );

	    $new_title = get_field('post_title', $post_id) . ' ' . $value;
	    $new_slug = sanitize_title( $new_title );

	    $post = array(
	        'ID'           => $post_id,
	        'post_type'    => 'clinica',
	        'post_title'   => $new_title,
		  	'post_name'    => $new_slug,
	        'post_status'  => 'publish'
	    );

	    wp_update_post( $post );
    	add_action( 'acf/save_post', 'saved_clinica' );

	    $_POST['return'] = add_query_arg( 'updated', 'true', get_permalink( $post_id ) );

	}

	function relationship_query( $args, $field, $post ) {
	    // get posts for current logged in user
	    $args['author'] = get_current_user_id();

	    return $args;
	}
	add_filter('acf/fields/relationship/query/key=field_5733613a9ba39', 'relationship_query', 10, 3);