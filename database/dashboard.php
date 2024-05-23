<?php
session_start();
error_reporting(0);
$usuario=$_SESSION['boot'];
if(!isset($usuario)&&$usuario!='admin'){
    echo'<script type="text/javascript">
    window.location.href="../session/login";
    </script>';
    die();
    exit();
}
require_once('conexion.php');
$selectUsers="SELECT users_fec_users,users_usr_users,users_eml_users,users_sts_users FROM acausers GROUP BY users_cod_users DESC LIMIT 9";
$totalUsers=mysqli_query($con,$selectUsers);
$topPosts="SELECT users_img_users,users_usr_users,COUNT(solic_cod_users) contador FROM acausers LEFT JOIN acasolic ON users_cod_users=solic_cod_users WHERE solic_cod_solic!='' GROUP BY users_img_users,users_usr_users ORDER BY contador DESC LIMIT 7";
$totalPosts=mysqli_query($con,$topPosts);
?>