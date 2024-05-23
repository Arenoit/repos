<?php
session_start();
require_once('../database/conexion.php');
mysqli_query($con,"UPDATE acausers SET users_sts_users=0 WHERE users_usr_users='".$_SESSION['boot']."'");//status
$_SESSION['Choose']=(!empty($_SESSION['Choose']))?array_diff($_SESSION['Choose'],array($_SESSION['boot'])):null;
unset($_SESSION['boot']);
echo '<script type="text/javascript">
    window.location.href="./meeting";
    </script>';
die();
exit();
?>