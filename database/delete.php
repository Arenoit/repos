<?php
    require_once('conexion.php');
    if(isset($_POST['id'])&&is_numeric($_POST['id'])&&$_SESSION['type']==0){
        $id = $_POST['id'];
        $frag = "DELETE FROM acaprojc where projc_cod_projc='$id'";
        $con->query($frag);
        if(file_exists("../files/ISTVL-$id.pdf"))unlink("../files/ISTVL-$id.pdf");
    }
    echo'<script type="text/javascript">
    //header("location: ./steward/search.php");
    window.location.href="../steward/search";
    </script>';
    exit;
?>