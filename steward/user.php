<?php
    require_once('./microhead.php');
    $id=(!empty($_REQUEST['id']))?$_REQUEST['id']:"";
    $clickboard=mysqli_query($con,"SELECT users_img_users,users_nom_users,users_eml_users,users_usr_users,users_fec_users,users_bio_users,users_ocu_users FROM acausers WHERE users_cod_users='$id'");
    $boardrow=mysqli_fetch_assoc($clickboard);
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
                                            <?php $headers = @get_headers(!empty($boardrow['users_img_users'])?$boardrow['users_img_users']:'error');?>
                                            <img src="<?=($headers && strpos($headers[0], '200'))?$boardrow['users_img_users']:'../images/default-user.jpeg';?>" alt="">
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
                                    <input input autocomplete="off" type="text" id="name" name="name" value="<?=$boardrow['users_nom_users'];?>" class="form-control" form="usrform" disabled>
                                    <label for="email">Email Público:</label>
                                    <input input autocomplete="off" type="text" id="email" name="email" value="<?=$boardrow['users_eml_users'];?>" class="form-control" form="usrform" disabled>
                                </div>
                            </div>
                            <div class="users-datas-input">
                                <label for="user">Usuario:</label>
                                <input input autocomplete="off" type="text" id="user" name="user" value="<?=$boardrow['users_usr_users'];?>" class="form-control" form="usrform" disabled>
                                <label for="regisdate">Fecha de inscripción:</label>
                                <input input autocomplete="off" type="date" id="regisdate" name="regisdate" value="<?=$boardrow['users_fec_users'];?>" class="form-control" form="usrform" disabled>
                                <label for="bio">Biografía: </label>
                                <textarea id="bio" name="bio" rows="4" class="form-control" form="usrform" style="resize: none;" disabled><?=$boardrow['users_bio_users'];?></textarea>
                                <label for="occupation">Ocupación:</label>
                                <input input autocomplete="off" type="text" id="occupation" name="occupation" value="<?=$boardrow['users_ocu_users'];?>" class="form-control" form="usrform" disabled>
                                <br>
                                <form action="" method="POST" class="user-update" id="usrform">
                                    <a href="./list">Retroceder</a>
                                </form>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>
        <script src="../js/coders.js"></script>
    </body>
</html>