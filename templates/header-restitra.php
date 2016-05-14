<?php
	
	global $current_user;
	get_currentuserinfo();

?>
<header class="header-restrita">
	<div class="main-info-restrita">
		<h1>Olá, <?php echo $current_user->display_name; ?></h1>
		<p class="status-logout"></p>
		<nav>
			<ul>
				<li>Meu Perfil</li>
				<?php $args = [ 'post_type' => 'page', 'posts_per_page' => 1, 'fields' => 'ids', 'nopaging' => true, 'meta_key' => '_wp_page_template', 'meta_value' => '../template-restrita.php' ]; $pages = get_posts( $args ); foreach ( $pages as $page ) { ?>
				<li><a href="<?php echo esc_url( get_permalink($page) ); ?>" title="Informações Iniciais." class="dashicons-before dashicons-admin-home"></a></li><?php }; ?>
				<?php $args = array ( 'post_type' => array( 'promotor' ), 'post_status' => array( 'publish' ), 'author' => get_current_user_id(), 'posts_per_page' => 1, ); $loop_promotor = new WP_Query( $args ); if ( $loop_promotor->have_posts() ) { while ( $loop_promotor->have_posts() ) { $loop_promotor->the_post(); ?>
				<li><a href="<?php the_permalink();?>" title="Meu Cadastro." class="dashicons-before dashicons-admin-generic"></a></li><?php } } wp_reset_postdata(); ?>
				<li class="btn-logout"><a href="" class="logout dashicons-before dashicons-migrate" title="Sair"></a></li>
			</ul>
		</nav>
	</div>
</header>