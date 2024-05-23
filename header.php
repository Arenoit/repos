<?php 
session_start();
error_reporting(0);
$usuario=$_SESSION['boot'];
if(isset($usuario)){
    echo'<script type="text/javascript">
    window.location.href="./steward/.";
    </script>';
    die();
    exit();
}else{
    session_abort();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Style Navbar-->
  <script src="./js/formain.js" defer></script>
  <link rel="stylesheet" href="./css/formain.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
  <title>Repositorio</title>
</head>
<body>
    <nav class="nav">
        <i class="uil uil-bars navOpenBtn"></i>
        <img src="./images/logo-istvl-big.png" alt="" style="width:120px">
        <a href="." class="logo">Repositorio</a>
        <ul class="nav-links">
            <i class="uil uil-times navCloseBtn"></i>
            <li><a href=".">Inicio</a></li>
            <li><a href="./search">Biblioteca</a></li>
            <li><a href="./session/login">Log in</a></li>
            <li>&nbsp;&nbsp;</li>
        </ul>
        <i class="uil uil-search search-icon" id="searchIcon"></i>
        <div class="search-box">
            <i class="uil uil-search search-icon"></i>
            <form action="./search" method="GET" id="usrmform"></form>
            <input input autocomplete="off" type="text" id="seeker" name="seeker" placeholder="Search here..." form="usrmform"/>
        </div>
    </nav>
<?php
}
?>