<?php
require_once('./microhead.php');
require_once('../database/edit.php');
?>
      <div class="home-content container" style="display: flex;justify-content: center;">
        <div style="width:32rem;background:#fff;border-radius:10px;padding:18px 25px 20px;">
          <div class="card-header" style="color: white;background-color:#8e00ff;padding: 0.75rem 1.25rem;border-radius: 5px;text-align: center;">
            <h2>Editar Projecto</h2>
          </div>
          <style>
            span{
              color: inherit;
              background-color: #fff0;
              border-radius: 0;
              min-width: 0;
              padding: 0;
              line-height: 0;
              float: none;
            }
            .form-control{
              border-radius: 5px;
              border: 1px solid #a6a6a6;
            }
            .autocom-box div{
              width: 463px;
            }
            @media (max-width: 525px){
              .autocom-box div{
                width: max-content;
              }
              .home-section{
                  left: 75px;
              }
              .sidebar.active ~ .home-section{
                width: calc(100% + 73px);
              }
            }
          </style>
          <input type="hidden" name="id" value="<?=$id;?>" class="form-control" form="usrform">

          <div><a class="btn btn-success" href="./insertion" style="float:right;margin-bottom: 1px;">Agregar Nuevo</a><label style="float:left"> Tipo de Material: </label></div>
          <input type="text" name="material" value="<?=$material;?>" class="form-control" form="usrform" required><br>

          <label>Titulo:</label>
          <input type="text" name="titulo" value="<?=$titulo;?>" class="form-control" form="usrform" required><br>

          <label>Autor:</label>
          <input type="text" name="autor" value="<?=$autor;?>" class="form-control" form="usrform" required><br>

          <label>Tutor:</label>
          <input type="text" name="tutor" value="<?=$tutor;?>" class="form-control" form="usrform" required><br>
          
          <div class="wrapperbox">
            <div class="title">
                <img src="../images/tag-price-svgrepo-com.svg" alt="tag-icon">
                <h2>Palabras Clave</h2>
            </div>
            <div class="content">
                <!-- <p>Press enter or add a comma after each tag</p> -->
                <ul id="colpalabrastag">
                  <script>let metatags = [];</script>
                  <?php
                    $metadatas=(count($palabras)==1)?explode(", ",$palabras[0]):explode(", ",$metadata);
                    for($i=0; $i < count($metadatas); $i++) { 
                  ?>
                      <script>
                        metatags[<?=$i;?>] = ['<?=$metadatas[$i];?>'];
                      </script>
                  <?php
                    }
                  ?>
                <input type="text" value=""></ul>
            </div>
            <div class="details">
                <p><span>10</span> etiquetas restantes</p>
                <button>Remover Todas</button>
            </div>
          </div>

          <label>Fecha de publicacion:</label>
          <input type="date" name="fecha" value="<?=$fecha;?>" class="form-control" form="usrform"><br>

          <label>Ubicación:</label>
          <input type="text" name="ubicacion" value="<?=$ubicacion;?>" class="form-control" form="usrform" required><br>

          <label>Resumen:</label>
          <textarea name="resumen" rows="4" class="form-control" form="usrform" required><?=$resumen;?></textarea><br>

          <label>Coleccion Bibliografica:</label>
          <input type="text" name="coleccion" autocomplete="off" value="<?=$coleccion;?>" class="form-control" form="usrform" required><br>

          <label>Carrera:</label>
          <select name="carrera" id="carrera" class="form-control" form="usrform">
              <?php
                foreach($updateCareers as $csloption){
                  if($csloption['carer_nom_carer']==$carrera){
              ?>
                    <option value="<?=$carrera;?>"><?=$carrera;?></option>
              <?php
                  }
                }
              ?>

              <?php
                foreach($updateCareers as $options){
                  if($options['carer_nom_carer']!=$carrera){
              ?>
                  <option value="<?=$options['carer_nom_carer'];?>"><?=$options['carer_nom_carer'];?></option>
              <?php
                  }
                }
              ?>
          </select>
          <br>
          <div class="wrapper-file">
              <header>Cargador de archivos</header>
              <form action="#">
                <input type="file" class="file-input" name="file" accept="application/pdf" hidden>
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Arrastre un archivo para subir<br>limite 10 MB</p>
              </form>
              <section class="progress-area"></section>
              <section class="uploaded-area">
                <?php if(file_exists(str_replace("null",'',$archivo))){
                  $tamanio=filesize(str_replace("null",'',$archivo))/1000;
                  $tamanio=($tamanio<1024)?number_format($tamanio,2)." KB":number_format($tamanio*1000/(1024*1024),2)." MB";
                  ?>
                  <li class="row">
                    <div class="content">
                      <i class="fas fa-cloud-upload-alt"></i>
                      <div class="details">
                        <span class="name"><?=str_replace('../files/','',str_replace("null",'',$archivo));?></span>
                        <span class="size"><?=str_replace(".",',',$tamanio);?></span>
                      </div>
                    </div>
                    <i class="fas fa-check"></i>
                  </li>
                <?php }?>
              </section>
          </div>
          <?php
            if($success!="")echo "<div class='success-txt'>$success</div>";
          ?>
          <div class="error-txt" style="display:none"></div>
          <br>
          <form method="post" id="usrform">
            <button class="btn-save" type="submit">Guardar</button>
            <a class="btn btn-info" type="submit" name="cancel" href="./search"> Cancel </a><br>
          </form>
        </div>
      </div>
    </section>
    <br><br><br><br>
  </body>
  <script src="../js/upload.js"></script>
  <script src="../js/coders.js"></script>
  <script src="../js/projects.js"></script>
  <script src="../js/tags.js"></script>
  <script>
    littleTags(metatags,document.querySelector(".wrapperbox .content ul"));
  </script>
  <script src="../js/ajax.js"></script>
  <script>autocom(document.querySelector("input[name=coleccion]"),"../api","");</script>
</html>
