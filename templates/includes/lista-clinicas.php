<div class="table-2">
	<h3 style="text-align: center; text-transform: uppercase;">Informações da(s) Minha(s) Clinica(s)</h3>
	
	<table class="table-default-ca table-clinicas">
		<thead>
			<tr><th>Clinica</th><th>Veterinário</th><th>E-mail</th><th>Endereço</th><th>Cidada/UF</th><th>Telefone</th><th>Celular</th><th>Situação</th></tr>
		</thead>
		<tbody>
	<?php

		$args = array (
			'post_type'              => array( 'clinica' ),
			'post_status'            => array( 'publish' ),
			'author'                 => get_current_user_id(),
			'posts_per_page'         => -1,
		);

		$loop_inscricao = new WP_Query( $args );

		if ( $loop_inscricao->have_posts() ) {

			while ( $loop_inscricao->have_posts() ) { $loop_inscricao->the_post(); ?>
			<tr class="clickable-row" data-href="<?php the_permalink();?>">
				<td>
					<?php the_title(); ?>
				</td>
				<td>
				<?php
					$veterinario = get_field('nome_clinica');

					if (!empty($veterinario)) {
						the_field('nome_clinica');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					};

				?>
				</td>
				<td>
				<?php
					$email_clinica = get_field('email_clinica');
					
					if (!empty($email_clinica)) {
				?>
					<a href="mailto: <?php the_field('email_clinica'); ?>" title="Enviar email para: <?php the_field('email_clinica'); ?>"><?php the_field('email_clinica'); ?></a>
				<?php
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					};
				?>
					
				</td>
				<td>
				<?php
					$endereco_completo_clinica = get_field('endereco_completo_clinica');

					if (!empty($endereco_completo_clinica)) {
						the_field('endereco_completo_clinica');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					};

				?>
				</td>
				<td>
				<?php
					$cidade_uf = get_post_meta($post->ID, 'estado_cidade_clinica', true);
					if($cidade_uf != null){
						echo $cidade_uf['city_name'] . '/' . $cidade_uf['state_id'] ;
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					};
				?>
				</td>
				<td>
				<?php
					$telefone_clinica = get_field('telefone_clinica');

					if (!empty($telefone_clinica)) {
						the_field('telefone_clinica');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					};

				?>
				</td>
				<td>
				<?php
					$celular_clinica = get_field('celular_clinica');

					if (!empty($celular_clinica)) {
						the_field('celular_clinica');
					}else{
						echo '<strong class="alerta-informacoes">*</strong>';
					};

				?>
				</td>
				<td align="center">
					<?php
						$situacao = get_field('situacao_do_cadastro');

						if (empty($veterinario && $email_clinica && $endereco_completo_clinica && $cidade_uf && $telefone_clinica && $celular_clinica)) {
							echo '<abbr id="warning" class="dashicons-before dashicons-warning" title="Falta Informações sobre a Clinica"></abbr>';
						}elseif($situacao == null){
							echo '<abbr id="ativa" class="dashicons-before dashicons-yes" title="Cliníca Ativa"></abbr>';
						}else{
							echo '<abbr id="inativa" class="dashicons-before dashicons-no" title="Cliníca Inativa"></abbr>';
						}
					?>
				</td>
			</tr>
		<?php } } else { ?>
			<tr>
				<td colspan="8" align="center">
					Não existe nenhuma clínica cadastrada...
				</td>
			</tr>
		<?php } wp_reset_postdata(); ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">
					<form id="nova_clinica" name="nova_clinica" method="post" action="" class="front-end-form" enctype="multipart/form-data">
						
						<label class="adicionar-clinica" for="nome-clinica">Adicionar Nome da Clínica</label>
						
						<fieldset id="campos-clinica" style="display: none;">
					        <input type="text" id="nome-clinica" value="" tabindex="2" name="post_title" required />
					        <input class="button" type="submit" value="Nova Clínica" tabindex="40" id="submit" name="submit" />
					    </fieldset>
					
						<div class="errorTxt"></div>
						
					    <input type="hidden" name="action" value="nova_clinica" />
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
	    $('.clickable-row').click(function() {
	        window.document.location = $(this).data('href');
	    });
	    $( '.adicionar-clinica' ).click(function() {
		  $( '#campos-clinica' ).toggle( 'slow', function() {
		    // Animation complete.
		  });
		});
	});
</script>