<?php
session_start();
require_once('conexion.php');
$id=!empty($_REQUEST['id'])?$_REQUEST['id']:"";
$solicitude="";
if(!empty($_SESSION['codusr'])){
    if(empty($id)) {
        $solicitude=mysqli_query($con,"SELECT solic_cod_solic,solic_prj_solic,solic_ubi_solic,solic_mot_solic,solic_rev_solic FROM acasolic WHERE solic_cod_users=$_SESSION[codusr]");
    }else{
        $solicitude=mysqli_query($con,"SELECT solic_cod_solic,solic_prj_solic,solic_ubi_solic,solic_mot_solic,solic_fil_solic FROM acasolic WHERE solic_cod_users=$_SESSION[codusr] AND solic_cod_solic=$id");
    }
}
?>