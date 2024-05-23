<?php
    require_once('./microhead.php');
?>
            <style>
                @media (max-width: 400px) {
                    .home-section{
                        left: 0;
                    }
                }
            </style>
            <div class="home-content">
                <div class="container">
                    <div class="document-center">
                        <div>
                            <div class="users-datas" style="display:flex;flex-wrap:wrap">
                                <div>
                                    <h1>Actualizar Perfil</h1>
                                    <div class="wrapper">
                                        <div class="upload-box">
                                            <input type="file" accept="images/*" hidden>
                                            <?php $image=($_SERVER['REQUEST_SCHEME']=='http')?str_replace("https://","http://",$row['users_img_users']):str_replace("http://","https://",$row['users_img_users']);
                                            $headers = @get_headers(!empty($row['users_img_users'])?str_replace("https://","http://",$row['users_img_users']):'error');?>
                                            <img src="<?=($headers && strpos($headers[0],'200'))?$image:'';?>" alt="">
                                            <p>Arrastre una imagen para subir</p>
                                            <button class="upload-btn">Subir imagen</button>
                                            <i class="fa-solid fa-pencil"></i>
                                            <div class="edit-img">
                                                <ul>editar</ul>
                                                <ul>eliminar</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="users-datas-input">
                                    <h1>&nbsp;</h1>
                                    <label for="name">Nombre:</label>
                                    <input input autocomplete="off" type="text" id="name" name="name" value="<?=$row['users_nom_users'];?>" class="form-control" form="usrform">
                                    <label for="email">Email Público:</label>
                                    <input input autocomplete="off" type="text" id="email" name="email" value="<?=$row['users_eml_users'];?>" class="form-control" form="usrform" disabled>
                                </div>
                            </div>
                            <div class="users-datas-input">
                                <label for="user">Usuario:</label>
                                <input input autocomplete="off" type="text" id="user" name="user" value="<?=$row['users_usr_users'];?>" class="form-control" form="usrform">
                                <label for="regisdate">Fecha de inscripción:</label>
                                <input input autocomplete="off" type="date" id="regisdate" name="regisdate" value="<?=$row['users_fec_users'];?>" class="form-control" form="usrform" disabled>
                                <label for="bio">Biografía: </label>
                                <textarea id="bio" name="bio" rows="4" class="form-control" form="usrform" style="resize: none;"><?=$row['users_bio_users'];?></textarea>
                                <label for="occupation">Ocupación:</label>
                                <input input autocomplete="off" type="text" id="occupation" name="occupation" value="<?=$row['users_ocu_users'];?>" class="form-control" form="usrform">
                                <br>
                                <div class="success-txt" style="display:none"></div>
                                <div class="error-txt" style="display:none"></div>
                                <br>
                                <form action="" method="POST" class="user-update" id="usrform">
                                    <a id="changepass" href="#">Cambiar contraseña</a>
                                    <h4>&nbsp;</h4>
                                    <button class="btn-save" type="submit">Actualizar Cambios</button>
                                </form>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        <script src="../js/account.js"></script>
        <script src="../js/coders.js"></script>
    </body>
</html>
