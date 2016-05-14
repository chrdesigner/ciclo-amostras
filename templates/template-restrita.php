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
        wp_enqueue_script('script-restrita-js');
			
		require plugin_dir_path( __FILE__ ) . 'header-restitra.php';

	?>

		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/bs-3.3.6/pdfmake-0.1.18,dt-1.10.11,af-2.1.1,b-1.1.2,b-html5-1.1.2/datatables.min.css"/>
 		<script type="text/javascript" src="https://cdn.datatables.net/t/bs-3.3.6/pdfmake-0.1.18,dt-1.10.11,af-2.1.1,b-1.1.2,b-html5-1.1.2/datatables.min.js"></script>

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

		<div id="clinicas" class="nav-links" rel="1" style="display: block;">
	    	<?php require plugin_dir_path( __FILE__ ) . 'includes/lista-clinicas.php'; ?>
	    </div>

	    <div id="visita" class="nav-links" rel="2">
	   		<?php require plugin_dir_path( __FILE__ ) . 'includes/agenda-visita.php'; ?>
	    </div>

	    <script>
		// <![CDATA[
			jQuery(function($) {

			    $('.table-default-ca.table-clinicas').DataTable( {
			    	"order": [[ 0, "asc" ]],
			    	"columnDefs": [ {
				          "targets": 'no-sort',
				          "orderable": false,
				    } ],
			        "language": {
			            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
			        },
			        buttons: [
				        'excel', 'pdf'
				    ]
				} );

				$('.table-default-ca.table-visita').DataTable( {
			    	"order": [[ 4, "desc" ]],
			    	"columnDefs": [ {
				          "targets": 'no-sort',
				          "orderable": false,
				          "searchable": false
				    } ],
			        "language": {
			            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
			        },
			        buttons: [
				        'excel', 'pdf'
				    ]
				} );

			} );
	    // ]]>
	    </script>

	<?php }; ?>

		
	</div><!-- #primary -->

<?php  get_footer(); ?>