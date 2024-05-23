<?php
    session_start();
    require_once('../database/conexion.php');
    //Definir el tiempo límite en segundos
    $tiempo_limite = 310;//Por ejemplo, cada 5 minutos
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
            echo'<script type="text/javascript">
            window.location.href="../session/login";
            </script>';
            session_destroy();
            die();
            exit();
        }
    }
    //Actualizar el tiempo de la última solicitud en la sesión
    $_SESSION['ultima_solicitud'] = $tiempo_actual;
    //Procesar la solicitud normalmente para evitar DoS
    //Cerrar todas las sessiones
    if(!empty($_REQUEST['exit'])){$exit="";
        if(isset($_SESSION['Choose'])){
            for($i=0;$i<count($_SESSION['Choose']);$i++){ 
                $exit.=",'".$_SESSION['Choose'][$i]."'";
            }
            mysqli_query($con,"UPDATE acausers SET users_sts_users=0 WHERE users_usr_users IN(".substr($exit,1).")");//status
        }else{
            if(isset($_SESSION['boot']))mysqli_query($con,"UPDATE acausers SET users_sts_users=0 WHERE users_usr_users='$_SESSION[boot]'");//status
        }
        
        echo'<script type="text/javascript">
        window.location.href="../session/login";
        </script>';
        session_destroy();
        die();
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <title>Repositorio</title>
    <style>
    /* Google Fonts - Poppins */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif
    }
    body{
        display: flex;
        align-items: center;
        padding: 0 10px;
        min-height: 100vh;
        background-image: url(https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Biblioteca-montserrat.jpg/1200px-Biblioteca-montserrat.jpg);
        background-size: cover;
        justify-content: center;
        flex-direction: column;
    }
    .identifier{
        padding: 25px;
        width: 100%;
        color: #fff;
        background: rgb(44 47 49 / 64%);
        max-width: 500px;
        border-radius: 7px;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05)
    }
    .identifier div{
        background: #696969d1;
        border-radius: 5px;
        padding: 4px;
        margin-bottom: 4px;
        cursor: pointer
    }
    .identifier div:hover{
        background: dodgerblue  
    }
    .identifier a:not(.log-out){
        color: deepskyblue
    }
    .identifier h2{
        font-size: 27px;
        text-align: center;
        margin: 0px 0 30px
    }
    .identifier img{
        height: 45px;
        width: 45px;
        margin: 0 15px;
        border-radius: 25px;
        object-fit: cover;
        pointer-events: none
    }
    .identifier p{
        display: inline-block
    }
    .log-out{
        display: block;
        color: antiquewhite;
        background: dimgrey;
        max-width: 16rem;
        padding: 3px;
        margin-top: 12px;
        border-radius: 4px;
        text-decoration: none;
    }
    .log-out:hover{
        background: steelblue;
    }
    i{
        font-size: 18px;
    }
    </style>
</head>
<body>
    <div class="identifier">
        <h2>Cambiar cuenta</h2>
        <?php
            // Inicializar el array en la sesión si aún no existe
            if(!isset($_SESSION['Choose'])){
                $_SESSION['Choose'] = [];
            }
            // Añadir el nuevo valor al array en la sesión
            if(!empty($_SESSION['boot'])){
                $_SESSION['Choose'][] = $_SESSION['boot'];
            }
            // Eliminar duplicados
            $_SESSION['Choose'] = array_unique($_SESSION['Choose']);
            // Realizar operaciones con el array de valores en la sesión
            foreach($_SESSION['Choose'] as $valor) {
                $idsers=mysqli_query($con,"SELECT users_img_users,users_eml_users FROM acausers WHERE acausers.users_usr_users='".htmlspecialchars($valor)."'");
                $idsers=$idsers->fetch_assoc();
                $image=($_SERVER['REQUEST_SCHEME']=='http')?str_replace("https://","http://",$idsers['users_img_users']):str_replace("http://","https://",$idsers['users_img_users']);
                $headers = @get_headers(!empty($idsers['users_img_users'])?str_replace("https://","http://",$idsers['users_img_users']):'error');
                echo '<div onclick="sendIdent(' . htmlspecialchars("'".$valor."'") .')"><img src="'.(($headers && strpos($headers[0], '200'))?$image:'../images/default-user.jpeg').'" alt=""><p>' . htmlspecialchars($valor) .'<br>'. $idsers["users_eml_users"] . '</p></div>';
            }
        ?>
        <a href="./identifier">Usar otra cuenta</a>
        <?php
            if(empty($_SESSION['Choose'])){
                echo'<script type="text/javascript">
                window.location.href="../session/login";
                </script>';
                session_destroy();
                die();
                exit();
            }
            if($_SERVER["REQUEST_METHOD"]=='POST'){
                foreach($_SESSION['Choose'] as $valor){
                    if($_POST['user']==$valor)$_SESSION['boot']=$_POST['user'];
                }
                $otherUser=mysqli_query($con,"SELECT users_cod_users,users_typ_users FROM acausers WHERE acausers.users_usr_users='$_SESSION[boot]'");
                $otherUser=$otherUser->fetch_assoc();
                $_SESSION['codusr']=$otherUser['users_cod_users'];
                $_SESSION['type']=$otherUser['users_typ_users'];
            }
        ?>
        <script src="../js/identifier.js"></script>
    </div>
    <br>
    <a class="log-out" href="./meeting?exit=1">&nbsp;&nbsp;<i class="fa-solid fa-arrow-right-to-bracket"></i> Salir de todas las cuentas</a>
</body>
</html>