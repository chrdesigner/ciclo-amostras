<div class="table-2">
	<h3 style="text-align: center; text-transform: uppercase;">Gerenciar Promotores</h3>	
	<table class="display table-default-ca table-gerenciar-promotores" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Nome do Promotor</th>
				<th class="no-sort">Email</th>
				<th>Cidade</th>
				<th>UF</th>
				<th class="no-sort">Telefone</th>
				<th class="no-sort">Clínicas/Veterinários</th>
				<th>Proxima Visita</th>
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

			while ( $gerenciar_promotores->have_posts() ) { $gerenciar_promotores->the_post();

			$id_post = get_the_ID();
			$estado_cidade_promotor = get_post_meta($id_post, 'estado_cidade_promotor', true);
		    $state_verification = $estado_cidade_promotor['state_name'];
		
		?>
			<tr>
				<td width="15%">
				<?php
					echo sprintf( '<a href="%1$s" title="%2$s %3$s" target="_blank">%2$s %3$s</a>', get_the_permalink($id_post), get_field('post_title'), get_field('sobrenome_promotor'));
				?>
				</td>
				<td width="15%">
				<?php
					$email_promotor = get_post_meta($id_post, 'email_promotor', true);
        			echo sprintf( '<a href="mailto:%1$s" title="%1$s">%1$s</a>', $email_promotor );
				?>
				</td>
				<td width="10%">
				<?php
					echo ! empty( $state_verification ) ? sprintf( '%1$s', $estado_cidade_promotor['city_name'] ) : 'Não Registrado';
				?>
				</td>
				<td width="5%">
				<?php
					echo ! empty( $state_verification ) ? sprintf( '%1$s', $estado_cidade_promotor['state_id'] ) : 'Não Registrado';
				?>
				</td>
				<td width="25%">
				<?php
					$telefone_promotor = get_post_meta($id_post, 'telefone_promotor', true);
		            $celular_promotor = get_post_meta($id_post, 'celular_promotor', true);
		            $return_tel = ! empty( $telefone_promotor ) ? sprintf( '%1$s', $telefone_promotor ) : 'Não preenchido';
		            $return_cel = ! empty( $celular_promotor ) ? sprintf( '%1$s', $celular_promotor ) : 'Não preenchido';
		        	echo '
		        		<ul class="info-tel-promotor">
		            	  	<li class="dashicons-before dashicons-phone">' . $return_tel . '</li>
		            	  	<li class="dashicons-before dashicons-smartphone">' . $return_cel . '</li>
		            	</ul>
		           	';
				?>
				</td>
				<td width="5%" align="center">
				<?php
					
					$get_email_promotor = get_post_meta($id_post, 'email_promotor', true);
		            $user_promotor = get_user_by( 'email', $get_email_promotor );
		            $get_id_user_promotor = $user_promotor->ID;

		        	echo '<span class="trigger">( <a data-id="box'.$get_id_user_promotor.'">' . count_user_posts( $get_id_user_promotor , "clinica"  ) . '</a> )</span>';
		        	
		        	$clinica_args = array(
		                'post_type'      => 'clinica',
		                'author'         => $get_id_user_promotor,
		                'posts_per_page' => -1,
		                'order' => 'ASC',
		            );
		            $clinica_query = new WP_Query( $clinica_args );
		            if ( $clinica_query->have_posts() ) {
		            echo '<ol id="box'.$get_id_user_promotor.'" class="toggle list-clinica-promotor" style="display: none;">';
		                while ( $clinica_query->have_posts() ) { $clinica_query->the_post();
		                    echo '<li>-> <a href="'. get_the_permalink() .'" title="Visualizar - '. get_the_title() .'" target="_blank">' . get_the_title() . ' </a></li>';
		                } 
		            echo '</ol>';
		            }
		            wp_reset_postdata();
		       ?>
				
				</td>
				<td width="25%" align="center">
				<?php
					$get_email_proxima = get_post_meta($id_post, 'email_promotor', true);
		            $user_proxima = get_user_by( 'email', $get_email_proxima );
		            $get_id_user_proxima = $user_proxima->ID;

		            $date_args = array(
		                'post_type'			=> array( 'gerenciar_visita' ),
						'post_status'		=> array( 'publish' ),
						'author'            => $get_id_user_proxima,
						'orderby' 			=> 'meta_value_num',
		                'order' 			=> 'ASC',
						'meta_query'        => array(
							array(
								'key'       => 'proxima_entrega',
								'value'     => date("Ymd"),
								'compare'   => '>=',
								'type'      => 'NUMERIC',
							),
						),
						'posts_per_page'	=> 1,
		            );
		            
		            $date_query = new WP_Query( $date_args );

		            if ( $date_query->have_posts() ) {

		                while ( $date_query->have_posts() ) { $date_query->the_post();

		                	$id_date = get_the_ID();
		                	$proxima_entrega = get_field('proxima_entrega', $id_date);
		                    $proxima_entrega = new DateTime($proxima_entrega);

		                    echo '<a href="'. get_the_permalink() .'" title="Visualizar - '. get_the_title() .'" target="_blank">' . $proxima_entrega->format('d/m/Y') . '</a>';
		                    
		                } 

		            } else {

		                echo '<strong>Sem registro</strong>';

		            } wp_reset_postdata();
				;?>
				</td>
			</tr>
		<?php } } wp_reset_postdata(); ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7">
					
				</td>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		jQuery(function($){
	        $(".trigger").click(function(){
			    var ol = $(this).next(".toggle");
			    $(".toggle").not(ol).slideUp("slow");
			    ol.slideToggle("slow");
			});
		});
	</script>
	<dl class="legenda-alerta">
		<dt>Legenda(s):</dt>
		<dd><sup class="alerta-informacoes">* Campos não cadastrados</sup></dd>
	</dl>
</div>