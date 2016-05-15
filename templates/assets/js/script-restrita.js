// <![CDATA[
	jQuery(function($) {

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
	        	'excelHtml5',
    			'csvHtml5'
	        ]
		} );

		$('.table-default-ca.table-visita').DataTable( {
			dom: 'Bfrtip',
			lengthMenu: [
	            [ 10, 25, 50, -1 ],
	            [ '10 resultados', '25 resultados', '50 resultados', 'Todos os resultados' ]
	        ],
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
	         	'pageLength',
	        	'excelHtml5',
    			'csvHtml5'
	        ]
		} );

		$('#add-visita').change(function() {
	        var x = $(this).val();
	        $('#hidden_visita').val(x);
	    });

	    $('#add-clinica').change(function() {
	        var x = $(this).val();
	        $('#hidden_clinica').val(x);
	    });

	});
// ]]>