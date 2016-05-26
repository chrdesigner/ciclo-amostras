<?php

	global $current_user;
	
	get_currentuserinfo();

	// Current User
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	// Users Exceptions
	$user_administrator = 'administrator';
	$user_marketing = 'marketing';


	if( $user_administrator == $user_role || $user_marketing == $user_role) : 

		$addColspan = '10';
		$addClass = 'administrator-list';

		$args = array (
			'post_type'              => array( 'clinica' ),
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => -1,
		);

	else :

		$addColspan = '9';
		$addClass = 'promoter-list';

		$args = array (
			'post_type'              => array( 'clinica' ),
			'post_status'            => array( 'publish' ),
			'author'                 => get_current_user_id(),
			'posts_per_page'         => -1,
		);

	endif;

?>
<div class="table-2">
	<h3 style="text-align: center; text-transform: uppercase;">Informações da(s) Minha(s) Clínicas(s)</h3>
	
	<table class="table-default-ca table-clinicas <?php echo $addClass; ?>">
		<thead>
			<tr>
			<?php if( $user_administrator == $user_role || $user_marketing == $user_role) : ?>
				<th class="th-promotor">Promotor</th>
			<?php endif; ?>
				<th class="th-clinica">Clínica</th>
				<th class="th-veterinario">Veterinário</th>
				<th class="th-email no-sort">E-mail</th>
				<th class="th-endereco no-sort">Endereço</th>
				<th class="th-cidade">Cidade</th>
				<th class="th-estado">UF</th>
				<th class="th-telefone no-sort">Telefone</th>
				<th class="th-celular no-sort">Celular</th>
				<th>Situação</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$loop_inscricao = new WP_Query( $args );

		if ( $loop_inscricao->have_posts() ) {

			while ( $loop_inscricao->have_posts() ) { $loop_inscricao->the_post();

			// Vars
			$veterinario = get_field('nome_clinica');
			$email_clinica = get_field('email_clinica');
			$endereco_completo_clinica = get_field('endereco_completo_clinica');
			$cidade_uf = get_post_meta($post->ID, 'estado_cidade_clinica', true);
			$telefone_clinica = get_field('telefone_clinica');
			$celular_clinica = get_field('celular_clinica');
			$situacao = get_field('situacao_do_cadastro');

		?>
			<tr class="clickable-row clinic-row-<?php the_ID();?>" data-href="<?php the_permalink();?>">
			<?php if( $user_administrator == $user_role || $user_marketing == $user_role) : ?>
				<td>
					<?php the_author(); ?>
				</td>
			<?php endif;?>
				<td>
					<?php the_title(); ?>
				</td>
				<td>
					<?php if (!empty($veterinario)) { the_field('nome_clinica'); }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td>
					<?php if (!empty($email_clinica)) { ?><a href="mailto: <?php the_field('email_clinica'); ?>" title="Enviar email para: <?php the_field('email_clinica'); ?>"><?php the_field('email_clinica'); ?></a><?php }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td>
					<?php if (!empty($endereco_completo_clinica)) { the_field('endereco_completo_clinica'); }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td>
					<?php if($cidade_uf != null){ echo $cidade_uf['city_name']; }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td>
					<?php if($cidade_uf != null){ echo $cidade_uf['state_id']; }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td>
					<?php if (!empty($telefone_clinica)) { the_field('telefone_clinica'); }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td>
					<?php if (!empty($celular_clinica)) { the_field('celular_clinica'); }else{ echo '<strong class="alerta-informacoes">*</strong>'; }; ?>
				</td>
				<td align="center">
				<?php
					if ($veterinario == null && $email_clinica == null && $endereco_completo_clinica == null && $cidade_uf == null && $telefone_clinica == null && $celular_clinica == null) {
						echo '<abbr id="warning" class="dashicons-before dashicons-warning" title="Falta Informações sobre a Clinica">warning</abbr>';
					}elseif($situacao == null){
						echo '<abbr id="ativa" class="dashicons-before dashicons-yes" title="Cliníca Ativa">ativo</abbr>';
					}else{
						echo '<abbr id="inativa" class="dashicons-before dashicons-no" title="Cliníca Inativa">inativa</abbr>';
					}
				?>
				</td>
			</tr><?php
				}
			} else { ?>
			<tr>
				<td colspan="<?php echo $addColspan; ?>" align="center">
					Não existe nenhuma clínica cadastrada...
				</td>
			</tr>
		<?php } wp_reset_postdata(); ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<?php echo $addColspan; ?>">
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