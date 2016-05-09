<?php

	add_action('acf/save_post', 'promotor_postdata', 20);

	function promotor_postdata( $post_id ) {
	    global $wpdb;

	    if ( $post_id && (get_post_type($post_id) == 'promotor') ) {

	    	$firstname = get_post_meta($post_id, 'post_title', true);
			$lastname = get_post_meta($post_id, 'sobrenome_promotor', true);
			$email = get_post_meta($post_id, 'email_promotor', true);
			$password = get_post_meta($post_id, 'senha_de_acesso_promotor', true);
			$username = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), strtolower( $firstname . ' ' . $lastname));

		    // check if this is to be a new post
		    if( $post_id != 'new' ) {
		    	
		    	preg_match_all('!\d+!', $post_id, $num_id);
		    	$num_id = implode(' ', $num_id[0]); 
		    	$num_id = (int)$num_id;

		    	$xuserdata = array(
					'ID' 		   => $num_id,
					'first_name'   => $firstname,
					'last_name'	   => $lastname,
					'user_email'   => $email,
					'display_name' => $username
				);

		    	//var_dump($xuserdata);

		    	wp_update_user($xuserdata);

		  		return $num_id;
		    }
	 	

		 	$userdata = array(
				'ID' 		 => $user_id,
				'first_name' => $firstname,
		    	'last_name'  => $lastname,
		    	'user_login' => $username,
		    	'user_email' => $email,
		    	'user_pass'  => $password,
				'role'		 => 'promotor'
			);

			//var_dump($userargs);
			wp_insert_user($userdata);

		}
	}

	add_action( 'acf/save_post', 'update_post_front', 10, 1 );
	function update_post_front( $post_id ) {
	    
	    if ( get_post_type( $post_id ) == 'acf' ) return;
	    
	    $fields = get_field_objects( $post_id );

	    remove_action( 'acf/save_post', 'my_acf_save_post' );

	    $post_first_name = 'Promotor ' . get_field('post_title', $post_id) . ' ' . $value;
	    $post_last_name = get_field('sobrenome_promotor', $post_id) . ' ' . $value;
	    $new_slug = sanitize_title( $post_first_name . $post_last_name);

	    $post = array(
	        'ID'           => $post_id,
	        'post_title'   => $post_first_name . $post_last_name,
		  	'post_name'    => $new_slug,
	        'post_status'  => 'publish'
	    );
		
	    wp_update_post( $post );
	    add_action( 'acf/save_post', 'my_save_post' );

	    $_POST['return'] = add_query_arg( 'updated', 'true', get_permalink( $post_id ) );

	}