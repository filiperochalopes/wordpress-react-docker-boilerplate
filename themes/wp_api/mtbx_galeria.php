<?php

/* ----------
	Criação de metabox para criar galeria na API da página ou post em questão
---------- */

add_action( 'add_meta_boxes', 'add_meta_box_galeria' );

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

function add_meta_box_galeria() {
    add_meta_box(
        '_ft_gall',
        __( 'Galeria de rodapé', 'ft_gall' ),
        'ft_gall_mtbx_cb',
        array( 'page', 'post', 'vem-ai', 'ver-de-dentro', 'altos-papos', 'destaque-do-mes' ),
        'advanced'
    );   
}

function ft_gall_mtbx_cb( $post ) {
    $value = get_post_meta( $post->ID, '_ft_gall', true );    

    global $wpdb;
    
    ?>

    <section id="ft_gall_mtbx">

    <?php

    $all_images = $wpdb->get_results("SELECT ID, post_name, `guid`, post_type, post_mime_type FROM wp_posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image%' ORDER BY ID DESC");
    foreach($all_images as $image){
        echo "<input type=\"checkbox\" id=\"ft_gall_{$image->ID}\" class=\"checkbox_ft_gall\" value=\"{$image->ID}\">";
        echo "<label class=\"mtbx_ft_gall_img\" for=\"ft_gall_{$image->ID}\"><div style=\"background-image: url('{$image->guid}')\"></div></label>";
    }

    ?>

    <textarea name="ft_gall" id="ft_gall"><?=esc_attr( $value )?></textarea>

    <script>
        jQuery('document').ready( function($){
            // Coleta e atualiza boxes com check
            imgs = $("#ft_gall").text() == '' ? [] : JSON.parse($("#ft_gall").text())
            console.log(imgs)
            imgs.forEach( e => {
                $(`#ft_gall_mtbx input[value=${e}]`).attr("checked", true);
            })


            // Evento que dispara com mudança de status de um checkbox
            $("#ft_gall_mtbx").on("change", ".checkbox_ft_gall", function () {
                id = parseInt($(this).val());
                textarea = $("#ft_gall");
                json = textarea.text() == '' ? [] : JSON.parse(textarea.text());
                
                // Adiciona no campo
                if (this.checked) {
                    json.push(id);
                } else {
                    json.forEach(function (v, i) {
                        if (id == v) {
                            json.splice(i, 1);
                        }
                    })
                }
                textarea.text(JSON.stringify(json));
                console.log(json);
            })
        })
    </script>

    </section>

    <?php
}

function save_mtbx_ft_gall( $post_id ) {

    /* ----------
    beautiful code from https://www.sitepoint.com/adding-meta-boxes-post-types-wordpress/
    ---------- */

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['ft_gall'] );

    $ft_gall_imgs = array();
    if($my_data != ""){
        $imgs_ids = json_decode($my_data);
        foreach($imgs_ids as $id){
            array_push($ft_gall_imgs, wp_get_attachment_image_src($id, "full")[0]);
        }
        // Update the meta field in the database.
        update_post_meta( $post_id, '_ft_gall_imgs', json_encode($ft_gall_imgs) );
    }
    update_post_meta( $post_id, '_ft_gall', $my_data );
}

add_action( 'save_post', 'save_mtbx_ft_gall' );


/* ----------
Registro para metavalues funcionarem com WP API
---------- */

add_action( 'init', 'register_mtbx_galeria' );

function register_mtbx_galeria() {

    register_meta( 'post', '_ft_gall', array(
        'type'           => 'string',
        'description'    => 'A meta key associated with a string meta value.',
        'single'         => true,
        'show_in_rest'   => true,
    ));

    register_meta( 'post', '_ft_gall_imgs', array(
        'type'           => 'string',
        'description'    => 'A meta key associated with a string meta value.',
        'single'         => true,
        'show_in_rest'   => true,
    ));

}


?>