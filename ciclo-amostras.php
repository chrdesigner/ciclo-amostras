<?php
/**
 * Plugin Name:       Ciclo de Amostras
 * Plugin URI:        https://github.com/chrdesigner/ciclo-amostras/
 * Description:       Plugin desenvolvido para König
 * Version:           1.0.1
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
require plugin_dir_path( __FILE__ ) . 'includes/cpt/cpt_gerenciar_visita.php';

/**
 * Personalição da(s) coluna(s)
 */

require plugin_dir_path( __FILE__ ) . 'admin/edit-column-promotor.php';
require plugin_dir_path( __FILE__ ) . 'admin/edit-column-clinica.php';
require plugin_dir_path( __FILE__ ) . 'admin/edit-column-gerenciar-visita.php';

/**
 * Registrar styles e scripts padrões do plugin
 */

wp_register_style( 'style-admin', plugin_dir_url( __FILE__ ) . 'admin/assets/css/style-admin.css' );
wp_register_script('ca-maskedinput-js', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.maskedinput.min.js', false, true );
wp_register_script( 'data-visita-js', plugin_dir_url( __FILE__ ) . 'assets/js/data.visita.js', array('jquery'), false );
wp_register_script( 'disable-field-js', plugin_dir_url( __FILE__ ) . 'assets/js/disable.field.js', array('jquery'), false );
wp_register_style( 'style-restrita', plugin_dir_url( __FILE__ ) . 'templates/assets/css/style-restrita.css' );
wp_register_script( 'script-restrita-js', plugin_dir_url( __FILE__ ) . 'templates/assets/js/script-restrita.js', array('jquery'), true );


/**
 * Remover as Metabox não desejadas
 */

if ( is_admin() ) {

	function remove_meta_boxes() {
		remove_meta_box( 'mymetabox_revslider_0', array('clinica', 'promotor', 'gerenciar_visita'), 'normal' );
		remove_meta_box( 'wpseo_meta', array('clinica', 'promotor', 'gerenciar_visita'), 'normal' );
		remove_meta_box( 'pyre_post_options', array('clinica', 'promotor', 'gerenciar_visita'), 'advanced' );
	}
	add_action( 'do_meta_boxes', 'remove_meta_boxes' );
	
}

/**
 * Register and Enqueue - Backend
 */

function add_admin_scripts( $hook ) {

    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {

        if ( 'clinica' == $post->post_type || 'promotor' == $post->post_type ) { 

            wp_enqueue_style( 'style-admin' );
            wp_enqueue_script('ca-maskedinput-js');
        	wp_enqueue_script( 'ca-main-admin-js', plugin_dir_url( __FILE__ ) . 'admin/assets/js/main-admin.js', array('jquery'), true );

            if( 'promotor' == $post->post_type && 'publish' == $post->post_status ){
                wp_enqueue_script('disable-field-js');
            }

        } elseif ( 'gerenciar_visita' == $post->post_type ) {
            
            wp_enqueue_style( 'style-admin' );
            wp_enqueue_script('data-visita-js');

        }
    }
}

/*
 * Register and Enqueue - Frontend
 */

function add_frontend_scripts() {

    global $post;

	if ( is_singular('clinica') || is_singular('promotor') ) {

		wp_enqueue_script('ca-maskedinput-js');
        wp_enqueue_script( 'ca-main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array('jquery'), true );

    } elseif ( is_singular('gerenciar_visita') ) {

        wp_enqueue_script('data-visita-js');

    }

    if( is_singular('promotor') && 'publish' == $post->post_status || is_singular('gerenciar_visita') && 'publish' == $post->post_status){
        wp_enqueue_script('disable-field-js');
    }

}

/*
 * Adicionar estilo nas colunas dos post's
 */

function amostras_admin_css() {
    
    global $post_type;
    
    if ( ($_GET['post_type'] == 'promotor') || ($post_type == 'promotor') || ($_GET['post_type'] == 'clinica') || ($post_type == 'clinica') || ($_GET['post_type'] == 'gerenciar_visita') || ($post_type == 'gerenciar_visita') ) :
    
        wp_enqueue_style( 'style-admin' );

    endif;

}

/**
 * Todos os Creditos para https://github.com/luizhguimaraes/acf-brazilian-city
 */

function register_fields_brazilian_city() {
    include_once('includes/acf/acf-brazilian-city-field.php');
}

/**
 * Suporte para a versão 4.5 do WP para o plugin
 */

function load_old_jquery_fix() {
    if ( ! is_admin() ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', ( "//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" ), false, '1.11.3' );
        wp_enqueue_script( 'jquery' );
    }
}

/**
 * Aplicação e verificação dos custom fields
 */

function acf_install_init() {
	if( class_exists( 'acf' ) && function_exists('acf_register_repeater_field') ) {
 		
        // Custom Fields
 		include_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf-clinica.php';
 		include_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf-promotor.php';
        include_once plugin_dir_path( __FILE__ ) . 'includes/acf/acf-gerenciar-visita.php';

 		// Registro e Permissão Promotor
 		include_once plugin_dir_path( __FILE__ ) . 'includes/role-register.php';
 		include_once plugin_dir_path( __FILE__ ) . 'includes/register-user.php';
        include_once plugin_dir_path( __FILE__ ) . 'email/user-emails.php';

        include_once plugin_dir_path( __FILE__ ) . 'includes/register-clinica.php';
        include_once plugin_dir_path( __FILE__ ) . 'includes/register-visita.php';

        // Ajax Login
        include_once plugin_dir_path( __FILE__ ) . 'templates/login/ajax_login.php';

        // Personaliza a tela do WP-Admin
        include_once plugin_dir_path( __FILE__ ) . 'includes/custom-login.php';
 		
        // Styles
        add_action('admin_head', 'amostras_admin_css');

 		// Scripts
 		add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
 		add_action( 'wp_enqueue_scripts', 'add_frontend_scripts' );
 		add_action('acf/register_fields', 'register_fields_brazilian_city');
        
        // Load jQuery Old Version
        // After upgrading to WordPress 4.5, an error like the above one could appear in many themes, especially in ThemeForest themes.
        add_action( 'wp_enqueue_scripts', 'load_old_jquery_fix', 100 );

	}else{
		
		add_action( 'admin_notices', 'admin_notice_acf_activation');

	}
}
add_action( 'plugins_loaded', 'acf_install_init' );

/**
 * Alerta de Plugin não ativo
 */

function admin_notice_acf_activation() {
    echo '<div class="error"><p>' . __('O Ciclo de Amostras precisa do(s) plugin(s) <b>Advanced Custom Fields</b> e <b>Advanced Custom Fields: Repeater Field</b> instalado(s) e ativo(s).' , 'ciclo-amostras' ) . '</p></div>';
}

/**
 * Criação do Frontend - Listagem/Gerenciamento/Relatórios
 */

function register_page_restricted_area() {
    require_once('templates/hook/create-page-restrita.php');
}
register_activation_hook( __FILE__, 'register_page_restricted_area' );

require_once('templates/class/class-page-templater.php');

require_once('includes/edit-page-template.php');

require_once('templates/hook/ajax-relatorio-clinica.php');

add_filter( 'template_include', 'include_template_single', 1 );
function include_template_single( $template_path ) {

    if ( get_post_type() == 'clinica' || get_post_type() == 'promotor' || get_post_type() == 'gerenciar_visita' ) {
        if ( is_single() ) {

            wp_enqueue_style( 'style-restrita' );
            
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