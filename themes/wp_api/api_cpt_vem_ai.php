<?php

// API WP
add_action('rest_api_init', function () {
    register_rest_route('cpt/v1', '/vem-ai/widget/(?P<ano>\d+)/(?P<mes>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_widget_vem_ai',
    ));
});

function get_widget_vem_ai($data)
{
    global $wpdb;

    // $array_retorno = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tela_inicial WHERE b_show = 1 ORDER BY `order` ASC");

    $meses = [
        "", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
    ];

    $meses_abr = [
        "", "Jan", "Fev", "Mar", "Abr", "Maio", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"
    ];

    $dias_sem = [
        "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"
    ];

    $week_count = 1;

    $mes = str_pad($data["mes"], 2, "0", STR_PAD_LEFT);;
    $ano = $data["ano"];
    $primeiro_dia = "{$ano}-{$mes}-01";
    $ultimo_dia = date("Y-m-t", strtotime($primeiro_dia));
    $d = $primeiro_dia;

    $calendario = array( array() );

    $w = 0;

    while ($d <= $ultimo_dia && $d >= $primeiro_dia ) {

        // Verifica que dia da semana é, se trocar de semana cria novo array
        // Caso seja o primeiro dia e
        $day_of_week = date("w", strtotime($d));
        if($day_of_week == "0" && date("d", strtotime($d) != "01")){
            $w++;
            array_push($calendario, array());
        }
        
        // Caso seja a primeira semana e não comece do domingo, adicionar objetos em branco à esquerda
        if(date("d", strtotime($d)) == "01" && $day_of_week != "0"){
            for ($i=0; $i < intval($day_of_week); $i++) { 
                array_push($calendario[$w], null);
            }
        }

        // Pesquisa se existe evento essa data
        $eventos = array();
        $pesquisa_data_vem_ai = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_data_hora' AND meta_value LIKE '{$d}%' ORDER BY meta_value ASC ");
        if($pesquisa_data_vem_ai){
            foreach( $pesquisa_data_vem_ai as $meta ){
                $evento = $wpdb->get_row("SELECT post_content, post_title, post_name FROM {$wpdb->prefix}posts WHERE ID = {$meta->post_id}");
                $evento->horario = date("H:m", strtotime($meta->meta_value));
                $evento->trecho = substr( $evento->post_content , 0 , 100 )." ...";
                $evento->data_extenso = $dias_sem[date("w", strtotime($d))].", ".date("d", strtotime($d))." de ".$meses_abr[intval(date("m", strtotime($d)))];
                array_push($eventos, $evento);
            }
        }
        
        array_push($calendario[$w], array(
            "dia" => date("j", strtotime($d)),
            "dia_semana" => date("w", strtotime($d)),
            "eventos" => $eventos
        ));

        // Caso seja a ultima semana e não termine no domingo, adicionar objetos em branco à direita
        if(date("d", strtotime($d)) == date("t", strtotime($d)) && $day_of_week != "6"){
            for ($i=0; $i < 6 - intval($day_of_week); $i++) { 
                array_push($calendario[$w], null);
            }
        }

        $d = date("Y-m-d", strtotime($d . " + 1 day"));

    }


    $array_retorno = array(
        "ano" => $ano,
        "mes" => $mes,
        "intervalo" => "{$primeiro_dia} - {$ultimo_dia}",
        "mes_nome" => $meses[$data["mes"]],
        "calendario_mes" => $calendario,
        "teste" => date("d", strtotime($d)) == "01" && $day_of_week != "0"   
    );

    return $array_retorno;
}
