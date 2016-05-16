<?php
/**
 * Gerenciar Visita columns.
 */
function gerenciar_visita_posts_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Noma da Clinica', 'ciclo-amostras' ),
        'visita_promotor' => __( 'Promotor', 'ciclo-amostras' ),
        'visita_cidade' => __( 'Cidade/UF', 'ciclo-amostras' ),
        'visita_entrega' => __( 'Entrega da amostra', 'ciclo-amostras' ),
        'visita_proximo' => __( 'Proxíma entrega', 'ciclo-amostras' ),
        'visita_historico' => __( 'Histórico', 'ciclo-amostras' ),
        
    );
    return $columns;
}
add_filter( 'manage_edit-gerenciar_visita_columns', 'gerenciar_visita_posts_edit_columns' );

/**
 * Gerenciar Visita custom columns content.
 */
function gerenciar_visita_posts_columns( $column, $post_id ) {
    global $post;
    switch ( $column ) {
        case 'title':
        
            echo sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', admin_url( 'post.php?post=' . $post_id . '&action=edit' ), get_the_title(), get_the_title() );
            break;
        
        case 'visita_promotor':
            
            echo "Promotor";            
            
            break;

        case 'visita_cidade':

            echo "CIDADE/UF";

            break;

        case 'visita_entrega':

            echo "Entrega";

            break;

        case 'visita_proximo':

            echo "Proximo";
            
            break;

        case 'visita_historico':

            echo 'Histórico';

            break;

    }
}
add_action( 'manage_posts_custom_column', 'gerenciar_visita_posts_columns', 1, 2 );