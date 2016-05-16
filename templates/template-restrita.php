<?php
/**
 * Template Name: Área Restrita
 *
 * Template para exibir Área Restrita.
 *
 */
	get_header(); ?>

	<div id="primary">
	
	<?php

	if ( ! is_user_logged_in() ) {

		include_once plugin_dir_path( __FILE__ ) . 'login/form-login.php';

	} else {

		wp_enqueue_style( 'style-restrita' );
		wp_enqueue_style( 'style-datatables' );
		wp_enqueue_script('script-jszip-js');
        wp_enqueue_script('script-restrita-js');
        wp_enqueue_script('script-datatables-js');
        wp_enqueue_script('script-moment-js');
        wp_enqueue_script('script-datetime-moment-js');
			
		require plugin_dir_path( __FILE__ ) . 'header-restitra.php';

		global $current_user;
			
		get_currentuserinfo();


		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);
		
		$user_marketing 	= 'marketing';
		$user_administrator = 'administrator';

	?>

		<nav id="nav-informacoes">
			<ul id="navigation">
				<li data-tab="clinicas" class="setting-link active">
					<a class="link_info dashicons-before dashicons-nametag" title="Minhas Clinicas"></a>
					<i class="tooltip">Minhas Clinicas</i>
				</li>
				<li data-tab="visita" class="setting-link">
					<a class="link_info dashicons-before dashicons-calendar" title="Agenda de Visitas"></a>
					<i class="tooltip">Agenda de Visitas</i>
				</li>
				<li data-tab="relatorio" class="setting-link">
					<a class="link_info dashicons-before dashicons-clipboard" title="Gerar Relatório"></a>
					<i class="tooltip">Gerar Relatório</i>
				</li>
			<?php if( $user_administrator == $user_role || $user_administrator == $user_role ) : ?>
				<li data-tab="gerenciar-promotores" class="setting-link">
					<a class="link_info private-link dashicons-before dashicons-chart-area" title="Gerenciar Promotores"></a>
					<i class="tooltip">Gerenciar Promotores</i>
				</li>
			<?php endif; ?>
			</ul>
		</nav>

		<div id="clinicas" class="nav-links" rel="1" style="display: block;">
	    	<?php require plugin_dir_path( __FILE__ ) . 'includes/lista-clinicas.php'; ?>
	    </div>

	    <div id="visita" class="nav-links" rel="2">
	   		<?php require plugin_dir_path( __FILE__ ) . 'includes/agenda-visita.php'; ?>
	    </div>

	    <div id="relatorio" class="nav-links" rel="3">
	    	<?php require plugin_dir_path( __FILE__ ) . 'includes/gerar-relatorio.php'; ?>
	    </div>

	<?php if( $user_administrator == $user_role || $user_administrator == $user_role ) : ?>
		<div id="gerenciar-promotores" class="nav-links" rel="999">
	    	<?php require plugin_dir_path( __FILE__ ) . 'includes/gerenciar-promotores.php'; ?>
	    </div>
	<?php endif; ?>

	<?php }; ?>

		
	</div><!-- #primary -->

<?php  get_footer(); ?>