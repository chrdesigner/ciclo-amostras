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
		<?php
			$args = array (
				'post_type'              => array( 'promotor' ),
				'post_status'            => array( 'publish' ),
				'author'                 => get_current_user_id(),
				'posts_per_page'         => 1,
			);
			$loop_promotor = new WP_Query( $args ); if ( $loop_promotor->have_posts() ) { while ( $loop_promotor->have_posts() ) { $loop_promotor->the_post(); ?>
				<li><a href="<?php the_permalink();?>" title="Meu Cadastro." class="dashicons-before dashicons-admin-generic">Meu Cadastro</a></li>
		<?php } } wp_reset_postdata(); ?>
			</ul>
		</nav>
	</div>
	<div class="logout-restrita">
		<a href="" class="logout dashicons-before dashicons-migrate">Sair</a>
	</div>
</header>