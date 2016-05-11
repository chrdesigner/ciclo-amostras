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

	} else { ?>

		<div id="content" role="main">
	
			<h1>Olá, <?php the_author() ?></h1>

			<p class="status-logout"></p>
			<a href="" class="logout">Sair</a>

			<?php
				$args = array (
					'post_type'              => array( 'clinica' ),
					'post_status'            => array( 'publish' ),
					'author'                 => get_current_user_id(),
					'posts_per_page'         => -1,
				);
				
				$loop_inscricao = new WP_Query( $args );

				
				if ( $loop_inscricao->have_posts() ) { ?>
					<dl>
						<dt style="text-align: center; text-transform: uppercase;">
							<h3>Informações da(s) Minha(s) Clinica(s)</h3>
						</dt>
					<?php while ( $loop_inscricao->have_posts() ) { $loop_inscricao->the_post(); ?>
						<dd><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></dd>
					<?php } ?>
					</dl>

					<?php
				} 	

				wp_reset_postdata();
			?>


			<form id="new_post" name="new_post" method="post" action="" class="front-end-form" enctype="multipart/form-data">
			
				<fieldset>
			        <label for="nome-clinica">Adicionar Nome da Clínica</label><br />
					<input type="text" id="nome-clinica" value="" tabindex="2" name="post_title" />
			        <input class="button view" type="submit" value="Criar Formulário" tabindex="40" id="submit" name="submit" />
			    </fieldset>
			
				<div class="errorTxt"></div>
			    <input type="hidden" name="action" value="new_post" />
			    <?php wp_nonce_field( 'new-post' ); ?>
			</form>
			



		</div><!-- #content -->
	
	<?php }; ?>

		
	</div><!-- #primary -->

<?php  get_footer(); ?>