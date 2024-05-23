<?php
    require_once('./microhead.php');
    require_once('../database/showsolicitude.php');//el orden del archivo influye en el session_start
    $solicitude=mysqli_fetch_assoc($solicitude);
?>
            <div class="home-content">
                <div class="overview-boxes">
                    <div class="container">
                        <br><br>
                            <div class="account-header">Editar: Solicitud de archivos</div>
                            <input type="text" name="id" value="<?=$solicitude['solic_cod_solic'];?>" class="form-control" form="usrform" style="visibility:hidden" required>
                            <label>Titulo:</label>
                            <input type="text" name="title" value="<?=$solicitude['solic_prj_solic'];?>" class="form-control" form="usrform" required><br>

                            <label>Materia o ubicación en la que desea establecer:</label>
                            <input type="text" name="ubication" value="<?=$solicitude['solic_ubi_solic'];?>" class="form-control" form="usrform" required><br>

                            <label>Motivo o/y descripción:</label>
                            <textarea name="reason" rows="4" class="form-control" form="usrform" required><?=$solicitude['solic_mot_solic'];?></textarea><br>
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
                                        <?php if(file_exists($solicitude['solic_fil_solic'])){
                                        $tamanio=filesize($solicitude['solic_fil_solic'])/1000;
                                        $tamanio=($tamanio<1024)?number_format($tamanio,2)." KB":number_format($tamanio*1000/(1024*1024),2)." MB";
                                        ?>
                                        <li class="row">
                                            <div class="content">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <div class="details">
                                                <span class="name"><?=str_replace('../files/temp/','',$solicitude['solic_fil_solic']);?></span>
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
                                <a class="btn btn-info" type="submit" name="cancel" href="./solicitude?admit=edit">Cancel</a><br>
                            </form>
                        <br>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/upload.js"></script>
        <script src="../js/coders.js"></script>
    </body>
</html>