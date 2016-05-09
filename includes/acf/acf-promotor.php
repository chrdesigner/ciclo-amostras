<?php
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_cadastro-promotor',
		'title' => 'Cadastro Promotor',
		'fields' => array (
			array (
				'key' => 'field_972e81e6a73a4',
				'label' => 'Nome',
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
				'key' => 'field_972e8214a73a6',
				'label' => 'E-mail',
				'name' => 'email_promotor',
				'type' => 'email',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_97309b56381dd',
				'label' => 'Selecione o Estado e a Cidade',
				'name' => 'estado_cidade_promotor',
				'type' => 'COUNTRY_FIELD',
			),
			array (
				'key' => 'field_972e8290a73aa',
				'label' => 'Telefone',
				'name' => 'telefone_promotor',
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
				'key' => 'field_972e82a8a73ab',
				'label' => 'Celular',
				'name' => 'celular_promotor',
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
				'key' => 'field_972e82b8a73ac',
				'label' => 'Senha de acesso',
				'name' => 'senha_de_acesso_promotor',
				'type' => 'password',
				'required' => 1,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'promotor',
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

}