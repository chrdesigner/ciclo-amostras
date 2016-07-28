<?php
	
	function load_relatorio_clinica () {

        $id_clinica = $_POST[ 'clinica_value' ];

        $value_group = $_POST[ 'grupo_value' ];

		$post_author_id = get_post_field( 'post_author', $id_clinica );

		global $current_user;
	
		get_currentuserinfo();

		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);

		$user_administrator = 'administrator';
		$user_marketing = 'marketing';
        
	if( $id_clinica == null ){ }else{

		// Verifica se é optgroup Promotores
		if($value_group == 'promotores') :
			// Exibirá todas as clinicas referentes a todos os promotores
			if( $id_clinica == 'todos-promotores' ) :
				$relatorios = get_posts( array( 'post_type' => 'gerenciar_visita', 'post_status' => array( 'publish' ), 'order' => 'ASC', 'posts_per_page' => -1 ) );
			// Exibirá todas as clinicas referentes a um promotor especifico
			else :
				$relatorios = get_posts( array( 'post_type' => 'gerenciar_visita', 'post_status' => array( 'publish' ), 'author' => $id_clinica, 'order' => 'ASC', 'posts_per_page'  => -1 ) );
			endif;

		// Termina a verificação de promotores e inicia das clinicas
		else :

        if( $id_clinica == 'todas-clinicas' ){
        	// Exibirá todas as clinicas - Adm / Mkt
	        if( $user_administrator == $user_role || $user_marketing == $user_role ) :
	        	$relatorios = get_posts( array( 'post_type' => 'gerenciar_visita', 'post_status' => array( 'publish' ), 'order' => 'ASC', 'posts_per_page' => -1, ) );
	        // Exibirá todas as clinicas especifica por promotor
	        else :
	        	$relatorios = get_posts( array( 'post_type' => 'gerenciar_visita', 'post_status' => array( 'publish' ), 'author' => get_current_user_id(), 'order' => 'ASC', 'posts_per_page' => -1, ) );
	        endif;
        
		}else{
			// Exibirá as clinicas especifica por promotor - Adm / Mkt
       		if( $user_administrator == $user_role || $user_marketing == $user_role ) :
				$relatorios = get_posts( array( 'post_type' => 'gerenciar_visita', 'post_status' => array( 'publish' ), 'meta_key' => 'proxima_entrega', 'orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_query' => array( array( 'key' => 'todas_clinicas', 'value' => '"' . $id_clinica . '"', 'compare' => 'LIKE' ) ), 'posts_per_page'  => -1, ) );
	        // Exibirá as clinicas especifica selecionada pelo promotor
	        else :
	        	$relatorios = get_posts( array( 'post_type' => 'gerenciar_visita', 'post_status' => array( 'publish' ), 'author' => get_current_user_id(), 'meta_key' => 'proxima_entrega', 'orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_query' => array( array( 'key' => 'todas_clinicas', 'value' => '"' . $id_clinica . '"', 'compare' => 'LIKE' ) ), 'posts_per_page' => -1 ) );
	        endif;

		}
		// Termina a verificação de clinicas
		endif;
	?>
    <div class="table-2">
        <table class="table-default-ca table-relatorios">
            <thead>
                <tr>
                <?php if($value_group == 'promotores') : ?>
                	<th>Nome do Promotor</th>
                <?php endif; ?>
                    <th>Nome da Clínica</th>
					<th>Nome do Veterinário</th>
                    <th>Data programada</th>
                    <th>Data entrega da amostra</th>
                    <th>Proxima entrega</th>
                    <th class="no-sort">Produtos</th>
                    <th class="no-sort">Obervações</th>
                    <th class="no-sort notPrintable"></th>
                </tr>
            </thead>
            <tbody>
        	<?php if( $relatorios ) : foreach( $relatorios as $relatorio ) : $posts = get_field('todas_clinicas', $relatorio->ID); ?>
	            <?php if($value_group == 'promotores') : ?>
	            	<td>
	            	<?php
	            		$get_id_author = $relatorio->post_author;
	            		$show_author = get_user_by('id', $get_id_author);
						echo $show_author->display_name;
	            	?>
	            	</td>
	            <?php endif; ?>
	            	<td>
	            	<?php
	            		if( $posts ) : foreach( $posts as $p ) :
							echo get_the_title($p->ID);
						endforeach; endif;
					?>
	            	</td>
	            	
	            	<td>
	            	<?php
						if( $posts ) : foreach( $posts as $p ) :
							echo get_field('nome_clinica', $p->ID);
					 	endforeach; endif;
					?>
	            	</td>

	                <td>
	                <?php
	                    $data_programada = get_field('data_programada', $relatorio->ID);
	                    $data_programada = new DateTime($data_programada);
	                    
	                    echo $data_programada->format('d-m-Y');  
	                ?>
	                </td>
	                
	                <td>
	                <?php
	                	$programada_rows = get_field('relatorio_do_promotor', $relatorio->ID);
	                	if($programada_rows) {
							foreach($programada_rows as $programada) {
								$data_programada = $programada['data_entrega_amostra'];
								$data_programada = new DateTime($data_programada);

								echo $data_programada->format('d-m-Y');
							}
						}
	                ?>
					</td>
	                
	                <td>
	                <?php
	                    $proxima_entrega = get_field('proxima_entrega', $relatorio->ID);
	                    $proxima_entrega = new DateTime($proxima_entrega);

	                    echo $proxima_entrega->format('d-m-Y');
	                ?>
	                </td>
	                
	                <td>
	                <?php
	                	$produtos_rows = get_field('relatorio_do_promotor', $relatorio->ID);
	                	if($produtos_rows) {
							foreach($produtos_rows as $produto) {
								echo $produto['add_produtos'];
							}
						}
	                ?>
	                </td>

	                <td>
	                <?php
	                	$observacoes_rows = get_field('relatorio_do_promotor', $relatorio->ID);
	                	if($observacoes_rows) {
							foreach($observacoes_rows as $observacao) {
								echo $observacao['add_observacoes'];
							}
						}
	                ?>
	                </td>
	                
	                <td class="notPrintable">
	                    <a href="<?php echo get_permalink( $relatorio->ID ); ?>" class="dashicons-before dashicons-edit" title="Editar Relatório">Editar</a>
	                </td>
	            </tr>
        	<?php endforeach; endif;?>
            </tbody>
        </table>
	</div><?php
	};

	$response = ob_get_contents();
	ob_end_clean();

	echo $response;
	die();
}

add_action( 'wp_ajax_load-clinica', 'load_relatorio_clinica' );
add_action( 'wp_ajax_nopriv_load-clinica', 'load_relatorio_clinica' );