<?php
require_once('./microhead.php');
require_once('../database/conexion.php');
?>
<style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            min-height: 100vh;
            background-image: url("https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Biblioteca-montserrat.jpg/1200px-Biblioteca-montserrat.jpg");
            background-size: cover;
        }
        .boot-form{
            height: unset;
            width: auto;
            max-width: 200%;
            min-height: 39rem;
            display: flex;
        }
        .boot-form p{
            color: blanchedalmond;
        }
        .message-active{
            display: flex;
            flex-direction: column;
            padding-right: 5rem;
        }
        .message-logo img{
            border-radius: 15px;
        }
        input[type=submit]{
            color: #fff;
            border: none;
            height: auto;
            width: auto;
            float: right;
            font-size: 16px;
            padding: 0.375rem 0.75rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-align: center;
            background-color: #007bff;
            transition: 0.2s ease;
        }
    </style>
    <?php
    $message='';
    $message1='';
    $message2='';
    if(isset($_GET['email'])&&!empty($_GET['email']) AND isset($_GET['hash'])&&!empty($_GET['hash'])){
        // Verificar datos
        $id = mysqli_real_escape_string($con,substr($_GET['hash'],32)); // Asignar el id a una variable
        $email = mysqli_real_escape_string($con,$_GET['email']); // Asignar el correo electrónico a una variable
        $hash = mysqli_real_escape_string($con,substr($_GET['hash'],0,32)); // Asignar el hash a una variable
                    
        $search = mysqli_query($con,"SELECT users_eml_users,users_val_users FROM acausers WHERE users_cod_users='$id' AND users_eml_users='$email' AND users_hash_users='$hash' AND users_val_users=0") or die(mysql_error()); 
        $match  = mysqli_num_rows($search);
                    
        if($match > 0){
            // Hay una coincidencia, activar la cuenta
            mysqli_query($con,"UPDATE acausers SET users_val_users=1 WHERE users_cod_users='$id' AND users_eml_users='$email' AND users_hash_users='$hash' AND users_val_users=0") or die(mysql_error());
            $message="Ya eres uno de nosotros";
            $message1="Cuenta activada";
            $message2="Tu cuenta $_GET[email] ha sido <br>activada, ya puedes iniciar sesión.";
        }else{
            // No hay coincidencias
            $message="Token Expirado";
            $message1="Error en el Token";
            $message2="La URL es inválida  o ya has activado tu cuenta.";
        }
    }else{
        // Intento nó válido (ya sea porque se ingresa sin tener el hash o porque la cuenta ya ha sido registrada)
        $message="URL es Inválida";
            $message1="Error en el Token";
            $message2="Intento inválido, por favor revisa el mensaje que enviamos correo electrónico.";
    }


    ?>
    <form action="./login" class="boot-form" method="POST">
        <div class="message-active">
            <br><br>
            <h1><?=$message;?></h1>
            <h3><?=$message1;?></h3>
            <p><?=$message2;?></p>
            <br>
            <input type="submit" value="Iniciar sessión" class="btn enviar">
        </div>
        <div class="message-logo">
            <img src="https://scontent.fltx1-1.fna.fbcdn.net/v/t39.30808-6/310719217_3494132887540358_1247871019817125048_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=efb6e6&_nc_ohc=Xo-Mr7Ls33YAX8tnD3A&_nc_ht=scontent.fltx1-1.fna&oh=00_AfAdUWXZ7SKfKWQUit57lmXdV3unQBmKwQkJcVoeFgvZ6g&oe=65A04E42" alt="">
        </div>
    </form>
</body>
<script src="../js/ajax.js"></script>
<script>
    autocom(document.querySelector("nav > .search-box > #seeker"),"../api","click");
</script>
<script src="../js/alrtsession.js"></script>
<script>
    alertSession("../database/kwere");
</script>
</html>
