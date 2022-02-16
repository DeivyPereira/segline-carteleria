<?php

function timestampToHuman($timestamp)
{
    $return = "Just Now";
    $minutes = floor($timestamp / 60);
    if ($minutes > 0) {
        $return = str_pad($minutes, 2, "0", STR_PAD_LEFT) . " Mins";
    }
    $hours = floor(($timestamp / 60) / 60);
    if ($hours > 0) {
        $return = str_pad($hours, 2, "0", STR_PAD_LEFT) . " Hrs";
    }
    # Obtenemos el numero de dias
    $days = floor((($timestamp / 60) / 60) / 24);
    if ($days > 0) {
        $return = $days . " Days ";
    }
    return $return;
}



