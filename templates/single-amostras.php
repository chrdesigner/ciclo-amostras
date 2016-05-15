<?php acf_form_head(); ?>
<?php get_header(); ?>
	<div id="primary">
	<?php

		if ( ! is_user_logged_in() ) {

			include_once plugin_dir_path( __FILE__ ) . 'login/form-login.php';

		} else {

			require plugin_dir_path( __FILE__ ) . 'header-restitra.php'; 

			global $current_user;
			
			get_currentuserinfo();

			$user_roles = $current_user->roles;
			$user_role = array_shift($user_roles);
			$user_administrator = 'administrator';

			$current_user_id = get_current_user_id();
			$post_author_id = get_post_field( 'post_author', $post_id );

			if($current_user_id == $post_author_id || $user_administrator == $user_role) :

				while ( have_posts() ) : the_post();
			?>
				
				<h1 class="ca-titulo-padrao"><?php the_title(); ?></h1>
				
			<?php if($user_administrator == $user_role){ ?>
				
				<h3 class="alerta-adm">Olá Administrador, esse página pertence ao Promotor <i><?php the_author(); ?></i></h3>
				
			<?php };?>

			<section id="ca-content-main">
			<?php
				if(is_singular('gerenciar_visita')){
				
					$posts = get_field('todas_clinicas');

					if( $posts ) : foreach( $posts as $p ) :

						echo '<h3 class="titulo-clinica">Esse relatório é referente à Clinica/Veterinário <a href="' . get_the_permalink($p->ID) . '" title="Visualize à Ficha da Clinica ' . get_the_title($p->ID) . '">' . get_the_title($p->ID) . '</a></h3>';

					endforeach; endif;
	
				};
			?>

				<?php acf_form(); ?>

				<a id="btnExport">XLS</a>
			</section>
			
			<script type="text/javascript">
			// <![CDATA[
			jQuery(document).ready( function ($) {
				$("#btnExport").click(function(e) {
				    window.open('data:application/vnd.ms-excel,' + $('#ca-content-main').html());
				    e.preventDefault();
				});
			});
			</script>

			<?php 
				endwhile;

			else : ?>
				<blockquote class="alert-sem-permissao">
					<h2>Desculpa, mas você não tem acesso a essa página.</h2>
					<h4>Por favor, se você você é o Promotor responsável a esses dados entre em contato conosco.</h4>
				</blockquote>
		<?php
			endif;
		};
	
	?>
	</div><!-- #primary -->
<?php get_footer(); ?>