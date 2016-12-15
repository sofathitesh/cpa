<?php

$hours = date('h');
$minutes = date('i');
$seconds = date('s');
$ampm = date('A');

$month = date("m");
$year = date("Y");
$day = date("d");

echo json_encode(array('hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds, 'year' => $year, 'day' => $day, 'month' => $month, 'ampm' => $ampm));

?>