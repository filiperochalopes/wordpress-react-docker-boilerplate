<?php

/* ----------
	Adicionando custom_post_type VEM AÍ
	register_post_type( string $post_type, array|string $args = array() )
---------- */

// Faltando implementar galeria

add_action( 'init', 'register_cpt_vem_ai' );

function register_cpt_vem_ai(){
    register_post_type('banners',
        array(
            'labels' => array(
                'name'          =>  'Banners Principais',
                'singular_name' =>  'Banner',
                'menu_name'     =>  'Banners',
                'all_items'     =>  'Todos',
                'add_new'       =>  'Adicionar novo',
                'add_new_item'  =>  'Adicionar novo Banner'
                ),
            'menu_position' => 4,
            'public'    => true,
            'supports'  => array(
                            'title',
                            'editor',
                            'thumbnail',
                            'post-formats',
                            'custom-fields'
                            ),
            'show_in_admin_bar' =>  true,
            'taxonomies' => array('post_tag'),
            'menu_icon' => 'dashicons-slides',
            'show_in_rest' => true,
            'register_meta_box_cb' => 'Banners_meta_box'
        )
    );
}

/* ---------
    Opções:
    add_meta_box( 
        string $id, 
        string $title, 
        callable $callback, 
        string|array|WP_Screen $screen = null, 
        string $context = 'advanced', 
        string $priority = 'default', 
        array $callback_args = null 
    )
---------- */

function banners_meta_box() {
    add_meta_box(
        '_action_bt',
        __( 'Botão de ação', 'action_bt' ),
        'action_bt_cb',
        'banners',
        'advanced',
        'high'
    );
}

function action_bt_cb( $post ) {
    $action_bt_obj = json_decode(get_post_meta( $post->ID, '_action_bt', true ));
    $bt_content = $action_bt_obj->content;
    $bt_link = $action_bt_obj->link;

    echo '
    <label for="bt_content">Escreva o conteúdo do botão</label>
    <input type="text" style="width:100%" id="bt_content" name="bt_content" value="' . esc_attr( $bt_content ) . '"/>
    <label for="bt_content">Escreva o link para o qual ele será redirecionado</label>
    <input type="text" style="width:100%" id="bt_link" name="bt_link" value="' . esc_attr( $bt_link ) . '"/>
    ';
}

function save_action_bt( $post_id ) {

    /* ----------
    beautiful code from https://www.sitepoint.com/adding-meta-boxes-post-types-wordpress/
    ---------- */

    // Sanitize user input.
    // $my_data = sanitize_text_field( $_POST['data_hora'] );

    $my_data = array(
        "content" => sanitize_text_field( $_POST['bt_content'] ),
        "link" => sanitize_text_field( $_POST['bt_link'] )
    );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_action_bt', json_encode($my_data) );
}

add_action( 'save_post', 'save_action_bt' );

/* ----------
Registro para metavalues funcionarem com WP API
---------- */

add_action( 'init', 'register_posts_banners_meta_field' );

function register_posts_banners_meta_field() {

    register_meta( 'post', '_action_bt', array(
        'object_subtype' => 'banners',
        'type'           => 'string',
        'description'    => 'A meta key associated with a string meta value.',
        'single'         => true,
        'show_in_rest'   => true,
    ));
}


?>