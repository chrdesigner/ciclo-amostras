<!DOCTYPE html>
<?php global $smof_data, $woocommerce; ?>
<html class="<?php echo ( ! $smof_data['smooth_scrolling'] ) ? 'no-overflow-y' : ''; ?>" xmlns="http<?php echo (is_ssl())? 's' : ''; ?>://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<?php
	if( isset( $_SERVER['HTTP_USER_AGENT'] ) &&
		( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false )
	) {
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
	}
	?>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?php wp_title( '' ); ?></title>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<?php $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
		if($smof_data['responsive']):
		if(!$isiPad || !$smof_data['ipad_potrait']):
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<?php endif; endif; ?>

	<?php if($smof_data['favicon']): ?>
	<link rel="shortcut icon" href="<?php echo $smof_data['favicon']; ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php if($smof_data['iphone_icon']): ?>
	<!-- For iPhone -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo $smof_data['iphone_icon']; ?>">
	<?php endif; ?>

	<?php if($smof_data['iphone_icon_retina']): ?>
	<!-- For iPhone 4 Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $smof_data['iphone_icon_retina']; ?>">
	<?php endif; ?>

	<?php if($smof_data['ipad_icon']): ?>
	<!-- For iPad -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $smof_data['ipad_icon']; ?>">
	<?php endif; ?>

	<?php if($smof_data['ipad_icon_retina']): ?>
	<!-- For iPad Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $smof_data['ipad_icon_retina']; ?>">
	<?php endif; ?>

	<?php wp_head(); ?>

	<!--[if lte IE 8]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	var imgs, i, w;
	var imgs = document.getElementsByTagName( 'img' );
	for( i = 0; i < imgs.length; i++ ) {
		w = imgs[i].getAttribute( 'width' );
		imgs[i].removeAttribute( 'width' );
		imgs[i].removeAttribute( 'height' );
	}
	});
	</script>
	
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/excanvas.js"></script>
	
	<![endif]-->
	
	<!--[if lte IE 9]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	
	// Combine inline styles for body tag
	jQuery('body').each( function() {	
		var combined_styles = '<style type="text/css">';

		jQuery( this ).find( 'style' ).each( function() {
			combined_styles += jQuery(this).html();
			jQuery(this).remove();
		});

		combined_styles += '</style>';

		jQuery( this ).prepend( combined_styles );
	});
	});
	</script>
	
	<![endif]-->	
	
	<script type="text/javascript">
	/*@cc_on
		@if (@_jscript_version == 10)
			document.write('<style type="text/css">.fusion-body .fusion-header-shadow:after{z-index: 99 !important;}.fusion-body.side-header #side-header.header-shadow:after{ z-index: 0 !important; }.search input,.searchform input {padding-left:10px;} .avada-select-parent .select-arrow,.select-arrow{height:33px;<?php if($smof_data['form_bg_color']): ?>background-color:<?php echo $smof_data['form_bg_color']; ?>;<?php endif; ?>}.search input{padding-left:5px;}header .tagline{margin-top:3px;}.star-rating span:before {letter-spacing: 0;}.avada-select-parent .select-arrow,.gravity-select-parent .select-arrow,.wpcf7-select-parent .select-arrow,.select-arrow{background: #fff;}.star-rating{width: 5.2em;}.star-rating span:before {letter-spacing: 0.1em;}</style>');
		@end
	@*/

	var doc = document.documentElement;
	doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<style type="text/css">
	<?php
		ob_start();
		include_once get_template_directory() . '/includes/dynamic_css.php';
		$dynamic_css = ob_get_contents();
		ob_get_clean();
		echo fusion_compress_css( $dynamic_css );
	?>
	</style>
	
	<?php echo $smof_data['google_analytics']; ?>

	<?php echo $smof_data['space_head']; ?>
</head>
<?php
	$body_classes = array();

	$wrapper_class = '';

	$body_classes[] = 'fusion-body';

	$body_classes[] = 'mobile-menu-design-' . $smof_data['mobile_menu_design'];
?>
<body id="body-ciclo-amostras" <?php body_class( $body_classes ); ?> data-spy="scroll">
	<header id="header-ciclo-amostras" class="fusion-header-wrapper">
		<hgroup class="fusion-row">

			<figure>
			<?php
					
					$args = array (
						'post_type' => 'page',
						'posts_per_page' => 1,
						'fields' => 'ids',
						'nopaging' => true,
						'meta_key' => '_wp_page_template',
						'meta_value' => '../template-restrita.php'
					);
					
					$pages = get_posts( $args ); foreach ( $pages as $page ) { 

				?>
				<a href="<?php echo esc_url( get_permalink($page) ); ?>" class="fusion-logo" title="<?php wp_title( '' ); ?>">
					<img class="fusion-logo-1x fusion-standard-logo" width="" height="" alt="König Brasil" src="http://konigbrasil.com.br/wp-content/uploads/konig-brasil-saude-animal-logotipo.png">
					<img class="fusion-standard-logo fusion-logo-2x" width="" height="" alt="König Brasil" src="http://konigbrasil.com.br/wp-content/uploads/konig-brasil-saude-animal-logotipo.png">
				</a>
			<?php }; ?>
			</figure>
		
		</hgroup>
	</header>
	<div id="main" class="clearfix <?php echo $main_class; ?>" style="<?php echo $main_css; ?>">