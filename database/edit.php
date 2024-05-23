<?php
require_once('conexion.php');

$id = $_GET['id'];
$material="";
$titulo="";
$autor="";
$tutor="";
$palabras=[''];
$fecha="";
$ubicacion="";
$resumen="";
$coleccion="";
$carrera="";
$archivo="";

$error="";
$success="";

$sql = "SELECT prj.projc_mat_projc,prj.projc_tit_projc,aut.autor_nom_autor,tor.tutor_nom_tutor,prj.projc_fec_projc,
  prj.projc_ubi_projc,prj.projc_rem_projc,erv.colec_nom_colec,car.carer_nom_carer,prj.projc_fil_projc FROM acaprojc prj
  JOIN acaautor aut
  ON aut.autor_cod_projc=prj.projc_cod_projc 
  JOIN acatutor tor
  ON tor.tutor_cod_tutor=aut.autor_cod_tutor
  JOIN acacolec erv
  ON erv.colec_cod_colec=prj.projc_cod_colec
  JOIN acacarer car
  ON car.carer_cod_carer=erv.colec_cod_carer
  where prj.projc_cod_projc='$id'";
$updateCareers=mysqli_query($con,"SELECT carer_nom_carer FROM acacarer");
if($_SERVER["REQUEST_METHOD"]=='GET'){
  //GET method: Show the data of the client
  unlink("../files/ISTVL-null$id.pdf"); //Eliminar el archivo que no fue autorizado para guardar
  if(!isset($_GET['id'])){
    echo'<script type="text/javascript">
    //header("location: ../steward/search");
    window.location.href="../steward/search";
    </script>';
    exit;
  }

  //read the row of the selected client from database table
  $result = $con->query($sql);
  $row = $result->fetch_assoc();
  $tags = "SELECT plbrs_nom_plbrs,plbrs_cod_projc FROM acaplbrs where plbrs_cod_projc='$id'";
  $etiquetas = $con->query($tags);

  while(!$row){
    header("location: ./search.php");
    exit;
  }

  $material=$row['projc_mat_projc'];
  $titulo=$row['projc_tit_projc'];
  $autor=$row['autor_nom_autor'];
  $tutor=$row['tutor_nom_tutor'];
  $i=0;
  while($aux = $etiquetas->fetch_assoc()){
    $palabras[$i]=$aux['plbrs_nom_plbrs'];
    $i++;
  }

  $fecha=$row['projc_fec_projc'];
  $ubicacion=$row['projc_ubi_projc'];
  $resumen=$row['projc_rem_projc'];
  $coleccion=$row['colec_nom_colec'];
  $carrera=$row['carer_nom_carer'];
  $archivo=$row['projc_fil_projc'];
}else{
  //POST method: Update the data of the client
  $material=str_replace("'",'',trim($_POST['material']));
  $titulo=str_replace("'",'',trim($_POST['titulo']));
  $autor=str_replace("'",'',trim($_POST['autor']));
  $tutor=str_replace("'",'',trim($_POST['tutor']));
  $palabras=isset($_POST['colpalabras'])?$_POST['colpalabras']:[''];
  $metadata="";
  foreach($palabras as $palclaves){
    if(!empty($palclaves))$metadata.=", ".str_replace("'",'',trim($palclaves));
  }
  $metadata=substr($metadata,2);
  $result = $con->query($sql);
  $row = $result->fetch_assoc();
  $fecha=(!empty($_POST['fecha']))?str_replace("'",'',trim($_POST['fecha'])):$row['projc_fec_projc'];
  $ubicacion=str_replace("'",'',trim($_POST['ubicacion']));
  $resumen=str_replace("'",'',trim($_POST['resumen']));
  $coleccion=str_replace("'",'',trim($_POST['coleccion']));
  $carrera=str_replace("'",'',trim($_POST['carrera']));

  mysqli_query($con,"INSERT INTO acacolec(colec_cod_carer,colec_nom_colec) SELECT (SELECT carer_cod_carer FROM acacarer WHERE carer_nom_carer='$carrera'),'$coleccion' WHERE NOT EXISTS(SELECT 1 FROM acacolec WHERE colec_nom_colec='$coleccion')");
  mysqli_query($con,"INSERT INTO acatutor(tutor_nom_tutor) SELECT '$tutor' WHERE NOT EXISTS(SELECT 1 FROM acatutor WHERE tutor_nom_tutor='$tutor')");

  $sql = "UPDATE
  acaprojc
  JOIN acaautor
  ON acaautor.autor_cod_projc = acaprojc.projc_cod_projc
  JOIN acaplbrs
  ON acaplbrs.plbrs_cod_projc = acaprojc.projc_cod_projc
  JOIN acatutor
  ON acatutor.tutor_cod_tutor = acaautor.autor_cod_tutor
  JOIN acacolec
  ON acacolec.colec_cod_colec = acaprojc.projc_cod_colec
  JOIN acacarer
  ON acacarer.carer_cod_carer = acacolec.colec_cod_carer
  SET
  acaprojc.projc_mat_projc = '$material', acaprojc.projc_tit_projc = '$titulo', 
  acaautor.autor_nom_autor = '$autor', acaautor.autor_cod_tutor = (SELECT tutor_cod_tutor FROM acatutor WHERE tutor_nom_tutor='$tutor'), 
  acaplbrs.plbrs_nom_plbrs = '$metadata', acaprojc.projc_fec_projc = '$fecha', acaprojc.projc_rem_projc = '$resumen', acaprojc.projc_ubi_projc = '$ubicacion',
  acaprojc.projc_cod_colec = (SELECT colec_cod_colec FROM acacolec WHERE colec_nom_colec='$coleccion'), 
  acacolec.colec_cod_carer = (SELECT carer_cod_carer FROM acacarer WHERE carer_nom_carer='$carrera')
  WHERE acaprojc.projc_cod_projc='$id'";
  $con->query($sql);

  mysqli_query($con,"DELETE acatutor FROM acatutor JOIN (SELECT acatutor.tutor_nom_tutor nombre FROM acatutor WHERE NOT EXISTS (SELECT NULL FROM acaautor WHERE autor_cod_tutor=tutor_cod_tutor)) tor ON (tor.nombre=tutor_nom_tutor)");
  mysqli_query($con,"DELETE acacolec FROM acacolec JOIN (SELECT colec_nom_colec nombre FROM acacolec WHERE NOT EXISTS (SELECT NULL FROM acaprojc WHERE projc_cod_colec=colec_cod_colec)) col ON (col.nombre=colec_nom_colec)");

  if(!empty($titulo)){
    $archivo="../files/ISTVL-null$id.pdf";
    if(file_exists($archivo)){
      // Realiza la operación de reemplazo aquí
      if(rename($archivo,str_replace("null",'',$archivo))){
        $con->query("UPDATE acaprojc SET projc_fil_projc='".str_replace('null','',$archivo)."' WHERE projc_cod_projc='$id'");
        $success="archivo guardado correctamente";
      }
    }else{
      $success="datos guardados";
    }
  }
}
?>
