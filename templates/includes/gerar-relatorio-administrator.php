
	<div class="info-inicial">
		<h2>Selecione a Clínica ou Promotor para Gerar o Relatório</h2>
	</div>

	<form id="listar-minhas-clinicas" action="<?php bloginfo('url'); ?>" method="GET">

		<div class="styled-select">
			<select id="add-clinica" name="add-clinica" onchange="ajax_get_clinica()" required>


			<?php
				// WP_User_Query arguments
				$args = array (
					'role'           => 'promotor',
					'order'          => 'ASC',
					'orderby'        => 'user_login',
					'count_total'    => false,
					'fields'         => 'all',
				);

				// The User Query
				$promotor_query = new WP_User_Query( $args );

				// The User Loop
				if ( ! empty( $promotor_query->results ) ) {
				echo '<optgroup label="Promotores" id="promotores">
						<option class="ajax" value="" data-title="" data-group="">Selecione seu Promotores</option>
						<option class="ajax" value="todos-promotores" id="todos-promotores" data-title="Todos os Promotores" data-group="promotores">Selecione todos os Promotores</option>';
					foreach ( $promotor_query->results as $user ) {
						echo '<option class="ajax" value="' . $user->ID . '" id="' . $user->ID . '" data-title="' . $user->display_name . '" data-group="promotores">' . $user->display_name . '</option>';
						echo $user->ID;
						echo $user->display_name;
					}
				echo "</optgroup>";
				};
				
				$args = array (
					'post_type'              => array( 'clinica' ),
					'post_status'            => array( 'publish' ),
					'posts_per_page'         => -1,
				);

				$loop_add_visita = new WP_Query( $args );
				if ( $loop_add_visita->have_posts() ) {
				echo '<optgroup label="Clínicas" id="clinicas">
						<option class="ajax" value="" data-title="">Selecione sua Clínica</option>
						<option class="ajax" value="todas-clinicas" id="todas-clinicas" data-title="Todas as Clínicas" data-group="clinicas">Selecione todas as Clínicas</option>';
						while ( $loop_add_visita->have_posts() ) { $loop_add_visita->the_post();
						echo '<option class="ajax" value="' . get_the_ID() . '" id="' . get_the_ID() . '" data-title="' . get_the_title() . '" data-group="clinicas">' . get_the_title() . '</option>';
						}
				echo '</optgroup>';
				}
				
				wp_reset_postdata();
			?>
			</select>
		</div>

		<div id="loading-clinica" style="display: none;">
			<img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/images/loading.png"/>
		</div>

		<div id="geracao-relatorios"></div>

		<input type="hidden" name="todas_clinicas" id="hidden_clinica" value="" />

	</form>

	<script type="text/javascript">
		function ajax_get_clinica() {
			
			var selectBox = document.getElementById("add-clinica");
			var selectedValue = selectBox.options[selectBox.selectedIndex].id;
			
			var data = new Date();
			var mes = data.getMonth()+1;
			var dia = data.getDate();
			var dataHoje = ( (''+dia).length < 2 ? '0' : '' ) + dia + '/' + ( (''+mes).length < 2 ? '0' : '' ) + mes + '/' + data.getFullYear();

			var titulo = jQuery('option.ajax:selected').data('title');
			var grupo = jQuery('option.ajax:selected').data('group');

			var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";

		    jQuery("#loading-clinica").show();
		    jQuery("#geracao-relatorios").hide();

		    jQuery.ajax({
		        type: 'POST',
		        url: ajaxurl,
		        cache: false,
		        data: {
		        	'action':'load-clinica',
		        	grupo_value: grupo,
		        	clinica_value: selectedValue,
		        },
		        success: function(response) {
		        	
		        	jQuery("#geracao-relatorios").show().html(response);
		            jQuery("#loading-clinica").hide();

		            jQuery.fn.dataTable.moment('DD-MM-YYYY');

		            jQuery('.table-default-ca.table-relatorios').DataTable( {
						dom: 'Bfrtip',
						lengthMenu: [
				            [ 10, 25, 50, -1 ],
				            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
				        ],
				    	"order": [[ 3, "asc" ]],
						"columnDefs": [ {
					          "targets": 'no-sort',
					          "orderable": false,
					          "searchable": false
					    } ],
				        "language": {
				            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
				        },
				        buttons: [
				        	'pageLength',
							{
								extend: 'excelHtml5',
								title: titulo + ' - '+ dataHoje,
								exportOptions: {
									columns: ':not(.notPrintable)'
								}
							},
							{
								extend: 'csvHtml5',
								title: titulo + ' - '+ dataHoje,
								exportOptions: {
									columns: ':not(.notPrintable)'
								}
							}
				        ]
					} );

		            return false;
		        }
		    });

		};
	</script>