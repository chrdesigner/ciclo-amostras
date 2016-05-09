<?php
// Register Custom Post Type
function cpt_clinica() {

	$labels = array(
		'name'                  => _x( 'Clínicas/Veterinários', 'Post Type General Name', 'ciclo-amostras' ),
		'singular_name'         => _x( 'Clínica/Veterinário', 'Post Type Singular Name', 'ciclo-amostras' ),
		'menu_name'             => __( 'Clínica/Veterinário', 'ciclo-amostras' ),
		'name_admin_bar'        => __( 'Clínica/Veterinário', 'ciclo-amostras' ),
		'archives'              => __( 'Item Archives', 'ciclo-amostras' ),
		'parent_item_colon'     => __( 'Clínica/Veterinário Parente:', 'ciclo-amostras' ),
		'all_items'             => __( 'Todas as Clínicas/Veterinários', 'ciclo-amostras' ),
		'add_new_item'          => __( 'Adicionar Nova Clínica/Veterinário', 'ciclo-amostras' ),
		'add_new'               => __( 'Adicionar Nova', 'ciclo-amostras' ),
		'new_item'              => __( 'Nova Clínica/Veterinário', 'ciclo-amostras' ),
		'edit_item'             => __( 'Editar Clínica/Veterinário', 'ciclo-amostras' ),
		'update_item'           => __( 'Atualizar Clínica/Veterinário', 'ciclo-amostras' ),
		'view_item'             => __( 'Visualizar Clínica/Veterinário', 'ciclo-amostras' ),
		'search_items'          => __( 'Procurar Clínica/Veterinário', 'ciclo-amostras' ),
		'not_found'             => __( 'Nenhuma Clínica/Veterinário', 'ciclo-amostras' ),
		'not_found_in_trash'    => __( 'Nada Encontrado na Lixeira', 'ciclo-amostras' ),
		'featured_image'        => __( 'Imagem Destacada', 'ciclo-amostras' ),
		'set_featured_image'    => __( 'Aplicar Imagem Destacada', 'ciclo-amostras' ),
		'remove_featured_image' => __( 'Remover Imagem Destaca', 'ciclo-amostras' ),
		'use_featured_image'    => __( 'Usar como imagem destacada', 'ciclo-amostras' ),
		'insert_into_item'      => __( 'Insert into item', 'ciclo-amostras' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'ciclo-amostras' ),
		'items_list'            => __( 'Items list', 'ciclo-amostras' ),
		'items_list_navigation' => __( 'Items list navigation', 'ciclo-amostras' ),
		'filter_items_list'     => __( 'Filter items list', 'ciclo-amostras' ),
	);
	$args = array(
		'label'                 => __( 'Clínica/Veterinário', 'ciclo-amostras' ),
		'description'           => __( 'Cadastrar Clínica/Veterinário', 'ciclo-amostras' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-location',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'clinica', $args );
	flush_rewrite_rules();

}
add_action( 'init', 'cpt_clinica', 0 );