<?php

function formatDateToShow($date){
    $date = substr($date, 0, 10);
    $dateToFormat = explode('-', $date);
    return date('d/m/Y', mktime(0, 0, 0, $dateToFormat[1], $dateToFormat[2], $dateToFormat[0]));
}

function formatLogsDateToShow($date){
    $dateFormatted = formatDateToShow(substr($date, 0, 10));
    $dateFormatted .= substr($date, 10, strlen($date));
    return $dateFormatted;
}

function isAdmin($user){
    return $user->getRoleId() == 1;
}


?>