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

	});
// ]]>