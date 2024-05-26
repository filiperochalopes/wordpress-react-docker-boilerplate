<?php

// Roles AND capabilities
function wporg_rh_role()
{
    add_role(
        'editor_rh',
        'Integrante RH',
        [
            'read' => true,
            'ascom_colaboradores' => true,
        ]
    );
}
// Adicionado depois de todas as outras para garantir que ascom_colaboradores está pronto
add_action('init', 'wporg_rh_role', 10);

?>