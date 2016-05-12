<?php
// Register Custom Post Type
function cpt_gerenciar() {

	$labels = array(
		'name'                  => _x( 'Gerenciar Visita', 'Post Type General Name', 'ciclo-amostras' ),
		'singular_name'         => _x( 'Visita', 'Post Type Singular Name', 'ciclo-amostras' ),
		'menu_name'             => __( 'Visitas', 'ciclo-amostras' ),
		'name_admin_bar'        => __( 'Gerenciar Visita', 'ciclo-amostras' ),
		'archives'              => __( 'Item Archives', 'ciclo-amostras' ),
		'parent_item_colon'     => __( 'Visita Parente:', 'ciclo-amostras' ),
		'all_items'             => __( 'Todas as Visitas', 'ciclo-amostras' ),
		'add_new_item'          => __( 'Adicionar Nova Visita', 'ciclo-amostras' ),
		'add_new'               => __( 'Adicionar Nova', 'ciclo-amostras' ),
		'new_item'              => __( 'Nova Visita', 'ciclo-amostras' ),
		'edit_item'             => __( 'Editar Visita', 'ciclo-amostras' ),
		'update_item'           => __( 'Atualizar Visita', 'ciclo-amostras' ),
		'view_item'             => __( 'Visualizar Visita', 'ciclo-amostras' ),
		'search_items'          => __( 'Procurar Visita', 'ciclo-amostras' ),
		'not_found'             => __( 'Nenhuma Visita', 'ciclo-amostras' ),
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
		'label'                 => __( 'Visita', 'ciclo-amostras' ),
		'description'           => __( 'Gerenciar Visita', 'ciclo-amostras' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 7,
		'menu_icon'             => 'dashicons-calendar',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'gerenciar_visita', $args );
	flush_rewrite_rules();

}
add_action( 'init', 'cpt_gerenciar', 0 );