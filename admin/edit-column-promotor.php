<?php
/**
 * Promotor columns.
 */
function promotor_posts_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Nome', 'ciclo-amostras' ),
        'promotor_email' => __( 'E-mail', 'ciclo-amostras' ),
        'promotor_cidade' => __( 'Cidade/UF', 'ciclo-amostras' ),
        'promotor_telefone' => __( 'Telefone', 'ciclo-amostras' ),
        'promotor_clinicas' => __( 'Clinicas/Veterinários', 'ciclo-amostras' ),
        'promotor_proximo' => __( 'Proxímo ciclo visita', 'ciclo-amostras' ),
        'author' => __( 'Listar promotor', 'ciclo-amostras' ),
    );
    return $columns;
}
add_filter( 'manage_edit-promotor_columns', 'promotor_posts_edit_columns' );

/**
 * Promotor custom columns content.
 */
function promotor_posts_columns( $column, $post_id ) {
    global $post;
    switch ( $column ) {
        case 'title':
        
            echo sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', admin_url( 'post.php?post=' . $post_id . '&action=edit' ), get_the_title(), get_the_title() );
            break;
        
        case 'promotor_email':
            
            $email_promotor = get_post_meta($post_id, 'email_promotor', true);
            echo sprintf( '<a href="mailto:%1$s" title="%1$s">%1$s</a>', $email_promotor );

            break;
        case 'promotor_cidade':

            $estado_cidade_promotor = get_post_meta($post_id, 'estado_cidade_promotor', true);
            $state_verification = $estado_cidade_promotor['state_name'];
            echo ! empty( $state_verification ) ? sprintf( '%1$s/%2$s', $estado_cidade_promotor['city_name'], $estado_cidade_promotor['state_id'] ) : 'Não Registrado';

            break;

        case 'promotor_telefone':

            $telefone_promotor = get_post_meta($post_id, 'telefone_promotor', true);
            $celular_promotor = get_post_meta($post_id, 'celular_promotor', true);

            $return_tel = ! empty( $telefone_promotor ) ? sprintf( '%1$s', $telefone_promotor ) : 'Não preenchido';
            $return_cel = ! empty( $celular_promotor ) ? sprintf( '%1$s', $celular_promotor ) : 'Não preenchido';

            echo '<ul><li class="dashicons-before dashicons-phone">' . $return_tel . '</li><li class="dashicons-before dashicons-smartphone">' . $return_cel . '</li></ul>';

            break;

        case 'promotor_clinicas':

            echo '...';

            break;

        case 'promotor_proximo':

            echo '...';

            break;

    }
}

add_action( 'manage_posts_custom_column', 'promotor_posts_columns', 1, 2 );

// add_filter( 'wpseo_use_page_analysis', '__return_false' );