
	<div class="info-inicial">
		<h2>Selecione a Clínica para Gerar o Relatório</h2>
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

		echo '
		<div class="styled-select">
			<select id="add-clinica" name="add-clinica" onchange="ajax_get_clinica()" required>
				<option class="ajax" value="" data-title="">Selecione sua Clínica</option>
				<option class="ajax" value="todas-clinicas" id="todas-clinicas" data-title="Selecione todas as Clínicas">Selecione todas as Clínicas</option>';
			while ( $loop_add_visita->have_posts() ) { $loop_add_visita->the_post();
			echo '<option class="ajax" value="' . get_the_ID() . '" id="' . get_the_ID() . '" data-title="' . get_the_title() . '">' . get_the_title() . '</option>';
			}
		echo '
			</select>
		</div>';

		} else {
			echo '<strong style="text-align: center; display: inline-block; width: 100%; font-size: 2rem; color: #fff;">Ainda não existe nenhum relatório para ser gerado</strong>';
		} wp_reset_postdata();
	?>

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
			var dataHoje = ( (''+dia).length < 2 ? '0' : '' ) + dia + '-' + ( (''+mes).length < 2 ? '0' : '' ) + mes + '-' + data.getFullYear();

			var titulo = jQuery('option.ajax:selected').data('title');

			var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";

		    jQuery("#loading-clinica").show();
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
		        	
		        	jQuery("#geracao-relatorios").show().html(response);
		            jQuery("#loading-clinica").hide();

		            jQuery.fn.dataTable.moment('DD-MM-YYYY');

		            jQuery('.table-default-ca.table-relatorios').DataTable( {
						dom: 'Bfrtip',
						lengthMenu: [
				            [ 10, 25, 50, -1 ],
				            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
				        ],
				    	"order": [[ 4, "asc" ]],
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

					$.fn.dataTableExt.afnFiltering.push(
						function( oSettings, aData, iDataIndex ) {
							
							var today = new Date();
							var dd = today.getDate();
							var mm = today.getMonth();
							var yyyy = today.getFullYear();
							
							if (dd < 10) dd = '0'+dd;
							
							if (mm < 10) mm = '0'+mm;
							
							today = dd+'-'+mm+'-'+yyyy;
							
							if ($('#min').val() != '' || $('#max').val() != '') {
								var iMin_temp = $('#min').val();
								if (iMin_temp == '') {
									iMin_temp = '01-01-1980';
								}
								
								var iMax_temp = $('#max').val();
								if (iMax_temp == '') {
									iMax_temp = today;
								}
								
								var arr_min = iMin_temp.split('-');
								var arr_max = iMax_temp.split('-');
								var arr_date = aData[4].split('-');

								var iMin  = new Date( arr_min[2],  arr_min[1],  arr_min[0], 0, 0, 0, 0);
								var iMax  = new Date( arr_max[2],  arr_max[1],  arr_max[0], 0, 0, 0, 0);
								var iDate = new Date( arr_date[2], arr_date[1], arr_date[0], 0, 0, 0, 0);
								
								if ( iMin == '' && iMax == '' )
								{
									return true;
								}
								else if ( iMin == '' && iDate < iMax )
								{
									return true;
								}
								else if ( iMin <= iDate && '' == iMax )
								{
									return true;
								}
								else if ( iMin <= iDate && iDate <= iMax )
								{
									return true;
								}

								// console.log('Minimo ' + iMin);
								// console.log('Maximo ' + iMax);
								// console.log('Data ' + iDate);
								
								return false;

							}
						}
					);

					$(document).ready(function(){

				        $(function() {
				            $( '.date-filter' ).datepicker({
							    dateFormat: 'dd-mm-yy',
							    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
							    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
							    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
							    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
							    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
							    nextText: 'Próximo',
							    prevText: 'Anterior'
							});
				        });

				        var oTable=$('.table-default-ca.table-relatorios').dataTable();

				        /* Add event listeners to the two date-range filtering inputs */

				   		$('#min').change( function() { oTable.fnDraw(); } );
				        $('#max').change( function() { oTable.fnDraw(); } );

				    });

		            return false;
		        }
		    });

		};
	</script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>