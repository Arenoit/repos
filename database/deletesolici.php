<?php
    session_start();
    require_once('conexion.php');
    if(isset($_POST['id'])&&is_numeric($_POST['id'])){
        if($_SESSION['type']==1){
            $id = $_POST['id'];
            $frag = "DELETE FROM acasolic WHERE solic_cod_users=$_SESSION[codusr] AND solic_cod_solic=$id";
            $con->query($frag);
            if(file_exists("../files/temp/stack-$id.pdf"))unlink("../files/temp/stack-$id.pdf");
        }
        if($_SESSION['type']==0){
            $id = $_POST['id'];
            $frag = "DELETE FROM acasolic WHERE solic_cod_solic=$id";
            $con->query($frag);
            if(file_exists("../files/temp/stack-$id.pdf"))unlink("../files/temp/stack-$id.pdf");
        }
    }
    echo'<script type="text/javascript">
    //header("location: ./user/solicitude?admit=edit.php");
    window.location.href="../user/solicitude?admit=edit";
    </script>';
    exit;
?>