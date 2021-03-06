// <![CDATA[
	jQuery(function($) {

		$('#add-visita').change(function() {
	        var t = $('#add-visita option:selected').data('titulo');
	        var x = $(this).val();
	        
			$('#hidden_title_clinica').val(t);
	        $('#hidden_visita').val(x);
	    });

	    $('#add-clinica').change(function() {
	        var x = $(this).val();
	        $('#hidden_clinica').val(x);
	    });

		var date = new Date();
		var mes = date.getMonth()+1;
		var dia = date.getDate();
		var dataHoje = ((''+dia).length<2 ? '0' : '') + dia + '/' + ((''+mes).length<2 ? '0' : '') + mes + '/' + date.getFullYear();

		var url_language = 'http://cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json';
		
		$.fn.dataTable.moment('DD-MM-YYYY');

		$('.table-default-ca.table-clinicas').DataTable( {
			dom: 'Bfrtip',
			//scrollX: true,
			lengthMenu: [
	            [ 10, 25, 50, -1 ],
	            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
	        ],
			order: [[ 0, "asc" ]],
	    	columnDefs: [ {
		          'targets': 'no-sort',
		          'orderable': false,
		    } ],
	        language: {
	            'url': url_language
	        },
	        buttons: [
	         	'pageLength',
				{
					extend: 'excelHtml5',
					title: 'Minhas Clinicas - '+ dataHoje,
				},
				{
					extend: 'csvHtml5',
					title: 'Minhas Clinicas - '+ dataHoje,
				}
	        ]
		} );

		$('.table-default-ca.table-gerenciar-promotores').DataTable( {
			dom: 'Bfrtip',
			lengthMenu: [
	            [ 10, 25, 50, -1 ],
	            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
	        ],
	        //scrollX: true,
			order: [[ 6, 'asc' ]],
			columnDefs: [ {
		          'targets': 'no-sort',
		          'orderable': false,
		          'searchable': false
		    } ],
	        language: {
	            'url': url_language
	        },
	        buttons: [
	         	'pageLength',
				{
					extend: 'excelHtml5',
					title: 'Gerenciar Promotores - '+ dataHoje,
				},
				{
					extend: 'csvHtml5',
					title: 'Gerenciar Promotores - '+ dataHoje,
				}
	        ]
		} );

		$('.table-default-ca.table-visita').DataTable( {
			dom: 'Bfrtip',
			lengthMenu: [
	            [ 10, 25, 50, -1 ],
	            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
	        ],
	        //scrollX: true,
	    	order: [[ 6, 'asc' ]],
	    	columnDefs: [ {
		          'targets': 'no-sort',
		          'orderable': false,
		          'searchable': false
		    } ],
	        language: {
	            'url': url_language
	        },
	        buttons: [
	         	'pageLength',
				{
					extend: 'excelHtml5',
					title: 'Agenda de Visitas - '+ dataHoje,
					exportOptions: {
						columns: ':not(.notPrintable)'
					}
				},
				{
					extend: 'csvHtml5',
					title: 'Agenda de Visitas - '+ dataHoje,
					exportOptions: {
						columns: ':not(.notPrintable)'
					}
				}
	        ]
		} );

	});
// ]]>