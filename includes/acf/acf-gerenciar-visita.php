<?php
	if(function_exists("register_field_group"))
	{
		register_field_group(array (
			'id' => 'acf_gerenciar-minhas-clinicas',
			'title' => 'Gerenciar Minhas Clínicas',
			'fields' => array (
				array (
					'key' => 'field_5733613a9ba39',
					'label' => 'Todas as Minhas Clínicas',
					'name' => 'todas_clinicas',
					'type' => 'relationship',
					'required' => 1,
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'null',
								'operator' => '==',
							),
						),
						'allorany' => 'all',
					),
					'return_format' => 'object',
					'post_type' => array (
						0 => 'clinica',
					),
					'taxonomy' => array (
						0 => 'all',
					),
					'filters' => array (
						0 => 'search',
					),
					'result_elements' => array (
						0 => 'post_title',
					),
					'max' => 1,
				),
				array (
					'key' => 'field_57338b57d62d5',
					'label' => 'Data Programada',
					'name' => 'data_programada',
					'type' => 'date_picker',
					'required' => 1,
					'date_format' => 'yymmdd',
					'display_format' => 'dd/mm/yy',
					'first_day' => 0,
				),
				array (
					'key' => 'field_57338b71d62d6',
					'label' => 'Proxima entrega',
					'name' => 'proxima_entrega',
					'type' => 'date_picker',
					'required' => 1,
					'date_format' => 'yymmdd',
					'display_format' => 'dd/mm/yy',
					'first_day' => 0,
				),
				array (
					'key' => 'field_5733c7b487866',
					'label' => 'Anotações do Promotor',
					'name' => 'relatorio_do_promotor',
					'type' => 'repeater',
					'sub_fields' => array (
						array (
							'key' => 'field_5733ca3697967',
							'label' => 'Data da Entrega da Amostra',
							'name' => 'data_entrega_amostra',
							'type' => 'date_picker',
							'instructions' => 'A data de entrega poderá ser alterada depois.',
							'required' => 0,
							'date_format' => 'yymmdd',
							'display_format' => 'dd/mm/yy',
							'first_day' => 0,
						),
						array (
							'key' => 'field_5733ca3687868',
							'label' => 'produtos',
							'name' => '',
							'type' => 'message',
							'column_width' => '',
							'message' => '<h3 style="margin: 0;">Produtos</h3>',
						),
						array (
							'key' => 'field_5733ca3687867',
							'label' => 'Informações dos Produtos',
							'name' => 'add_produtos',
							'type' => 'wysiwyg',
							'instructions' => 'Sugestão: Inclua um produto por linha.<br /><br /><i>Ex: Nome do produto - apresentação - quantidade > Calmisyn TP - 15 unidades/ Aminio Balance - 150g - 6 unidades</i>',
							'column_width' => '',
							'default_value' => '',
							'toolbar' => 'basic',
							'media_upload' => 'no',
						),
						array (
							'key' => 'field_5733ca3687968',
							'label' => 'observacoes',
							'name' => '',
							'type' => 'message',
							'column_width' => '',
							'message' => '<h3 style="margin: 0;">Observações</h3>',
						),
						array (
							'key' => 'field_5733ca3687967',
							'label' => 'Adicionar Observações',
							'name' => 'add_observacoes',
							'type' => 'wysiwyg',
							'instructions' => 'Inclua informações importantes relativas à visita e à entrega das amostras.<br /><br /><i>Ex: Produto entregue na recepção da clinica/veterinário não utilizou a amostra, irei retira-lo do programa.</i>',
							'column_width' => '',
							'default_value' => '',
							'toolbar' => 'basic',
							'media_upload' => 'no',
						),

					),
					'row_min' => 1,
					'row_limit' => '1',
					'layout' => 'row',
					'button_label' => 'Adicionar Novo Relatório',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'gerenciar_visita',
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
			'menu_order' => 0,
		));
	}