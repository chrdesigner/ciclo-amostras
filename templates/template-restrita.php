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
			
		require plugin_dir_path( __FILE__ ) . 'header-restitra.php';
		wp_enqueue_script( 'script-restrita-js', plugin_dir_url( __FILE__ ) . 'assets/js/script-restrita.js', array('jquery'), true );

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
		</ul>
	</nav>

	<div id="info-inicial">
		<h2>Clique nós icones acima para lista a tabela desejada</h2>
	</div>

	<div id="clinicas" class="nav-links" rel="1">
    	<?php require plugin_dir_path( __FILE__ ) . 'includes/lista-clinicas.php'; ?>
    </div>

    <div id="visita" class="nav-links" rel="2">
   		<?php require plugin_dir_path( __FILE__ ) . 'includes/agenda-visita.php'; ?>
    </div>

	
	<?php }; ?>

		
	</div><!-- #primary -->

<?php  get_footer(); ?>