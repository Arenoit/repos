<?php
    require_once('../database/conexion.php');
    require_once('./microhead.php');
    $chat=is_numeric($_GET['chat'])?$_GET['chat']:0;
    mysqli_query($con,"UPDATE acausers SET users_sts_users=1,users_bit_users=CURTIME() WHERE users_cod_users='".$_SESSION['codusr']."'");//update status
?>
        <div class="home-content">
            <?php if(!empty($chat)&&$chat!=$_SESSION['codusr']){
                $confChat="SELECT users_usr_users,users_usr_users,users_sts_users,users_img_users FROM acausers WHERE users_cod_users='$_GET[chat]'";
                $configChat=mysqli_query($con,$confChat);
                $configChat=$configChat->fetch_assoc();
                $image=($_SERVER['REQUEST_SCHEME']== 'http')?str_replace("https://","http://",$configChat['users_img_users']):str_replace("http://","https://",$configChat['users_img_users']);
                $headers = @get_headers(!empty($configChat['users_img_users'])?str_replace("https://","http://",$configChat['users_img_users']):'error');
            ?>
            <div class="wrapper-box">
                <div class="chat-area">
                    <header>
                        <a href="./menssages" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                        <img src="<?=(($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg');?>" alt="">
                        <div class="content">
                            <div class="details">
                                <span><?=$configChat['users_usr_users'];?></span>
                                <p><?=($configChat['users_sts_users']==1)?"conectado":"desconectado";?></p>
                            </div>
                        </div>
                        <?=(!empty($chat)?"<div class='options'><i class='fa-solid fa-ellipsis-vertical'></i><div class='options-chat'>Vaciar chat Ø</div></div>":"");?>
                    </header>
                    <div class="chat-box">
                    </div>
                    <form action="#" class="typing-area">
                        <input type="text" name="outgoing_id" value="<?=$codusr;?>" hidden>
                        <input type="text" name="incoming_id" value="<?=$chat;?>" hidden>
                        <input type="text" name="menssage" placeholder="Type a message here..." autocomplete="off" maxlength="200">
                        <button><i class="fa-solid fa-location-arrow"></i></button>
                    </form>
                </div>
            </div>
            <?php }?>
            <?php if(empty($chat)||$chat==$_SESSION['codusr']){
                $confChat="SELECT users_usr_users,users_img_users FROM acausers WHERE users_usr_users='$usuario'";
                $configChat=mysqli_query($con,$confChat);
                $configChat=$configChat->fetch_assoc();
                $image=($_SERVER['REQUEST_SCHEME']== 'http')?str_replace("https://","http://",$configChat['users_img_users']):str_replace("http://","https://",$configChat['users_img_users']);
                $headers = @get_headers(!empty($configChat['users_img_users'])?str_replace("https://","http://",$configChat['users_img_users']):'error');
                echo "<div class='wrapper-box' style='padding:25px'>
                        <section class='users-chat'>
                            <header>
                                <div class='content'>
                                    <img src='".(($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg')."' alt=''>
                                    <div class='details'>
                                        <span>$configChat[users_usr_users]</span>
                                        <p>conectado</p>
                                    </div>
                                </div>
                            </header>
                        </section>
                        <div class='search'>
                            <span class='text'>Select an user to start chat</span>
                            <input type='text' placeholder='Enter name to search' autocomplete='off'>
                            <button><i class='fas fa-search'></i></button>
                        </div>
                        <div class='users-list'>              
                        </div>
                    </div>";
            } ?>
        </div>
    </section>
    <script src="../js/coders.js"></script>
    <script src="../js/menssages.js"></script>
    </body>
</html>
