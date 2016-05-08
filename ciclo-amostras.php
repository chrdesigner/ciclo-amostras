<?php
/**
 * Plugin Name:       Ciclo de Amostras
 * Plugin URI:        https://github.com/chrdesigner/ciclo-amostras/
 * Description:       Plugin desenvolvido para König
 * Version:           1.0.0
 * Author:            CHR Designer
 * Author URI:        http://www.chrdesigner.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ciclo-amostras
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Criação do(s) Post Type(s)
 */

require plugin_dir_path( __FILE__ ) . 'includes/cpt/cpt_clinica.php';


/**
 * Register and Enqueue - Backend
 */

function add_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'clinica' === $post->post_type ) { 

        	wp_enqueue_script( 'ca-maskedinput-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.maskedinput.min.js', false, true );
			wp_enqueue_script( 'ca-main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), true );

			// wp_register_style( 'jquery-ui-styles','//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css' );
			// wp_enqueue_style( 'jquery-ui-styles' );

			// wp_enqueue_script( 'field-date-js', plugin_dir_url( __FILE__ ) . 'assets/js/field_date.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), true );
			// wp_enqueue_style( 'jquery-ui-datepicker' );

        }
    }
}


// Register and Enqueue - Frontend
function add_frontend_scripts() {

	if ( is_singular('clinica') ) {
		wp_enqueue_script( 'ca-maskedinput-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.maskedinput.min.js', false, true );
		wp_enqueue_script( 'ca-main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), true );
	}

}


/**
 * Aplicação e verificação dos custom fields
 */

function acf_install_init() {
	if( class_exists( 'acf' ) ) {
 		
 		include_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf-clinica.php';
 		
 		add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
 		add_action( 'wp_enqueue_scripts', 'add_frontend_scripts' );

	}else{
		add_action( 'admin_notices', 'admin_notice_acf_activation');
	}
}
add_action( 'plugins_loaded', 'acf_install_init' );

/**
 * Alerta de Plugin não ativo
 */

function admin_notice_acf_activation() {
    echo '<div class="error"><p>' . __('O Ciclo de Amostras precisa do <b>Advanced Custom Fields</b> instalado e ativo.' , 'ciclo-amostras' ) . '</p></div>';
}


add_filter( 'template_include', 'include_template_showcase', 1 );
function include_template_showcase( $template_path ) {
    if ( get_post_type() == 'clinica' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-clinica.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/themes/single-clinica.php';
            }
        }
    }
    return $template_path;
}