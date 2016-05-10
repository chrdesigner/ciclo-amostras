<?php
/*
 * Função de verificação e registrar novos Promotores
 */

	add_action('acf/save_post', 'promotor_postdata', 10);
	function promotor_postdata( $post_id ) {

		if ( get_post_type( $post_id ) != 'promotor' || get_post_type( $post_id ) == 'acf' ) return;

		global $wpdb;

		$firstname = get_post_meta($post_id, 'post_title', true);
		$lastname = get_post_meta($post_id, 'sobrenome_promotor', true);
		$email = get_post_meta($post_id, 'email_promotor', true);
		$password = get_post_meta($post_id, 'senha_de_acesso_promotor', true);
		$username = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), strtolower( $firstname . ' ' . $lastname));

		// Verifica se o usuário existe ou não para atualizar as informações
		if(email_exists( $email )){

	    	$user = get_user_by( 'email', $email );

	    	$xuserdata = array(
			 	'ID' 		   => $user->ID,
				'first_name'   => $firstname,
				'last_name'	   => $lastname,
				'user_email'   => $email,
				'display_name' => $firstname . ' ' . $lastname
			);

	    	$post_id = wp_update_user($xuserdata);

	    	return $post_id;
		   
	    }

	    // Se não existir o usuario registrar
		$userdata = array(
			'ID' 		 => $user_id,
			'first_name' => $firstname,
		   	'last_name'  => $lastname,
		   	'user_login' => $username,
		   	'user_email' => $email,
		   	'user_pass'  => $password,
			'role'		 => 'promotor'
		);

		$user_id = wp_insert_user($userdata);
		//$user_id = 'user_'.$user_id;
		
		// update $_POST['return']
		$_POST['return'] = add_query_arg( 'updated', 'true', get_permalink( $post_id ) );

		return $user_id;


	}

/*
 * Função para atualizar o titulo/slug dos Promotores
 */

	add_action( 'acf/save_post', 'update_promotor', 10, 2 );
	function update_promotor( $post_id ) {
	    
	    if ( get_post_type( $post_id ) != 'promotor' || get_post_type( $post_id ) == 'acf' ) return;
	    
	    $fields = get_field_objects( $post_id );

	    remove_action( 'acf/save_post', 'update_promotor' );

	    $post_first_name = 'Promotor ' . get_field('post_title', $post_id) . ' ' . $value;
	    $post_last_name = get_field('sobrenome_promotor', $post_id) . ' ' . $value;
	    $new_slug = sanitize_title( $post_first_name . $post_last_name);

	    $email_register = get_field('email_promotor', $post_id) . ' ' . $value;
	    $find_userID = get_user_by( 'email', $email_register );
	    $userID = $find_userID->ID;

	    $post = array(
	        'ID'			=> $post_id,
	        'post_title'	=> $post_first_name . $post_last_name,
		  	'post_name'		=> $new_slug,
		  	'post_author'	=> $userID,
	        'post_status'	=> 'publish'
	    );

		// echo '<pre>';
		// 	var_dump($post);
		// echo '</pre>';

		wp_update_post( $post );

	    add_action( 'acf/save_post', 'saved_promotor' );

	    $_POST['return'] = add_query_arg( 'updated', 'true', get_permalink( $post_id ) );

	}