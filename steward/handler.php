<?php
    require_once('../database/results.php');
    require_once('./microhead.php');
?>

      <script>
        for(i=0;i<4;i++)document.write("<br>") ;
      </script>


      <div class="container">      
        <div>
            <?php
              while($available=mysqli_fetch_array($library)){
            ?>
              <table>
                <tr><td>Tipo de Material:&nbsp;</td><td><?=$available['projc_mat_projc'];?></td></tr>
                <tr><td>Título:&nbsp;</td><td><?=$available['projc_tit_projc'];?></td></tr>
                <tr><td>Autor:&nbsp;</td><td><?=$available['autor_nom_autor'];?></td></tr>
                <tr><td>Tutor de Tesis:&nbsp;</td><td><?=$available['tutor_nom_tutor'];?></td></tr>
                <tr><td>metadatos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
                  <?php
                  $metadatas=explode(", ",$available['plbrs_nom_plbrs']);
                  foreach($metadatas as $row){
                  ?>
                    <?=$row;?>
                  <br />
                  <?php
                  }
                  ?>
                </tr>
                <tr><td>Fecha de publicación:&nbsp;</td><td><?=(strpos($foo,'-0001-11-30') !== false)?"":date("Y-m-d", strtotime($available['projc_fec_projc']));?></td></tr>
                <tr><td>Ubicación:&nbsp;</td><td><?=$available['projc_ubi_projc'];?></td></tr>
                <tr><td>Descripción:&nbsp;</td><td><?=$available['projc_rem_projc'];?></td></tr>
                <tr><td>Aparece en las colecciones: </td><td><?=$available['colec_nom_colec'];?><br/></td></tr>
              </table>
              <br/>
              <?php if(file_exists($available['projc_fil_projc'])){?>
                <div class="panel panel-info"><div class="panel-heading">Ficheros en este ítem: </div>
                <table class="table panel-body"><tr><th id="t1" class="download-posts">Fichero </th>
                  <th id="t2" class="download-posts">Descripción</th>
                  <?php
                  $tamanio=filesize($available['projc_fil_projc'])/1000;
                  $tamanio=($tamanio<1024)?number_format($tamanio,2)." KB":number_format($tamanio*1000/(1024*1024),2)." MB";
                  ?>
                  <th id="t3" class="download-posts">Tamaño</th>
                  <th id="t4" class="download-posts">Formato </th><th>&nbsp;</th></tr>
                  <tr><td headers="t1" class="download-posts"><a target="_blank" href="<?=$available['projc_fil_projc'];?>"><?=str_replace('../files/','',$available['projc_fil_projc']);?></a></td><td headers="t2" class="download-posts"><?=strtoupper($available['projc_mat_projc'])." A TEXTO COMPLETO";?></td><td headers="t3" class="download-posts"><?=str_replace(".",',',$tamanio);?></td><td headers="t4" class="download-posts">Adobe PDF</td><td class="download-posts" align="center"><a class="btn btn-primary" target="_blank" href="<?=$available['projc_fil_projc'];?>">Visualizar/Abrir </a></td></tr>
                </table>
              <?php }?>
            <?php }?>
        </div>
      </div>
    </section>
    <script src="../js/coders.js"></script>
    <script src="../js/downloads.js"></script>
    <script>
      downloadViewer("../database/downloads");
    </script>
  </body>
</html>