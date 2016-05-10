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

load_plugin_textdomain( 'ciclo-amostras', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

// Activate and deactivate hooks
register_activation_hook( __FILE__, 'populate_db' );
register_deactivation_hook( __FILE__, 'depopulate_db' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Criação do(s) Post Type(s)
 */

require plugin_dir_path( __FILE__ ) . 'includes/cpt/cpt_clinica.php';
require plugin_dir_path( __FILE__ ) . 'includes/cpt/cpt_promotor.php';

/**
 * Personalição da(s) coluna(s)
 */

require plugin_dir_path( __FILE__ ) . 'admin/edit-column-promotor.php';

/**
 * Remover as Metabox não desejadas
 */

if ( is_admin() ) {

	function remove_meta_boxes() {
		remove_meta_box( 'mymetabox_revslider_0', array('clinica', 'promotor'), 'normal' );
		remove_meta_box( 'wpseo_meta', array('clinica', 'promotor'), 'normal' );
		remove_meta_box( 'pyre_post_options', array('clinica', 'promotor'), 'advanced' );
	}

	add_action( 'do_meta_boxes', 'remove_meta_boxes' );
	
}

/**
 * Register and Enqueue - Backend
 */

function add_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'clinica' === $post->post_type || 'promotor' === $post->post_type ) { 

        	wp_enqueue_script( 'ca-maskedinput-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.maskedinput.min.js', false, true );
			wp_enqueue_script( 'ca-main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), true );

        }
    }
}

// Register and Enqueue - Frontend
function add_frontend_scripts() {

	if ( is_singular('clinica') || is_singular('promotor') ) {
		wp_enqueue_script( 'ca-maskedinput-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.maskedinput.min.js', false, true );
		wp_enqueue_script( 'ca-main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), true );
	}

}

// Todos os Creditos para https://github.com/luizhguimaraes/acf-brazilian-city
function register_fields_brazilian_city() {
    include_once('includes/acf/acf-brazilian-city-field.php');
}

/**
 * Aplicação e verificação dos custom fields
 */

function acf_install_init() {
	if( class_exists( 'acf' ) ) {
 		// Custom Fields
 		include_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf-clinica.php';
 		include_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf-promotor.php';

 		// Registro e Permissão Promotor
 		include_once plugin_dir_path( __FILE__ ) . 'includes/role-register.php';
 		include_once plugin_dir_path( __FILE__ ) . 'includes/register-user.php';
 		
 		// Scripts
 		add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
 		add_action( 'wp_enqueue_scripts', 'add_frontend_scripts' );
 		add_action('acf/register_fields', 'register_fields_brazilian_city');

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

/**
 * Cria e verifica single/page personalizada
 */

function register_page_restricted_area() {
    require_once('templates/hook/create-page-restrita.php');
}
register_activation_hook( __FILE__, 'register_page_restricted_area' );

require_once('templates/class/class-page-templater.php');

require_once('includes/edit-page-template.php');

add_filter( 'template_include', 'include_template_single', 1 );
function include_template_single( $template_path ) {

    if ( get_post_type() == 'clinica' || get_post_type() == 'promotor' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-amostras.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/templates/single-amostras.php';
            }
        }
    } elseif ( is_page_template( 'template-restrita.php' )) {
    
        if ( $theme_file = locate_template( array ( 'template-restrita.php' ) ) ) {
            $template_path = $theme_file;
        } else {
            $template_path = plugin_dir_path( __FILE__ ) . '/templates/template-restrita.php';
        }
        
    }
    
    return $template_path;
}

/**
 * Populate o SQL com os Estados e Cidades
 */

function populate_db() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    ob_start();
    require_once "lib/install-data.php";
    $sql = ob_get_clean();
    dbDelta( $sql );
}

function depopulate_db() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    ob_start();
    require_once "lib/drop-tables.php";
    $sql = ob_get_clean();
    dbDelta( $sql );
}