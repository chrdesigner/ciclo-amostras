<?php

	function meta_add_info_template_page() {
	    add_meta_box( 'informacao-template-page', 'Informação', 'cd_meta_info_template_page', 'page', 'normal', 'high' );
	}

	function cd_meta_info_template_page(){
		echo '<h1 style="color: red;">Atenção!!!</h1>';
	    echo '<p>Essa página esta sendo utilizada para a <strong>' . get_the_title($post->ID) . '</strong>.</p>';   
	    echo '<p>Qualquer alteração nessa página, poderá afetar o funcionamento do seu site.</p>';
	}

	function remove_suporte_template() {
	    if (isset($_GET['post'])) {
	        $id = $_GET['post'];
	        $template = get_post_meta($id, '_wp_page_template', true);

	        if($template == '../template-restrita.php'){

	        	// Remove suporte do Editor/Thumbnail da Página.
	            remove_post_type_support( 'page', 'editor' );
	            remove_post_type_support( 'page', 'thumbnail' );
	            remove_post_type_support( 'page', 'comments' );
	           
	            if ( is_admin() ) {

					function remove_restrita_meta_boxes() {
						remove_meta_box( 'mymetabox_revslider_0', array('page'), 'normal' );
						remove_meta_box( 'wpseo_meta', array('page'), 'normal' );
						remove_meta_box( 'pyre_page_options', array('page'), 'advanced' );
						remove_meta_box( 'WPSR_meta_box', array('page'), 'advanced' );
						remove_meta_box( 'featured-image-2_page', array('page'), 'side' );
						remove_meta_box( 'featured-image-3_page', array('page'), 'side' );
						remove_meta_box( 'featured-image-4_page', array('page'), 'side' );
						remove_meta_box( 'featured-image-5_page', array('page'), 'side' );
					}

					add_action( 'do_meta_boxes', 'remove_restrita_meta_boxes' );
					
				}

				//Adiciona uma informação na página.
	            add_action( 'add_meta_boxes', 'meta_add_info_template_page' );


	        }
	    }
	}
	add_action('init', 'remove_suporte_template');