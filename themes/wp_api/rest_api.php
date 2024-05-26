<?php

// API WP
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/site_configs', array(
        'methods' => 'GET',
        'callback' => 'get_site_configs',
    ));
});

function get_site_configs($data)
{
    global $wpdb;

    $array_retorno = array(
        "site_url" => get_site_url()
    );

    return $array_retorno;
}
