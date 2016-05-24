<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	acf_form_head();

	require plugin_dir_path( __FILE__ ) . 'header-restrita.php'; 

?>
	
	<div id="primary">
	<?php

		if ( ! is_user_logged_in() ) {

			include_once plugin_dir_path( __FILE__ ) . 'login/form-login.php';

		} else {

			require plugin_dir_path( __FILE__ ) . 'header-information.php'; 

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

				<style>
					#map {
						width: 100%;
						height: 400px;
						position: relative;
						z-index: 0;
					}
				</style>
				
				<?php
					$citylat = get_field('citylat');
					$citylng = get_field('citylng'); 

					if($citylat == null || $citylng == null ){
						$clat = '-22.8950635';
						$clng = '-47.1703484';
					}else{
						$clat = $citylat;
						$clng = $citylng;
					}
				?>
			
				<script>
				// <![CDATA[
				
				jQuery(function($) {
			    	$('#acf-endereco_completo_clinica .acf-input-wrap').after( '<div id="map"></div>' );
			    });

			  

				function initMap() {

					var clat = (document.getElementById('input_key-field_572e9999a73a7').value);
			    	var clng = (document.getElementById('input_key-field_572e9988a73a7').value);

			    	var map = new google.maps.Map(document.getElementById('map'), {
			          center: { lat: clat, lng: clng},
			          zoom: 8
			        });

			        var input = (document.getElementById('acf-field-endereco_completo_clinica'));

			        //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			        var autocomplete = new google.maps.places.Autocomplete(input);
			        
			        autocomplete.bindTo('bounds', map);

			        var infowindow = new google.maps.InfoWindow();
			        
			        var marker = new google.maps.Marker({
			          map: map,
			          anchorPoint: new google.maps.Point(0, -29)
			        });

			        autocomplete.addListener('place_changed', function() {

						infowindow.close();
						marker.setVisible(false);

						var place = autocomplete.getPlace();

						if (!place.geometry) {
							window.alert("Autocomplete's returned place contains no geometry");
							return;
						}

						// If the place has a geometry, then present it on a map.
						if (place.geometry.viewport) {
							map.fitBounds(place.geometry.viewport);
						} else {
							map.setCenter(place.geometry.location);
							map.setZoom(17);  // Why 17? Because it looks good.
						}

						marker.setIcon(/** @type {google.maps.Icon} */({
							url: place.icon,
							size: new google.maps.Size(71, 71),
							origin: new google.maps.Point(0, 0),
							anchor: new google.maps.Point(17, 34),
							scaledSize: new google.maps.Size(35, 35)
						}));
						
						marker.setPosition(place.geometry.location);
						marker.setVisible(true);

						var address = '';
						
						if (place.address_components) {
							address = [
								(place.address_components[0] && place.address_components[0].short_name || ''),
								(place.address_components[1] && place.address_components[1].short_name || ''),
								(place.address_components[2] && place.address_components[2].short_name || '')
							].join(' ');
						}

						infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
						infowindow.open(map, marker);

			        });

			    }
			    setTimeout(initMap, 2800);
			// ]]>
			</script>
			


			<?php
				if(is_singular('gerenciar_visita')) :
				
					$posts = get_field('todas_clinicas');

					if( $posts ) : foreach( $posts as $p ) :

						echo '<h3 class="titulo-clinica">Esse relatório é referente à Clinica/Veterinário <a href="' . get_the_permalink($p->ID) . '" title="Visualize à Ficha da Clinica ' . get_the_title($p->ID) . '">' . get_the_title($p->ID) . '</a></h3>';

					endforeach; endif;
	
				endif;
			 	
			 	acf_form();
			?>

			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-FENs3Gc66W1vB-1ZuWbd6s3bbZVR9nk&amp;libraries=places&amp;callback=initMap" async defer></script>
			
			</section>
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
<?php require plugin_dir_path( __FILE__ ) . 'footer-restrita.php';  ?>