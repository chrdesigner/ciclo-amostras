<?php
    
    // Para de enviar email de alteração de senha
    add_filter('send_password_change_email', '__return_false');

    // Notificação do Promotor
    
    function wp_new_user_notification_new( $user_id, $plaintext_pass = '' ) {
     
        // set content type to html
        add_filter( 'wp_mail_content_type', 'wpmail_content_type' );
 
        // user
        $user = new WP_User( $user_id );
        $userEmail = stripslashes( $user->user_email );
        $siteUrl = home_url( '/area-restrita/' );
        $logoUrl = plugin_dir_url(dirname(__FILE__)) . 'assets/images/konig-brasil-logotipo.png';
 
        $subject = 'König Brasil / Agenda de Visitas';
        $headers = 'From: König Brasil <0800@konigbrasil.com.br>';
 
        // admin email
        $message  = "Um novo promotor foi criado"."\r\n\r\n";
        $message .= 'E-mail: '.$userEmail."\r\n";
        
        @wp_mail( get_option( 'admin_email' ), 'Novo Promotor Registrado', $message, $headers );
 
        ob_start();
        include plugin_dir_path( __FILE__ ).'/email_welcome.php';
        $message = ob_get_contents();
        ob_end_clean();
 
        @wp_mail( $userEmail, $subject, $message, $headers );
 
        // remove html content type
        remove_filter ( 'wp_mail_content_type', 'wpmail_content_type' );
    }
     
    /**
     * wpmail_content_type
     * allow html emails
     */
    function wpmail_content_type() {
        return 'text/html';
    }