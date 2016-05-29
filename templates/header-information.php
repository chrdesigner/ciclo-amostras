<?php
	
	global $current_user;
	get_currentuserinfo();

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	$user_marketing 	= 'marketing';
	$user_administrator = 'administrator';

?>
<header class="header-restrita">
	<div class="main-info-restrita">
		<h1>Olá, <?php echo $current_user->display_name; ?></h1>
		<p class="status-logout"></p>
		<nav id="sub-informacoes">
			<ul>
				<li>Navegação</li>
			<?php
				
				$args = array (
					'post_type' => 'page',
					'posts_per_page' => 1,
					'fields' => 'ids',
					'nopaging' => true,
					'meta_key' => '_wp_page_template',
					'meta_value' => '../template-restrita.php'
				);
				
				$pages = get_posts( $args ); foreach ( $pages as $page ) :
			?>

				<li><a href="<?php echo esc_url( get_permalink($page) ); ?>" title="Informações Iniciais." class="dashicons-before dashicons-admin-home"></a></li>
				
			<?php if( !is_page_template( '../template-restrita.php' ) ) : ?>
				
				<li data-tab="clinicas" class="setting-link active"><a href="<?php echo esc_url( get_permalink($page) ); ?>#clinicas" title="Minhas Clínicas." class="link_info dashicons-before dashicons-nametag"></a></li>

				<li data-tab="visita" class="setting-link"><a href="<?php echo esc_url( get_permalink($page) ); ?>#visita" title="Agenda de Visitas." class="link_info dashicons-before dashicons-calendar"></a></li>

				<li data-tab="relatorio" class="setting-link"><a href="<?php echo esc_url( get_permalink($page) ); ?>#relatorio" title="Gerar Relatório." class="link_info dashicons-before dashicons-clipboard"></a></li>
				
				<?php if( $user_administrator == $user_role || $user_marketing == $user_role ) : ?>

				<li data-tab="gerenciar-promotores" class="setting-link"><a href="<?php echo esc_url( get_permalink($page) ); ?>#gerenciar-promotores" title="Gerenciar Promotores." class="link_info dashicons-before dashicons-chart-area"></a></li>
				
				<?php endif; ?>
			
			<?php endif; ?>

			<?php endforeach; ?>

			<?php $args = array ( 'post_type' => array( 'promotor' ), 'post_status' => array( 'publish' ), 'author' => get_current_user_id(), 'posts_per_page' => 1, ); $loop_promotor = new WP_Query( $args ); if ( $loop_promotor->have_posts() ) { while ( $loop_promotor->have_posts() ) { $loop_promotor->the_post(); ?>
				<li><a href="<?php the_permalink();?>" title="Meu Cadastro." class="dashicons-before dashicons-admin-generic"></a></li>
			<?php } } wp_reset_postdata(); ?>
				<li class="btn-logout"><a href="" class="logout dashicons-before dashicons-migrate" title="Sair"></a></li>
			</ul>
		</nav>
	</div>
</header>