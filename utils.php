<?php

function formatDateToShow($date){
    $dateToFormat = explode('-', $date);
    return date('d/m/Y', mktime(0, 0, 0, $dateToFormat[1], $dateToFormat[2], $dateToFormat[0]));
}



?>