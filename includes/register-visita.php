<?php
	
	if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "nova_visita") {
	 	
	 	$data			= $_POST['data_atual'];
	 	$clinica		= $_POST['todas_clinicas'];
		$nome_clinica	= $_POST['todas_title_clinica'];

	 	$title 		= 'Relatório ' . $nome_clinica . ' | ' . $data ;
	 	
	 	global $user_ID, $wpdb;

	    $query = $wpdb->prepare(
	        'SELECT ID FROM ' . $wpdb->posts . '
	        WHERE post_title = %s
	        AND post_type = \'gerenciar_visita\'',
	        $title
	    );

	    $wpdb->query( $query );

	    if ( $wpdb->num_rows ) {
	    
	        $post_id = $wpdb->get_var( $query );
	        $meta = get_post_meta( $post_id, 'post_title', TRUE );
	        $meta++;
	        update_post_meta( $post_id, 'post_title', $meta );
	    
	    } else {

		    $nova_visita = array(
			    'post_title'    => $title,
			    'post_status'   => 'publish',
			    'post_date' 	=> date('Y-m-d H:i:s'),
			    'post_type'  	=> 'gerenciar_visita'
		    );

		    $pid = wp_insert_post($nova_visita);

		    update_field('field_5733613a9ba39', $clinica, $pid);
			
			add_post_meta($pid, 'post_title', $title, true);

			$url = get_permalink( $pid );

			$post = get_post($pid);

			wp_redirect($url);
			
			exit();

		}
	}
	
	do_action('wp_insert_post', 'wp_insert_post');

	add_action( 'acf/save_post', 'update_visita', 10, 2 );
	function update_visita( $post_id ) {
	    
	    if ( get_post_type( $post_id ) != 'gerenciar_visita' || get_post_type( $post_id ) == 'acf' ) return;
	    
	    $fields = get_field_objects( $post_id );

	    remove_action( 'acf/save_post', 'update_visita' );

	    //$new_title = get_field('post_title', $post_id) . ' ' . $value;
	    //$new_slug = sanitize_title( $new_title );

	    $post = array(
	        'ID'           => $post_id,
	        'post_type'    => 'gerenciar_visita',
	    	//'post_title'   => $new_title,
		  	//'post_name'    => $new_slug,
	        'post_status'  => 'publish'
	    );

	    wp_update_post( $post );
    	add_action( 'acf/save_post', 'saved_visita' );

	    $_POST['return'] = add_query_arg( 'updated', 'true', get_permalink( $post_id ) );

	}

	function relationship_query( $args, $field, $post ) {
	    // get posts for current logged in user
	    $args['author'] = get_current_user_id();

	    return $args;
	}
	add_filter('acf/fields/relationship/query/key=field_5733613a9ba39', 'relationship_query', 10, 3);