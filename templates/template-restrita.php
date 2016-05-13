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
			
    <div style="display:none;">
	    <div id="aba_1">
	    	<?php require plugin_dir_path( __FILE__ ) . 'includes/lista-clinicas.php'; ?>
	    </div>

	    <div id="aba_2">
	   		<?php require plugin_dir_path( __FILE__ ) . 'includes/agenda-visita.php'; ?>
	    </div>
	</div>
	
	<nav id="nav-informacoes">
		<ul>
			<li>
				<a class="link_info dashicons-before dashicons-nametag" id="a1" title="Minhas Clinicas"></a>
				<i class="tooltip">Minhas Clininas</i>
			</li>
			<li>
				<a class="link_info dashicons-before dashicons-calendar" id="a2" title="Agenda de Visitas"></a>
				<i class="tooltip">Agenda de Visitas</i>
			</li>
		</ul>
	</nav>

	<div id="ajax">
		<h2 class="info-inicial">Clique nós icones acima para lista a tabela desejada</h2>
	</div>

	
	<?php }; ?>

		
	</div><!-- #primary -->

<?php  get_footer(); ?>