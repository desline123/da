<?php
$con = mysqli_connect('MySQL-5.7', 'root', '', 'service_quality');
if(!$con) die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
mysqli_set_charset($con, 'utf8');
?>