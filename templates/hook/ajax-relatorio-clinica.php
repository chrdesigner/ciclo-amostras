<?php
	
	function load_relatorio_clinica () {

        $id_clinica = $_POST[ 'clinica_value' ];
		$post_author_id = get_post_field( 'post_author', $id_clinica );

		global $current_user;
	
		get_currentuserinfo();

		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		$user_administrator = 'administrator';
        
        if( $id_clinica == null ){ }else{


        if( $user_administrator == $user_role ) {

        	$relatorios = get_posts(array(
	            'post_type'     => 'gerenciar_visita',
	            'post_status'   => array( 'publish' ),
	            'meta_key'		=> 'proxima_entrega',
				'orderby'		=> 'meta_value_num',
				'order'			=> 'ASC',
	            'meta_query' => array(
	                array(
	                    'key'		=> 'todas_clinicas',
	                    'value' 	=> '"' . $id_clinica . '"',
	                    'compare' 	=> 'LIKE'
	                )
	            ),
	            'posts_per_page'  => -1,
	        ));

        }else{

        	$relatorios = get_posts(array(
	            'post_type'     => 'gerenciar_visita',
	            'post_status'   => array( 'publish' ),
	            'author'        => get_current_user_id(),
	            'meta_key'		=> 'proxima_entrega',
				'orderby'		=> 'meta_value_num',
				'order'			=> 'ASC',
	            'meta_query' => array(
	                array(
	                    'key'		=> 'todas_clinicas',
	                    'value' 	=> '"' . $id_clinica . '"',
	                    'compare' 	=> 'LIKE'
	                )
	            ),
	            'posts_per_page'  => -1,
	        ));

        };

	?>
    <div class="table-2">
        <table class="table-default-ca table-relatorios">
            <thead>
                <tr>
                    <th>Data programada</th>
                    <th>Data entrega da amostra</th>
                    <th>Proxima entrega</th>
                    <th class="no-sort">Produtos</th>
                    <th class="no-sort">Obervações</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
        	<?php  if( $relatorios ) : foreach( $relatorios as $relatorio ) : ?>
	            <tr>
	                <td width="16%">
	                <?php
	                    $data_programada = get_field('data_programada', $relatorio->ID);
	                    $data_programada = new DateTime($data_programada);
	                    
	                    echo $data_programada->format('d/m/Y');  
	                ?>
	                </td>
	                <td width="16%">
	                <?php
	                	$programada_rows = get_field('relatorio_do_promotor', $relatorio->ID);
	                	if($programada_rows) {
							foreach($programada_rows as $programada) {
								$data_programada = $programada['data_entrega_amostra'];
								$data_programada = new DateTime($data_programada);

								echo $data_programada->format('d/m/Y');
							}
						}
	                ?>
					</td>
	                <td width="16%">
	                <?php
	                    $proxima_entrega = get_field('proxima_entrega', $relatorio->ID);
	                    $proxima_entrega = new DateTime($proxima_entrega);

	                    echo $proxima_entrega->format('d/m/Y');
	                ?>
	                </td>
	                <td width="25%">
	                <?php
	                	$produtos_rows = get_field('relatorio_do_promotor', $relatorio->ID);
	                	if($produtos_rows) {
							foreach($produtos_rows as $produto) {
								echo $produto['add_produtos'];
							}
						}
	                ?>
	                </td>
	                <td width="25%">
	                <?php
	                	$observacoes_rows = get_field('relatorio_do_promotor', $relatorio->ID);
	                	if($observacoes_rows) {
							foreach($observacoes_rows as $observacao) {
								echo $observacao['add_observacoes'];
							}
						}
	                ?>
	                </td>
	                <td width="2%">
	                    <a href="<?php echo get_permalink( $relatorio->ID ); ?>" class="dashicons-before dashicons-edit" title="Editar Relatório">Editar</a>
	                </td>
	            </tr>
        	<?php endforeach; endif;?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="detalhes-relatorio">
                        Clinica: <?php echo get_the_title( $id_clinica ); ?> - Promotor: <?php the_author_meta( 'display_name', $post_author_id ); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
	</div><?php

	}

	$response = ob_get_contents();
	ob_end_clean();

	echo $response;
	die();
}

add_action( 'wp_ajax_load-clinica', 'load_relatorio_clinica' );
add_action( 'wp_ajax_nopriv_load-clinica', 'load_relatorio_clinica' );