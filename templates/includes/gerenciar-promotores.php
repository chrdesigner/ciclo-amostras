<div class="table-2">
	<h3 style="text-align: center; text-transform: uppercase;">Gerenciar Promotores</h3>	
	<table class="table-default-ca table-gerenciar-promotores">
		<thead>
			<tr>
				<th>Nome do Promotor</th>
				<th>Email</th>
				<th>Cidade/UF</th>
				<th class="no-sort">Telefone</th>
				<th>Clinicas/Veterinários</th>
				<th>Próximo ciclo de visita</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$args = array (
			'post_type'			=> array( 'promotor' ),
			'post_status'		=> array( 'publish' ),
			'order'				=> 'ASC',
			'posts_per_page'	=> -1,
		);

		$gerenciar_promotores = new WP_Query( $args );

		if ( $gerenciar_promotores->have_posts() ) {

			while ( $gerenciar_promotores->have_posts() ) { $gerenciar_promotores->the_post(); ?>
			<tr>
				<td width="20%">
					<?php echo get_field('post_title') . ' ' . get_field('sobrenome_promotor'); ?>
				</td>
				<td width="20%">
					<?php
						$email_promotor = get_post_meta(get_the_ID(), 'email_promotor', true);
            			echo sprintf( '<a href="mailto:%1$s" title="%1$s">%1$s</a>', $email_promotor );
					?>
				</td>
				<td width="10%">
				<?php
					$estado_cidade_promotor = get_post_meta(get_the_ID(), 'estado_cidade_promotor', true);
		            $state_verification = $estado_cidade_promotor['state_name'];
		            echo ! empty( $state_verification ) ? sprintf( '%1$s/%2$s', $estado_cidade_promotor['city_name'], $estado_cidade_promotor['state_id'] ) : 'Não Registrado';
				?>
				</td>
				<td width="20%">
				<?php
					$telefone_promotor = get_post_meta(get_the_ID(), 'telefone_promotor', true);
		            $celular_promotor = get_post_meta(get_the_ID(), 'celular_promotor', true);
		            $return_tel = ! empty( $telefone_promotor ) ? sprintf( '%1$s', $telefone_promotor ) : 'Não preenchido';
		            $return_cel = ! empty( $celular_promotor ) ? sprintf( '%1$s', $celular_promotor ) : 'Não preenchido';
		            echo '<ul class="info-tel-promotor"><li class="dashicons-before dashicons-phone">' . $return_tel . '</li><li class="dashicons-before dashicons-smartphone">' . $return_cel . '</li></ul>';
				?>
				</td>
				<td width="5%" align="center">
				<?php
					$get_email = get_post_meta(get_the_ID(), 'email_promotor', true);
		            $user = get_user_by( 'email', $get_email );
		            $get_id_user = $user->ID;
		            $get_display_name_user = $user->display_name;
		            echo sprintf( '<a href="%1$s" title="Clinica(s) Cadastrada(s) por %2$s">%3$s</a>', admin_url( 'edit.php?post_type=clinica&author=' . $get_id_user ), $get_display_name_user, count_user_posts( $get_id_user , "clinica"  ) );
				?>
				</td>
				<td width="25%" align="center">
				<?php
					$get_email = get_post_meta(get_the_ID(), 'email_promotor', true);
		            $user = get_user_by( 'email', $get_email );
		            $get_id_user = $user->ID;

		            $date_args = array(
		                'post_type'      => 'gerenciar_visita',
		                'meta_key'       => 'proxima_entrega',
		                'author'         => $get_id_user,
		                'posts_per_page' => 1,
		                'orderby' => 'meta_value_num',
		                'order' => 'ASC',
		                'meta_query'=> array(
		                    array(
		                      'key' => 'proxima_entrega',
		                      'compare' => '>',
		                      'value' => date("Ymd"),
		                      'type' => 'DATE'
		                    )
		                ),
		            );
		            
		            $date_query = new WP_Query( $date_args );

		            if ( $date_query->have_posts() ) {

		                while ( $date_query->have_posts() ) { $date_query->the_post();

		                    $verifica_entrega = get_field('proxima_entrega');
		                    $proxima_entrega = get_field('proxima_entrega', false, false);
		                    $proxima_entrega = new DateTime($proxima_entrega);

		                    echo '<a href="'. get_the_permalink() .'" title="Visualizar - '. get_the_title() .'" target="_blank">' . $proxima_entrega->format('d/m/Y') . '</a>';
		                    
		                } 

		            } else {

		                echo '<strong>Sem registro</strong>';

		            } wp_reset_postdata();
				;?>
				</td>
			</tr>
		<?php } } else { ?>
			<tr>
				<td colspan="6" align="center">
					Não existe nenhum promotor registrado...
				</td>
			</tr>
		<?php } wp_reset_postdata(); ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					
				</td>
			</tr>
		</tfoot>
	</table>
	<dl class="legenda-alerta">
		<dt>Legenda(s):</dt>
		<dd><sup class="alerta-informacoes">* Campos não cadastrados</sup></dd>
	</dl>
</div>