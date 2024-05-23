<?php

    require_once('conexion.php');

    if($_SERVER["REQUEST_METHOD"]=='GET'){

      //GET method: Show the data of the client

      if(!isset($_GET['id'])){

        echo'<script type="text/javascript">
        //header("location: ../pagtabla.php");
        window.location.href="../pagtabla.php";
        </script>';
        exit;
      }

      $id = $_GET['id'];

      //read the row of the selected client from database table
      $sql = "SELECT prj.projc_mat_projc,prj.projc_tit_projc,aut.autor_nom_autor,tor.tutor_nom_tutor,brs.plbrs_nom_plbrs,prj.projc_fec_projc,
      prj.projc_ubi_projc,prj.projc_rem_projc,erv.colec_nom_colec,car.carer_nom_carer,prj.projc_fil_projc FROM acaprojc prj

      JOIN acaautor aut
      ON aut.autor_cod_projc=prj.projc_cod_projc 

      JOIN acatutor tor
      ON tor.tutor_cod_tutor=aut.autor_cod_tutor

      JOIN acaplbrs brs
      ON brs.plbrs_cod_projc=prj.projc_cod_projc 

      JOIN acacolec erv
      ON erv.colec_cod_colec=prj.projc_cod_colec

      JOIN acacarer car
      ON car.carer_cod_carer=erv.colec_cod_carer
      where prj.projc_cod_projc='$id'";
      $library = $con->query($sql);
    }
?>