<?php

	function ajax_login_init(){

	    wp_register_script('ajax-login-script', plugin_dir_url( __FILE__ ) . 'assets/js/ajax-login-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-login-script');

		wp_register_style( 'ajax-login-style', plugin_dir_url( __FILE__ ) . 'assets/css/ajax-login-style.css' );
		wp_enqueue_style( 'ajax-login-style' );

	    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
	        'ajaxurl' => admin_url( 'admin-ajax.php' ),
	        'redirecturl' => get_permalink( $post->ID ),
	        'loadingmessage' => __('Verificando informações, aguarde um momento...')
	    ));

	    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
	}

	if (!is_user_logged_in()) {
	    add_action('init', 'ajax_login_init');
	}


	function ajax_login(){

	    check_ajax_referer( 'ajax-login-nonce', 'security' );

	    $info = array();
	    $info['user_login'] = $_POST['username'];
	    $info['user_password'] = $_POST['password'];
	    $info['remember'] = true;

	    $user_signon = wp_signon( $info, false );
	    if ( is_wp_error($user_signon) ){
	        echo json_encode(array('loggedin'=>false, 'message'=>__('Seu email ou senha estão errado.')));
	    } else {
	        echo json_encode(array('loggedin'=>true, 'message'=>__('Promotor autenticado, com sucesso...')));
	    }

	    die();
	}

	/** Set up the Ajax Logout */
	if (is_admin()) {
		
		add_action('wp_ajax_custom_ajax_logout', 'custom_ajax_logout_func');

	} else {
		
		wp_register_script('ajax-logout-script', plugin_dir_url( __FILE__ ) . 'assets/js/ajax-logout-script.js', array('jquery') ); 
		wp_enqueue_script('ajax-logout-script');

		wp_localize_script('ajax-logout-script', 'ajax_object',
		    array(
		        'ajax_url' => admin_url('admin-ajax.php'),
		        'home_url' => get_home_url(),
		        'loadingmessage' => __('Até breve...'),
		        'logout_nonce' => wp_create_nonce('ajax-logout-nonce')
		    )
		);
	}
	
	function custom_ajax_logout_func(){
		check_ajax_referer( 'ajax-logout-nonce', 'ajaxsecurity' );
		wp_clear_auth_cookie();
		wp_logout();
		ob_clean();
		wp_die();
	}