<?php
    /**
     * redefine new user notification function
     *
     * emails new users their login info
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   integer $user_id user id
     * @param   string $plaintext_pass optional password
     */
    if ( !function_exists( 'wp_new_user_notification' ) ) {
        function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
     
            // set content type to html
            add_filter( 'wp_mail_content_type', 'wpmail_content_type' );
     
            // user
            $user = new WP_User( $user_id );
            $userEmail = stripslashes( $user->user_email );
            $siteUrl = home_url( '/area-restrita/' );
            $logoUrl = plugin_dir_url(dirname(__FILE__)) . 'assets/images/konig-brasil-logotipo.png';
     
            $subject = 'König Brasil / Agenda de visitas';
            $headers = 'From: König Brasil <chrdesigner@chrdesigner.com>';
     
            // admin email
            $message  = "A new user has been created"."\r\n\r\n";
            $message .= 'Email: '.$userEmail."\r\n";
            
            @wp_mail( get_option( 'admin_email' ), 'New User Created', $message, $headers );
     
            ob_start();
            include plugin_dir_path( __FILE__ ).'/email_welcome.php';
            $message = ob_get_contents();
            ob_end_clean();
     
            @wp_mail( $userEmail, $subject, $message, $headers );
     
            // remove html content type
            remove_filter ( 'wp_mail_content_type', 'wpmail_content_type' );
        }
    }
     
    /**
     * wpmail_content_type
     * allow html emails
     *
     * @author Joe Sexton <joe@webtipblog.com>
     * @return string
     */
    function wpmail_content_type() {
     
        return 'text/html';
    }