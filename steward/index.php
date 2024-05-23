<?php
    require_once('../database/dashboard.php');
    require_once('./microhead.php');
    $visits=mysqli_query($con,"SELECT COUNT(posts_ips_posts) visits FROM acaposts WHERE posts_file_down=0");
    $visits=mysqli_fetch_assoc($visits);
    $downloads=mysqli_query($con,"SELECT COUNT(posts_file_down) downloads FROM acaposts WHERE posts_file_down!=''");
    $downloads=mysqli_fetch_assoc($downloads);
    $publications=mysqli_query($con,"SELECT COUNT(projc_cod_projc) publications FROM acaprojc");
    $publications=mysqli_fetch_assoc($publications);
?>
            <div class="home-content">
                <div class="overview-boxes">
                    <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Total Visitas</div>
                            <div class="number"><?=$visits['visits'];?><i class='bx bx-like'></i></div>
                            <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">Todas las regiones</span>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Total Descargas</div>
                            <div class="number"><?=$downloads['downloads'];?><i class='bx bxs-down-arrow-square two'></i></div>
                            <div class="indicator">
                            <i class='bx bx-down-arrow-alt down'></i>
                            <span class="text">Todas las regiones</span>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Total Publicaciones</div>
                            <div class="number"><?=$publications['publications'];?><i class='bx bx-chat three'></i></div>
                            <div class="indicator">
                            <i class='bx bx-up-arrow-alt up'></i>
                            <span class="text">Proyectos subidos</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Total Profit</div>
                            <div class="number">$12,876<i class='bx bx-cart cart three' ></i></div>
                            <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">Up from yesterday</span>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="sales-boxes">
                    <div class="recent-sales box">
                    <div class="title">Usuarios Recientes</div>
                    <div class="sales-details">
                        <ul class="details">
                        <li class="topic">Fecha</li>
                        <?php 
                            foreach ($totalUsers as $fecUsr){
                                echo "<li><a href='#'>$fecUsr[users_fec_users]</a></li>";
                            }
                        ?>
                        </ul>
                        <ul class="details">
                        <li class="topic">Usuario</li>
                        <?php 
                            foreach ($totalUsers as $usr){
                                echo "<li><a href='#'>$usr[users_usr_users]</a></li>";
                            }
                        ?>
                    </ul>
                    <ul class="details">
                        <li class="topic">Email</li>
                        <?php 
                            foreach ($totalUsers as $nomUsr){
                                echo "<li><a href='#'>$nomUsr[users_eml_users]</a></li>";
                            }
                        ?>
                    </ul>
                    <ul class="details">
                        <li class="topic">Status</li>
                        <?php 
                            foreach ($totalUsers as $emlUsr){
                                echo "<li><a href='#'>".(($emlUsr['users_sts_users']==1)?"activo":"incativo")."</a></li>";
                            }
                        ?>
                    </ul>
                    </div>
                    <div class="button">
                        <a href="./list">See All</a>
                    </div>
                    </div>
                    <div class="top-sales box">
                    <div class="title">Solicitudes</div>
                    <ul class="top-sales-details">
                        <?php
                            foreach($totalPosts as $topPost){
                        ?>
                        <a href="./list?solic=edit&listuser=<?=$topPost['users_usr_users'];?>">
                            <li>
                                <div style="display:flex;align-items:center">
                                    <?php $image=($_SERVER['REQUEST_SCHEME']== 'http')?str_replace("https://","http://",$topPost['users_img_users']):str_replace("http://","https://",$topPost['users_img_users']);
                                    $imgPost = @get_headers(!empty($topPost['users_img_users'])?str_replace("https://","http://",$topPost['users_img_users']):'error');?>
                                    <img src="<?=($imgPost && strpos($imgPost[0], '200'))?$image:'../images/default-user.jpeg';?>" alt="">
                                    <span class="product"><?=$topPost['users_usr_users'];?></span>
                                </div>
                                <span class="price"><?=$topPost['contador'];?></span>
                            </li>
                        </a>
                        <?php
                            }
                        ?>
                    </ul>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/coders.js"></script>
    </body>
</html>