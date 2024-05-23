<?php

$con = mysqli_connect("localhost", "id21788468_if0_34663650", "2021471Jg*", "id21788468_bdacademy");

$accents = mysqli_query($con,"SET NAMES 'utf8'");


if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}
?>