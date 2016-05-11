<?php acf_form_head(); ?>
<?php get_header(); ?>

	<div id="primary">
	<?php

		if ( ! is_user_logged_in() ) {

			include_once plugin_dir_path( __FILE__ ) . 'login/form-login.php';

		} else {

			require plugin_dir_path( __FILE__ ) . 'header-restitra.php'; 

			$current_user_id = get_current_user_id();

			$post_author_id = get_post_field( 'post_author', $post_id );

			
			if($current_user_id == $post_author_id ) :

				while ( have_posts() ) : the_post();
			?>
				
				<h1><?php the_title(); ?></h1><?php


				if(is_singular('promotor')){ echo get_the_author(); } ; 

					acf_form();

				endwhile;

			else :

				echo '<h2 style="text-align: center;">Desculpa, mas você não tem acesso a essa página.</h2>';
				echo '<h4 style="text-align: center;">Por favor, se você você é o Promotor responsável a esses dados entre em contato conosco.</h4>';

			endif;
		};
	
	?>


	</div><!-- #primary -->

<?php get_footer(); ?>