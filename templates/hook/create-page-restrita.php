<?php
	$page_title = __('&#193;rea Restrita', 'ciclo-amostras');
	$check_title=get_page_by_title($page_title, 'OBJECT', 'page');
	if (empty($check_title) ){
	    $page_area_restrita = array(
	        'post_title'     => $page_title,
	        'post_type'      => 'page',
	        'post_name'      => __('area-restrita', 'ciclo-amostras'),
	        'comment_status' => 'closed',
	        'ping_status'    => 'closed',
	        'post_status'    => 'publish',
	        'post_author'    => 1,
	        'menu_order'     => 0,
	    );
	    
	    $postID = wp_insert_post($page_area_restrita, $error);

	    update_post_meta($postID, "_wp_page_template", "../template-restrita.php");

	}