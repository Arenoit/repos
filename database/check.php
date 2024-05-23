<?php
session_start();
require_once('conexion.php');
if($_SESSION['type']==0){
    $solicitude=mysqli_query($con,"UPDATE acasolic SET solic_rev_solic='$_POST[rev]' WHERE acasolic.solic_cod_solic='$_POST[id]'");
    echo $rev=($_POST['rev']==0)?"SIN REVISAR":"REVISADO";
    /* echo"<script type='text/javascript'>
    //header('location: ./steward/solicitude.php');
    window.location.href='../steward/solicitude?id=$_GET[id]';
    </script>"; */
}
?>