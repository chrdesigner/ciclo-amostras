<?php

//Alterar o logo tela de login
function chr_style_personalizado() { ?>
	<style>
		body.login div#login h1 a {
			background-image: url('<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/images/konig-brasil-logotipo.png');
			background-size: 100% auto;
		    width: 300px;
		    height: 70px;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'chr_style_personalizado' );

//URL do logo da tela de login
function chr_logo_url() {
    return get_bloginfo( 'url' );

}
add_filter( 'login_headerurl', 'chr_logo_url' );
 
//Title do logo da tela de login
function chr_logo_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'chr_logo_title' );