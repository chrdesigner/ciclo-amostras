<div class="table-2">
	<h3 style="text-align: center; text-transform: uppercase;">Minha(s) Visita(s)</h3>	
	<table class="table-default-ca table-visita">
		<thead>
			<tr>
				<th>Nome do Relatório</th>
				<th>Nome da Clinica</th>
				<th>Região</th>
				<th>Entrega da amostra</th>
				<th>Próxima entrega</th>
				<th>Histórico</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$args = array (
			'post_type'              => array( 'gerenciar_visita' ),
			'post_status'            => array( 'publish' ),
			'author'                 => get_current_user_id(),
			'posts_per_page'         => -1,
		);

		$loop_visita = new WP_Query( $args );

		if ( $loop_visita->have_posts() ) {

			while ( $loop_visita->have_posts() ) { $loop_visita->the_post(); ?>
			<tr class="clickable-row" data-href="<?php the_permalink();?>">
				<td>
					<?php the_title(); ?>
				</td>
				<td>
					<?php
						$posts = get_field('todas_clinicas');

						if( $posts ) :
							foreach( $posts as $p ) :

								echo get_the_title($p->ID);

						 	endforeach;
						endif;
					?>
				</td>
				<td>
				<?php
					$posts = get_field('todas_clinicas');

					if( $posts ) :
						foreach( $posts as $p ) :

							$cidade_uf = get_field('estado_cidade_clinica', $p->ID);

							if($cidade_uf != null){
								echo $cidade_uf['city_name'] . '/' . $cidade_uf['state_id'] ;
							};

					 	endforeach;
					endif;
				?>
				</td>
				<td>
				<?php
					if( have_rows('relatorio_do_promotor') ):
					    while( have_rows('relatorio_do_promotor') ) : the_row();
					        
					        $data_programada = get_sub_field('data_entrega_amostra', false, false);
					        $data_programada = new DateTime($data_programada);

					        echo $data_programada->format('d/m');

					    endwhile;

					    else :

					    	echo '<strong class="alerta-informacoes">*</strong>';

					endif;
				?>
				</td>
				<td>
				<?php
					$verifica_entrega = get_field('proxima_entrega');
					$proxima_entrega = get_field('proxima_entrega', false, false);
					$proxima_entrega = new DateTime($proxima_entrega);

					if($verifica_entrega != null){
						echo $proxima_entrega->format('d/m');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					}
				?>
				</td>
				<td>
					<a href="<?php the_permalink();?>#acf-relatorio_do_promotor" title="Ver Histórico">Ver</a>
				</td>
			</tr>
		<?php } } else { ?>
			<tr>
				<td colspan="6" align="center">
					Não existe nenhuma visita cadastrada...
				</td>
			</tr>
		<?php } wp_reset_postdata(); ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">
					<form id="nova_visita" name="nova_visita" method="post" action="" class="front-end-form" enctype="multipart/form-data">
						<label class="adicionar-visita" for="nome-visita">Adicionar Visita</label>
						<fieldset id="campos-visita" style="display: none;">
							<input type="text" id="titulo-relatorio" value="" tabindex="2" name="post_title" placeholder="Nome do Relatório: " required />
							<?php
								$args = array (
										'post_type'              => array( 'clinica' ),
										'post_status'            => array( 'publish' ),
										'author'                 => get_current_user_id(),
										'posts_per_page'         => -1,
									);

									$loop_add_visita = new WP_Query( $args );

									if ( $loop_add_visita->have_posts() ) {
									
								echo '<select id="add-visita" name="add-visita" required>
										<option value="">Selecione sua clinica</option>';
									while ( $loop_add_visita->have_posts() ) { $loop_add_visita->the_post();
										echo '<option value=' . get_the_ID() . '>' . get_the_title() . '</option>';
									}
								echo '</select>';
									
									}

								wp_reset_postdata();
							?>
					        <input class="button" type="submit" value="Nova Visita" tabindex="40" id="submitButtonId" name="submit" />
					    </fieldset>			
						<div class="errorTxt"></div>
					    <input type="hidden" name="todas_clinicas" id="hidden_visita" value="" />
					    <input type="hidden" name="action" value="nova_visita" />
					    <?php wp_nonce_field( 'new-post' ); ?>
					</form>
				</td>
			</tr>
		</tfoot>
	</table>
	<dl class="legenda-alerta">
		<dt>Legenda(s):</dt>
		<dd><sup class="alerta-informacoes">* Campos não cadastrados</sup></dd>
	</dl>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $( '.adicionar-visita' ).click(function() {
		  $( '#campos-visita' ).toggle( 'slow', function() {
		    // Animation complete.
		  });
		});
	});
</script>