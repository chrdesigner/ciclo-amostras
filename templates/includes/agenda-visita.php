<?php
	global $current_user;
		
	get_currentuserinfo();

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	$user_administrator = 'administrator';
	$user_marketing = 'marketing';


	if( $user_administrator == $user_role || $user_marketing == $user_role ) {

		$args = array (
			'post_type'			=> array( 'gerenciar_visita' ),
			'post_status'		=> array( 'publish' ),
			'posts_per_page'	=> -1,
			// 'meta_query'        => array(
			// 	array(
			// 		'key'       => 'proxima_entrega',
			// 		'value'     => date('Ymd'),
			// 		'compare'   => '>=',
			// 		'type'      => 'NUMERIC',
			// 	),
			// ),
		);

	}else{

		$args = array (
			'post_type'			=> array( 'gerenciar_visita' ),
			'post_status'		=> array( 'publish' ),
			'author'            => get_current_user_id(),
			'posts_per_page'	=> -1,
			// 'meta_query'        => array(
			// 	array(
			// 		'key'       => 'proxima_entrega',
			// 		'value'     => date('Ymd'),
			// 		'compare'   => '>=',
			// 		'type'      => 'NUMERIC',
			// 	),
			// ),
		);

	};
?>
<div class="table-2">
	<h3 style="text-align: center; text-transform: uppercase;">Minha(s) Visita(s)</h3>	
	<table class="display table-default-ca table-visita <?php echo $addClass; ?>" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th class="notPrintable">Ciclo</th>
				<th>Nome da Clínica</th>
				<th>Nome do Veterinário</th>
				<th>Cidade</th>
				<th>UF</th>
				<th>Data Programada</th>
				<th>Entrega da amostra</th>
				<th>Proxima entrega</th>
				<th class="no-sort notPrintable">Histórico</th>
			</tr>
		</thead>
		<tbody>
			
	<?php

		$loop_visita = new WP_Query( $args );

		if ( $loop_visita->have_posts() ) {

			$count = 0;

			while ( $loop_visita->have_posts() ) { $loop_visita->the_post(); $count ++;

			$posts = get_field('todas_clinicas');
			$ciclo_visite_acabou = get_field('ciclo_visite_acabou');
		?>
			
			<tr class="clickable-row" data-href="<?php the_permalink();?>">
				<td class="notPrintable">
					<?php echo '<span style="display: none">' . $count . '</span>';?>
					<?php
						if($ciclo_visite_acabou == null){
							echo '<abbr id="ativa" class="dashicons-before dashicons-thumbs-up" title="Ciclo de Visita está ativo">ativo</abbr>';
						}else{
							echo '<abbr id="inativa" class="dashicons-before dashicons-flag" title="Ciclo de Visita está finalizada">inativa</abbr>';
						}
					?>
				</td>
				<td>
				<?php
					

					if( $posts ) :
						foreach( $posts as $p ) :

							echo get_the_title($p->ID);

					 	endforeach;
					endif;
				?>
				</td>
				<td>
				<?php
					if( $posts ) :
						foreach( $posts as $p ) :

							echo get_field('nome_clinica', $p->ID);

					 	endforeach;
					endif;
				?>
				</td>
				<td>
				<?php
					if( $posts ) :
						foreach( $posts as $p ) :

							$cidade_uf = get_field('estado_cidade_clinica', $p->ID);

							if($cidade_uf != null){
								echo $cidade_uf['city_name'];
							};

					 	endforeach;
					endif;
				?>
				</td>
				<td>
				<?php
					if( $posts ) :
						foreach( $posts as $p ) :

							$cidade_uf = get_field('estado_cidade_clinica', $p->ID);

							if($cidade_uf != null){
								echo $cidade_uf['state_id'] ;
							};

					 	endforeach;
					endif;
				?>
				</td>
				<td>
				<?php
					$verifica_programada = get_field('data_programada');
					$data_programada = get_field('data_programada', false, false);
					$data_programada = new DateTime($data_programada);

					if($verifica_programada != null){
						echo $data_programada->format('d-m-Y');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					}
				?>
				</td>
				<td>
				<?php
					if( have_rows('relatorio_do_promotor') ):
					    while( have_rows('relatorio_do_promotor') ) : the_row();
					        
					        $data_programada = get_sub_field('data_entrega_amostra', false, false);

					        if( $data_programada != null){
					        
					        	$data_programada = new DateTime($data_programada);

					        	echo $data_programada->format('d-m-Y');

					        }else{

								echo '<strong class="alerta-informacoes">*</strong>';
							
							}

					    endwhile;
					endif;
				?>
				</td>
				<td>
				<?php
					$verifica_entrega = get_field('proxima_entrega');
					$proxima_entrega = get_field('proxima_entrega', false, false);
					$proxima_entrega = new DateTime($proxima_entrega);

					if($verifica_entrega != null){
						echo $proxima_entrega->format('d-m-Y');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					}
				?>
				</td>
				<td class="td-historico notPrintable">
					<a href="<?php the_permalink();?>#acf-relatorio_do_promotor" title="Ver Histórico">Ver</a>
				</td>
			</tr>
			<?php
				}
			} else { ?>
			<tr>
				<td colspan="<?php echo $addColspan; ?>" align="center">
					Não existe nenhuma clínica cadastrada...
				</td>
			</tr>
		<?php   } wp_reset_postdata(); ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="9">
					<form id="nova_visita" name="nova_visita" method="post" action="" class="front-end-form" enctype="multipart/form-data">
						<label class="adicionar-visita" for="nome-visita">Adicionar Nova Visita</label>
						<fieldset id="campos-visita" style="display: none;">
							<?php
								date_default_timezone_set('America/Sao_Paulo');
								$today = date("d/m/Y"); 

								$args = array (
										'post_type'              => array( 'clinica' ),
										'post_status'            => array( 'publish' ),
										'author'                 => get_current_user_id(),
										'posts_per_page'         => -1,
									);

									$loop_add_visita = new WP_Query( $args );

									if ( $loop_add_visita->have_posts() ) {
									
								echo '<select id="add-visita" name="add-visita" required>
										<option value="">Selecione sua clínica</option>';
									while ( $loop_add_visita->have_posts() ) { $loop_add_visita->the_post();
										echo '<option value=' . get_the_ID() . ' data-titulo="' . get_the_title() . '">' . get_the_title() . '</option>';
									}
								echo '</select>';
									
									}

								wp_reset_postdata();
							?>
					        <input class="button" type="submit" value="Nova Visita" tabindex="40" id="submitButtonId" name="submit" />
					    </fieldset>			
						
						<div class="errorTxt"></div>
						
					    <input type="hidden" name="todas_clinicas" id="hidden_visita" value="" />
					    <input type="hidden" name="todas_title_clinica" id="hidden_title_clinica" value="" />
					    <input type="hidden" name="data_atual" value="<?php echo $today; ?>" />
					    <input type="hidden" name="action" value="nova_visita" />
					    <?php wp_nonce_field( 'new-post' ); ?>
					</form>
				</td>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		    $( '.adicionar-visita' ).on('click', function(e) {
		    	e.preventDefault();
				$( '#campos-visita' ).toggle( 'slow', function() {
					// Animation complete.
				});
			});
		});
	</script>
	<dl class="legenda-alerta">
		<dt>Legenda(s):</dt>
		<dd><sup class="alerta-informacoes">* Campos não cadastrados</sup></dd>
	</dl>
</div>