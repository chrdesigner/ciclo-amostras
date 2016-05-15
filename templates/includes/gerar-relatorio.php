
	<div class="info-inicial">
		<h2>Selecione à Clinica desejada</h2>
	</div>

	<form id="listar-minhas-clinicas" action="<?php bloginfo('url'); ?>" method="GET">

	<?php
		$args = array (
			'post_type'              => array( 'clinica' ),
			'post_status'            => array( 'publish' ),
			'author'                 => get_current_user_id(),
			'posts_per_page'         => -1,
		);
		$loop_add_visita = new WP_Query( $args );
		if ( $loop_add_visita->have_posts() ) {

		echo '<select id="add-clinica" name="add-clinica" onchange="ajax_get_clinica()"  required>
				<option class="ajax" value="" data-title="">Selecione sua clinica</option>';
			while ( $loop_add_visita->have_posts() ) { $loop_add_visita->the_post();
			echo '<option class="ajax" value="' . get_the_ID() . '" id="' . get_the_ID() . '" data-title="' . get_the_title() . '">' . get_the_title() . '</option>';
			}
		echo '</select>';

		}
		wp_reset_postdata();
	?>

		<div id="loading-animation" style="display: none;">
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
			var dataHoje = ((''+dia).length<2 ? '0' : '') + dia + '/' + ((''+mes).length<2 ? '0' : '') + mes + '/' + data.getFullYear();

			var titulo = jQuery('option.ajax:selected').data('title');

			var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";

		    jQuery("#loading-animation").show();
		    jQuery("#geracao-relatorios").hide();

		    jQuery.ajax({
		        type: 'POST',
		        url: ajaxurl,
		        cache: false,
		        data: {
		        	'action':'load-clinica',
		        	clinica_value: selectedValue
		        },
		        success: function(response) {
		        	//alert(dataHoje);

		        	jQuery("#geracao-relatorios").show().html(response);
		            jQuery("#loading-animation").hide();

		            jQuery.fn.dataTable.moment('DD/MM');

		            jQuery('.table-default-ca.table-relatorios').DataTable( {
						dom: 'Bfrtip',
						lengthMenu: [
				            [ 10, 25, 50, -1 ],
				            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
				        ],
				    	"order": [[ 2, "desc" ]],
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
									columns: [ 0, 1, 2, 4 ]
								}
							},
							{
								extend: 'csvHtml5',
								title: titulo + ' - '+ dataHoje,
								exportOptions: {
									columns: [ 0, 1, 2, 4 ]
								}
							}
				        ]
					} );
		            return false;
		        }
		    });

		};
	</script>