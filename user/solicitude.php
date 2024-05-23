<?php
    require_once('./microhead.php');
    require_once('../database/showsolicitude.php');//el orden del archivo influye en el session_start
?>
            <style>
                :is(.table-striped tbody tr) td:nth-child(2),td:nth-child(3) {
                    text-align: center;
                    padding: 0 15px 0 15px;
                }
            </style>
            <div class="home-content">
                <div class="overview-boxes">
                    <div class="container">
                        <br><br>
                        <?php if(empty($_REQUEST['admit'])){?>
                            <div class="account-header">Solicitud de subida de archivos</div>
                            <br>
                            <label>Titulo:</label>
                            <input type="text" name="title" class="form-control" form="usrform" required><br>

                            <label>Materia o ubicación en la que desea establecer:</label>
                            <input type="text" name="ubication" class="form-control" form="usrform" required><br>

                            <label>Motivo o/y descripción:</label>
                            <textarea name="reason" rows="4" class="form-control" form="usrform" required></textarea><br>
                            <br>
                            <div class="document-center">
                                <div class="wrapper-file">
                                    <header>Cargador de archivos</header>
                                    <form action="#">
                                        <input type="file" class="file-input" name="file" accept="application/pdf" hidden>
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Arrastre un archivo para subir<br>limite 10 MB</p>
                                    </form>
                                    <section class="progress-area"></section>
                                    <section class="uploaded-area">
                                        <?php if(file_exists($archivo)){
                                        $tamanio=filesize($archivo)/1000;
                                        $tamanio=($tamanio<1024)?number_format($tamanio,2)." KB":number_format($tamanio*1000/(1024*1024),2)." MB";
                                        ?>
                                        <li class="row">
                                            <div class="content">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <div class="details">
                                                <span class="name"><?=str_replace('../files/temp/','',$archivo);?></span>
                                                <span class="size"><?=str_replace(".",',',$tamanio);?></span>
                                            </div>
                                            </div>
                                            <i class="fas fa-check"></i>
                                        </li>
                                        <?php }?>
                                    </section>
                                </div>
                            </div>
                            <?php
                                if($success!="")echo "<div class='success-txt'>$success</div>";
                            ?>
                            <div class="error-txt" style="display:none"></div>
                            <br>
                            <form action="../database/solicitude" method="post" id="usrform">
                                <button class="btn-save" type="submit">Guardar</button>
                                <a class="btn btn-info" type="submit" name="cancel" href=".">Cancel</a><br>
                            </form>
                            <script src="../js/upload.js"></script>
                        <?php }else{?>
                            <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                                <thead class="sorting">
                                <tr role="row"><th tabindex="0" style="width:66px;height:30px">Índice</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width:250px;">Titulo</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width:185px;">Materia/ubicación</th>
                                <th tabindex="0" rowspan="1" colspan="1" style="width:113px;">Acciones</th>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($solicitude as $edits){?>
                                        <tr>
                                            <td><?=$i;?></td>
                                            <td><?=$edits['solic_prj_solic'];?></td>
                                            <td><?=$edits['solic_ubi_solic'];?></td>
                                            <td>
                                                <a class='btn btn-success' href='./update?id=<?=$edits['solic_cod_solic'];?>'><i class="fa-solid fa-pencil"></i></a>
                                                <a class='btn btn-danger' name="delete" tabindex="<?=$i;?>" direction='id=<?=$edits['solic_cod_solic'];?>' href='#'><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php 
                                    $i++;}?>
                                </tbody>
                            </table>
                            <br>
                            <a class="btn btn-info" type="submit" name="cancel" href=".">Regresar a la pagina principal</a><br>
                        <?php }?>
                        <br>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/modal.js"></script>
        <script>
            deleteFile("../database/deletesolici","no");
        </script>
        <script src="../js/coders.js"></script>
    </body>
</html>