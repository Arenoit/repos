<?php
session_start();
//error_reporting(0);
$usuario=$_SESSION['boot'];
if(!isset($usuario)&&$usuario!='admin'){
    echo'<script type="text/javascript">
    window.location.href="../session/login";
    </script>';
    die();
    exit();
}
require_once('conexion.php');
$updateCareers=mysqli_query($con,"SELECT carer_nom_carer FROM acacarer");
$material = isset($_POST['material'])?str_replace("'",'',trim($_POST['material'])):'';
$titulo = isset($_POST['titulo'])?str_replace("'",'',trim($_POST['titulo'])):'';
$autor = isset($_POST['autor'])?str_replace("'",'',trim($_POST['autor'])):'';
$tutor = isset($_POST['tutor'])?str_replace("'",'',trim($_POST['tutor'])):'';
$colpalabras = isset($_POST['colpalabras'])?$_POST['colpalabras']:[''];
$fecha = !empty($_POST['fecha'])?str_replace("'",'',trim("'$_POST[fecha]'")):'NOW()';//CURRENT_DATE or CURRENT_TIME
$ubicacion = isset($_POST['ubicacion'])?str_replace("'",'',trim($_POST['ubicacion'])):'';
$resumen = isset($_POST['resumen'])?str_replace("'",'',trim($_POST['resumen'])):'';
$coleccion = isset($_POST['coleccion'])?str_replace("'",'',trim($_POST['coleccion'])):'';
$carrera = isset($_POST['carrera'])?str_replace("'",'',trim($_POST['carrera'])):'';
$success = "";
if($_SERVER["REQUEST_METHOD"]=='POST'){
    //insert colecciones
    $result = mysqli_query($con,"INSERT INTO acacolec(colec_cod_carer,colec_nom_colec) SELECT (SELECT carer_cod_carer FROM acacarer WHERE carer_nom_carer='$carrera'),'$coleccion' WHERE NOT EXISTS(SELECT 1 FROM acacolec WHERE colec_nom_colec='$coleccion')");
    //insert projectos
    $result = mysqli_query($con,"INSERT INTO acaprojc(projc_mat_projc,projc_tit_projc,projc_fec_projc,projc_ubi_projc,projc_rem_projc,projc_fil_projc,projc_cod_colec) VALUES ('$material','$titulo',NOW(),'$ubicacion','$resumen','',(SELECT colec_cod_colec FROM acacolec WHERE colec_nom_colec='$coleccion'))");
    //insert tutor
    $result = mysqli_query($con,"INSERT INTO acatutor(tutor_nom_tutor) SELECT '$tutor' WHERE NOT EXISTS(SELECT 1 FROM acatutor WHERE tutor_nom_tutor='$tutor')");
    //insert autor
    $result = mysqli_query($con,"INSERT INTO acaautor(autor_nom_autor,autor_cod_projc,autor_cod_tutor) VALUES('$autor',(SELECT MAX(projc_cod_projc) FROM acaprojc),(SELECT tutor_cod_tutor FROM acatutor WHERE tutor_nom_tutor='$tutor'))");
    //insert palabras clave
    $metadata="";
    foreach($colpalabras as $palclaves){
        if(!empty($palclaves))$metadata.=", ".str_replace("'",'',trim($palclaves));
    }
    $result = mysqli_query($con,"INSERT INTO acaplbrs(plbrs_nom_plbrs,plbrs_cod_projc) VALUES('".substr($metadata,2)."',(SELECT MAX(projc_cod_projc) FROM acaprojc))");
    //update data file upload
    $sql="SELECT MAX(projc_cod_projc) id FROM acaprojc";
    $result = $con->query($sql);
    $id=mysqli_fetch_assoc($result);$id=$id['id'];
}
if(!empty($titulo)){
    $archivo="../files/ISTVL-$id.pdf";
    $success="datos guardados";
    if(file_exists(str_replace($id,"null$_SESSION[boot]",$archivo))){
        if(rename(str_replace($id,"null$_SESSION[boot]",$archivo),$archivo)){
            $sql = "UPDATE acaprojc SET projc_fil_projc='".str_replace("null$_SESSION[boot]",$id,$archivo)."' WHERE projc_cod_projc='$id'";
            $result = $con->query($sql);
            $success="archivo guardado correctamente";
        }
    }
}
/* if(!empty($result)){
    echo"<script type='text/javascript'>
//alert('Registro Correcto');
window.location.href='../steward/insertion';
</script>"; 
}else{
    echo'<script type="text/javascript">
//alert("Algo salio mal :/");
window.location.href="../steward/insertion";
</script>';
} */
