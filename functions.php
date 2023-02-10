<?php

function formata_dinheiro($valor) {
    $valor = number_format($valor, 2, ',', '');
    return "R$ " . $valor;
}

function mostraMes($m) {
    switch ($m) {
        case 01: $mes = "| Janeiro |";
            break;
        case 02: $mes = "Fevereiro |";
            break;
        case 03: $mes = "Marco |";
            break;
        case 04: $mes = "Abril |";
            break;
        case 05: $mes = "Maio |";
            break;
        case 06: $mes = "Junho |";
            break;
        case 07: $mes = "Julho |";
            break;
        case 8: $mes = "Agosto |";
            break;
        case 9: $mes = "Setembro |";
            break;
        case 10: $mes = "Outubro |";
            break;
        case 11: $mes = "Novembro |";
            break;
        case 12: $mes = "Dezembro |";
            break;
    }
    return $mes;
}

?>
