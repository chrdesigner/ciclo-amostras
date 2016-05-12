<?php
/**
 * Clinica columns.
 */
function clinica_posts_edit_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __( 'Clínica', 'ciclo-amostras' ),
        'clinica_nome' => __( 'Nome do Veterinário', 'ciclo-amostras' ),
		'clinica_email' => __( 'E-mail', 'ciclo-amostras' ),
        'clinica_cidade' => __( 'Cidade/UF', 'ciclo-amostras' ),
        'clinica_telefone' => __( 'Contato', 'ciclo-amostras' ),
		'clinica_situacao' => __( 'Situação', 'ciclo-amostras' ),
    );
    return $columns;
}
add_filter( 'manage_edit-clinica_columns', 'clinica_posts_edit_columns' );


/**
 * Promotor custom columns content.
 */
function clinica_posts_columns( $column, $post_id ) {
    global $post;
    switch ( $column ) {
        case 'title':
        
            echo sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', admin_url( 'post.php?post=' . $post_id . '&action=edit' ), get_the_title(), get_the_title() );
            break;

        case 'clinica_nome':
            
            echo get_post_meta($post_id, 'nome_clinica', true);
            break;
        
        case 'clinica_email':
            
            $email_clinica = get_post_meta($post_id, 'email_clinica', true);
            echo sprintf( '<a href="mailto:%1$s" title="%1$s">%1$s</a>', $email_clinica );
            break;

        case 'clinica_cidade':

            $estado_cidade_clinica = get_post_meta($post_id, 'estado_cidade_clinica', true);
            $state_verification = $estado_cidade_clinica['state_name'];
            echo ! empty( $state_verification ) ? sprintf( '%1$s/%2$s', $estado_cidade_clinica['city_name'], $estado_cidade_clinica['state_id'] ) : 'Não Registrado';
            break;

        case 'clinica_telefone':

            $telefone_clinica = get_post_meta($post_id, 'telefone_clinica', true);
            $celular_clinica = get_post_meta($post_id, 'celular_clinica', true);
            $return_tel = ! empty( $telefone_clinica ) ? sprintf( '%1$s', $telefone_clinica ) : 'Não preenchido';
            $return_cel = ! empty( $celular_clinica ) ? sprintf( '%1$s', $celular_clinica ) : 'Não preenchido';
            echo '<ul><li class="dashicons-before dashicons-phone">' . $return_tel . '</li><li class="dashicons-before dashicons-smartphone">' . $return_cel . '</li></ul>';
            break;

        case 'clinica_situacao':

            $situacao = get_post_meta($post_id, 'situacao_do_cadastro', true);
			if($situacao == null){
				echo '<abbr id="ativa" class="dashicons-before dashicons-yes" title="Cliníca Ativa"></abbr>';
			}else{
				echo '<abbr id="inativa" class="dashicons-before dashicons-no" title="Cliníca Inativa"></abbr>';
			}

            break;


    }
}

add_action( 'manage_posts_custom_column', 'clinica_posts_columns', 1, 2 );