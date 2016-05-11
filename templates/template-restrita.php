<?php
/**
 * Template Name: Área Restrita
 *
 * Template para exibir Área Restrita.
 *
 */
	get_header(); ?>

	<div id="primary">
	
	<?php

	if ( ! is_user_logged_in() ) {

		include_once plugin_dir_path( __FILE__ ) . 'login/form-login.php';

	} else {

		global $current_user;
      	get_currentuserinfo();

		?>

		<header class="header-restrita">
			<div class="main-info-restrita">
				<h1>Olá, <?php echo $current_user->display_name; ?></h1>
				<p class="status-logout"></p>
				<nav>
					<ul>
				<?php
					$args = array (
						'post_type'              => array( 'promotor' ),
						'post_status'            => array( 'publish' ),
						'author'                 => get_current_user_id(),
						'posts_per_page'         => 1,
					);
					$loop_promotor = new WP_Query( $args ); if ( $loop_promotor->have_posts() ) { while ( $loop_promotor->have_posts() ) { $loop_promotor->the_post(); ?>
						<li><a href="<?php the_permalink();?>" title="Meu Cadastro." class="dashicons-before dashicons-admin-generic">Meu Cadastro</a></li>
				<?php } } wp_reset_postdata(); ?>
					</ul>
				</nav>
			</div>
			<div class="logout-restrita">
				<a href="" class="logout dashicons-before dashicons-migrate">Sair</a>
			</div>
		</header>

		<?php
			$args = array (
				'post_type'              => array( 'clinica' ),
				'post_status'            => array( 'publish' ),
				'author'                 => get_current_user_id(),
				'posts_per_page'         => -1,
			);
			
			$loop_inscricao = new WP_Query( $args );

			
			if ( $loop_inscricao->have_posts() ) { ?>
			<div class="table-2">
				<h3 style="text-align: center; text-transform: uppercase;">Informações da(s) Minha(s) Clinica(s)</h3>
				
				<table class="table-clinicas">
					<thead>
						<tr>
							<th>Clinica</th>
							<th>Veterinário</th>
							<th>E-mail</th>
							<th>Endereço</th>
							<th>Cidada/UF</th>
							<th>Telefone</th>
							<th>Celular</th>
							<th>Situação</th>
						</tr>
					</thead>
					<tbody>
					<?php while ( $loop_inscricao->have_posts() ) { $loop_inscricao->the_post(); ?>
						<tr class="clickable-row" data-href="<?php the_permalink();?>">
							<td>
								<?php the_title(); ?>
							</td>
							<td>
								<?php the_field('nome_clinica'); ?>
							</td>
							<td>
								<a href="mailto: <?php the_field('email_clinica'); ?>" title="Enviar email para: <?php the_field('email_clinica'); ?>"><?php the_field('email_clinica'); ?></a>
							</td>
							<td>
								<?php the_field('endereco_completo_clinica'); ?>
							</td>
							<td>
								<?php
									$cidade_uf = get_post_meta($post->ID, 'estado_cidade_clinica', true);
									if($cidade_uf != null){
										echo $cidade_uf['city_name'] . '/' . $cidade_uf['state_id'] ;
									};
								?>
							</td>
							<td>
								<?php the_field('telefone_clinica'); ?>
							</td>
							<td>
								<?php the_field('celular_clinica'); ?>
							</td>
							<td align="center">
								<?php
									$situacao = get_field('situacao_do_cadastro');
									if($situacao == null){
										echo '<abbr id="ativa" class="dashicons-before dashicons-yes" title="Cliníca Ativa"></abbr>';
									}else{
										echo '<abbr id="inativa" class="dashicons-before dashicons-no" title="Cliníca Inativa"></abbr>';
									}
								?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="8">
								<form id="new_post" name="new_post" method="post" action="" class="front-end-form" enctype="multipart/form-data">
									
									<label class="adicionar-clinica" for="nome-clinica">Adicionar Nome da Clínica</label>
									
									<fieldset id="campos-clinica" style="display: none;">
								        <input type="text" id="nome-clinica" value="" tabindex="2" name="post_title" />
								        <input class="button view" type="submit" value="Criar Formulário" tabindex="40" id="submit" name="submit" />
								    </fieldset>
								
									<div class="errorTxt"></div>
								    <input type="hidden" name="action" value="new_post" />
								    <?php wp_nonce_field( 'new-post' ); ?>

								</form>
							</td>
						</tr>
					</tfoot>
				</table>
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

				<style type="text/css">
					.header-restrita{
						display: table;
						width: 100%;
					}

					.header-restrita > div{
						display: table-cell;
						vertical-align: middle;
					}

					.header-restrita > div.main-info-restrita{
						width: 90%;
					}

					.header-restrita > div.logout-restrita{
						width: 10%;
						text-align: right;
					}

					.header-restrita > div.main-info-restrita nav{
						width: 100%;
						text-align: left;
					}

					.header-restrita > div.main-info-restrita nav ul{
						list-style-type: none;
						margin: 0 0;
						padding: 0;
					}

					.table-clinicas{
						width: 100%;
						margin-bottom: 45px;
					}

					.table-clinicas > tbody > tr{
						cursor: pointer;
					}

					.table-clinicas > tbody > tr:hover{
						background-color: rgba(53, 53, 53, .7);
					}

					.table-clinicas > tbody > tr:nth-child(even){
						background-color: #23282D;
					}

					.table-clinicas > tbody > tr:hover:nth-child(even){
						background-color: rgba(35, 40, 45, .6);
					}

					.table-clinicas > tfoot > tr{
						background-color: #383838;
						border-top: 3px solid #aaa9a9;
					}

					.table-clinicas > tfoot > tr > td{
						padding-top: 15px;
						padding-bottom: 15px;
					}

					.table-clinicas > tfoot > tr > td #new_post label{
						cursor: pointer;
						color: #ED2224;
						font-weight: bold;
						text-transform: uppercase;
					}

					.table-clinicas > tfoot > tr > td #new_post fieldset{
						position: relative;
						width: 100%;
						margin-top: 15px;
					}

					#ativa{
						color: #34A853;
						text-decoration: none;
					}

					#inativa{
						color: #EA4335;
						text-decoration: none;
					}
				</style>
				
				<?php
			} 	

			wp_reset_postdata();
		?>

	
	<?php }; ?>

		
	</div><!-- #primary -->

<?php  get_footer(); ?>