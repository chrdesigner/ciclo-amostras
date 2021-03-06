<?php
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_cadastro-clinicaveterinario',
		'title' => 'Cadastro Clínica/Veterinário',
		'fields' => array (
			array (
				'key' => 'field_572e81e6a73a4',
				'label' => 'Nome do Veterinário',
				'name' => 'nome_clinica',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_572e8207a73a5',
				'label' => 'Clínica',
				'name' => 'post_title',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_572e8214a73a6',
				'label' => 'E-mail',
				'name' => 'email_clinica',
				'type' => 'email',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_572e8241a73a7',
				'label' => 'Endereço completo',
				'name' => 'endereco_completo_clinica',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_57309b56381dd',
				'label' => 'Selecione o Estado e a Cidade',
				'name' => 'estado_cidade_clinica',
				'type' => 'COUNTRY_FIELD',
			),
			array (
				'key' => 'field_572e8290a73aa',
				'label' => 'Telefone',
				'name' => 'telefone_clinica',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_572e82a8a73ab',
				'label' => 'Celular',
				'name' => 'celular_clinica',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'clinica',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 2,
	));

	register_field_group(array (
		'id' => 'acf_ativonao-ativo',
		'title' => 'Ativo/Não Ativo',
		'fields' => array (
			array (
				'key' => 'field_5730834a62b92',
				'label' => 'Situação do Cadastro',
				'name' => 'situacao_do_cadastro',
				'type' => 'true_false',
				'instructions' => 'Selecione o campo se o cadastro não estiver mais ativo',
				'required' => 0,
				'message' => 'Esse cadastrado não esta mais ativo',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'clinica',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 2,
	));
	
}