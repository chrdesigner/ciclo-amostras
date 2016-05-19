(function($){
	
	function initialize_field( $el ) {
		//$el.doStuff();
	}
	
	if( typeof acf.add_action !== 'undefined' ) {
		acf.add_action('ready append', function( $el ){
			acf.get_fields({ type : 'hidden'}, $el).each(function(){	
				initialize_field( $(this) );
			});
		});
	} else {
		$(document).live('acf/setup_fields', function(e, postbox){
			$(postbox).find('.field[data-field_type="hidden"]').each(function(){
				initialize_field( $(this) );
			});
		});
	}

})(jQuery);