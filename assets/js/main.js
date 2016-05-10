// <![CDATA[
jQuery(function($) {
	
	//find the hidden post type input, and grab the value
	if($('#post_type').val() === 'promotor'){
		$('#title').attr('disabled','disabled');
		$( "#post-body #acf-estado_cidade_promotor.field" ).removeClass( "required" );
		$( "#post-body #acf-telefone_promotor.field" ).removeClass( "required" );
		$( "#post-body #acf-celular_promotor.field" ).removeClass( "required" );
	}

	$.mask.definitions['~']='[+-]';
	//Inicio Mascara Telefone
	$('#acf-field-telefone_clinica, #acf-field-telefone_promotor, #acf-field-celular_clinica, #acf-field-celular_promotor').focusout(function(){
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
			element.mask("(99) 99999-999?9");
		} else {
			element.mask("(99) 9999-9999?9");
		}
	}).trigger('focusout');

});
// ]]>