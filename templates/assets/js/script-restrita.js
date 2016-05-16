// <![CDATA[
	jQuery(function($) {

		var data = new Date();
		var mes = data.getMonth()+1;
		var dia = data.getDate();
		var dataHoje = ((''+dia).length<2 ? '0' : '') + dia + '/' + ((''+mes).length<2 ? '0' : '') + mes + '/' + data.getFullYear();

		$('.clickable-row').click(function() {
	        window.document.location = $(this).data('href');
	    });
		
		$('#nav-informacoes a').on('click', function(e) {
		    e.preventDefault();
		    var $li = $(this).closest('li');

		    var tab = $li.data('tab');
		    var current = $('.active.setting-link').data('tab');

		    $('#info-inicial').remove();

		    $('#' + current).fadeOut('fast', function() {
		        //Slide the new div down
		        $('#' + tab).fadeIn();
		    });

		    //Remove active class from current link
		    $('.active.setting-link').removeClass('active');

		    $li.addClass('active');
		});

		$.fn.dataTable.moment('DD/MM');

		$('.table-default-ca.table-clinicas').DataTable( {
			dom: 'Bfrtip',
			lengthMenu: [
	            [ 10, 25, 50, -1 ],
	            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
	        ],
			"order": [[ 0, "asc" ]],
	    	"columnDefs": [ {
		          "targets": 'no-sort',
		          "orderable": false,
		    } ],
	        "language": {
	            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
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

		$('.table-default-ca.table-visita').DataTable( {
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
					title: 'Agenda de Visitas - '+ dataHoje,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				{
					extend: 'csvHtml5',
					title: 'Agenda de Visitas - '+ dataHoje,
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				}
	        ]
		} );

		$('.table-default-ca.table-gerenciar-promotores').DataTable( {
			dom: 'Bfrtip',
			lengthMenu: [
	            [ 10, 25, 50, -1 ],
	            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
	        ],
			"order": [[ 5, "asc" ]],
	        "language": {
	            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
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

	});
// ]]>