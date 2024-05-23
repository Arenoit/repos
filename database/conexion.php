<?php

$con = mysqli_connect("localhost", "root", "", "bdacademy");

$accents = $con->query("SET NAMES 'utf8'");


if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}
?>