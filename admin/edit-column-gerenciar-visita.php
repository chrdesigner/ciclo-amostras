<?php
/**
 * Gerenciar Visita columns.
 */
function gerenciar_visita_posts_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Nome da Clínica', 'ciclo-amostras' ),
        'visita_promotor' => __( 'Promotor', 'ciclo-amostras' ),
        'visita_cidade' => __( 'Cidade/UF', 'ciclo-amostras' ),
        'visita_entrega' => __( 'Entrega da amostra', 'ciclo-amostras' ),
        'visita_proximo' => __( 'Proxima entrega', 'ciclo-amostras' ),
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
            
            $posts = get_field('todas_clinicas', $post_id);
            if( $posts ) :
                foreach( $posts as $p ) :
                    $getID = $p->post_author;
                    $author_name = get_the_author_meta( 'display_name', $getID );                    
                    echo sprintf( '<a href="%1$s" title="Gerenciar Visita(s) - %2$s">%2$s</a>', admin_url( 'edit.php?post_type=gerenciar_visita&author=' . $getID ), $author_name );
                endforeach;
            endif;
            break;

        case 'visita_cidade':

            $posts = get_field('todas_clinicas', $post_id);
            if( $posts ) :
                foreach( $posts as $p ) :

                    $cidade_uf = get_field('estado_cidade_clinica', $p->ID);

                    if($cidade_uf != null){
                        echo $cidade_uf['city_name'] . '/' . $cidade_uf['state_id'] ;
                    };

                endforeach;
            endif;
            break;

        case 'visita_entrega':

            $programada_rows = get_field('relatorio_do_promotor', $post_id);
            if($programada_rows) {
                foreach($programada_rows as $programada) {
                    $data_programada = $programada['data_entrega_amostra'];
                    $data_programada = new DateTime($data_programada);

                    echo $data_programada->format('d/m');
                }
            }
            break;

        case 'visita_proximo':

            $proxima_entrega = get_field('proxima_entrega', $post_id);
            if($proxima_entrega != null){
                $proxima_entrega = new DateTime($proxima_entrega);
                echo $proxima_entrega->format('d/m');
            }
            break;

        case 'visita_historico':

            echo sprintf( '<a href="%1$s" title="Histórico" target="_blank">Ver</a>', get_the_permalink($post_id) );
            break;

    }
}
add_action( 'manage_posts_custom_column', 'gerenciar_visita_posts_columns', 1, 2 );