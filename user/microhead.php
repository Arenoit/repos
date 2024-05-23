<?php
session_start();
error_reporting(0);
$codusr=$_SESSION['codusr'];
$usuario=$_SESSION['boot'];
$admin=$_SESSION['type'];
if(empty($admin)){
    echo'<script type="text/javascript">
    window.location.href="../steward";
    </script>';
}
if(empty($usuario)){
    echo'<script type="text/javascript">
    window.location.href="../session/login";
    </script>';
    session_destroy();
    die();
    exit();
}else if(!empty($usuario)&&$admin==1){
    require_once('../database/conexion.php');
    $sql = "SELECT users_img_users,users_nom_users,users_eml_users,users_usr_users,users_fec_users,
            users_bio_users,users_ocu_users FROM acausers WHERE users_cod_users='".$_SESSION['codusr']."'";
    $result = $con->query($sql);
    $row=$result->fetch_assoc();
    //Definir el tiempo límite en segundos
    $tiempo_limite = 300;//Por ejemplo, cada 5 minutos
    //Obtener el tiempo actual
    $tiempo_actual = time();
    //Obtener la última vez que se realizó una solicitud por parte del usuario (si existe)
    if(isset($_SESSION['ultima_solicitud'])){
        $ultima_solicitud = $_SESSION['ultima_solicitud'];
        //Calcular el tiempo transcurrido desde la última solicitud
        $tiempo_transcurrido = $tiempo_actual - $ultima_solicitud;
        //Verificar si el tiempo transcurrido es menor que el tiempo límite
        if($tiempo_transcurrido >= $tiempo_limite){
            //Si se cumplio el periodo de inactividad salir de la sessión
            mysqli_query($con,"UPDATE acausers SET users_sts_users='inactive' WHERE users_usr_users='".$_SESSION['boot']."'");//status
            echo'<script type="text/javascript">
            window.location.href="../session/login";
            </script>';
            session_destroy();
            die();
            exit();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Style Tags-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/thinline.css">
    <!--Style Navbar-->
    <link rel="stylesheet" href="../css/members.css" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <title>Repositorio</title>
    </head>
    <body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="../images/logo-istvl.png" alt="" style="width:38px;margin:0 12px">
            <span class="logo_name">Repositorio</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="." <?php if($_SERVER["REQUEST_URI"]=="/user/"){ echo "class='active'";} ?>>
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Principal</span>
                </a>
            </li>
            <li>
                <a href="./search"  <?php if($_SERVER["REQUEST_URI"]=="/user/search"){ echo "class='active'";} ?>>
                    <i class='bx bx-book-alt'></i>
                    <span class="links_name">Biblioteca</span>
                </a>
            </li>
            <li>
                <a href="./account" <?php if($_SERVER["REQUEST_URI"]=="/user/account"){ echo "class='active'";} ?>>
                    <i class='bx bx-user'></i>
                    <span class="links_name">Cuenta</span>
                </a>
            </li>
            <li>
                <a href="./menssages" <?php if($_SERVER["REQUEST_URI"]=="/user/menssages"){ echo "class='active'";} ?>>
                    <i class='bx bx-message' ></i>
                    <span class="links_name">Mensajes</span>
                </a>
            </li>
            <li class="log_out">
                <a href="../session/logout">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard"></span>
            </div>
            <ul class="nav-links">
                <li><a href="./home">Inicio</a></li>
                <li><a href="./search">Biblioteca</a></li>
            </ul>
            <div class="notifications">
                <i class='bx bxs-bell-ring'></i>
                <div class="notify">
                    <?php 
                    $notifications = mysqli_query($con,"SELECT chats_omsg_chats readed FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1 GROUP BY chats_omsg_chats");
                    $countNotify=0;
                    foreach($notifications as $loquet){
                        $countNotify++;
                    }
                    echo $countNotify;
                    ?>
                </div>
                <div class="notify-options"><div class="unmessage"></div></div>
            </div>
            <div class="profile-details">
                <?php $image=($_SERVER['REQUEST_SCHEME']== 'http')?str_replace("https://","http://",$row['users_img_users']):str_replace("http://","https://",$row['users_img_users']);
                $headers = @get_headers(!empty($row['users_img_users'])?str_replace("https://","http://",$row['users_img_users']):'error');?>
                <img src="<?=($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg';?>" alt="">
                <span class="admin-name"><?=$row['users_usr_users'];?></span>
                <i class='bx bx-chevron-down' ></i>
                <div class="user-options">
                    <div><a href="../session/meeting">Iniciar con otra cuenta <i class="fa-solid fa-arrow-right-arrow-left"></i></a></div>
                    <div>
                    <img src="<?=($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg';?>" alt="">
                        <div class="user-info">
                        <h4><?=(strlen($row['users_usr_users'])<24)?$row['users_usr_users']:substr($row['users_usr_users'],0,23)."...";?></h4>
                            <p><?=(strlen($row['users_eml_users'])<24)?$row['users_eml_users']:substr($row['users_eml_users'],0,23)."...";?></p>
                            <a href="./account">Ir a cuenta</a>
                        </div>
                    </div>
                    <a href="../session/logout">Cerra sesión</a>
                </div>
            </div>
        </nav>
<?php
}
?>
