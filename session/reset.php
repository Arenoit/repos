<?php
session_start();
$token=!empty($_REQUEST['fate'])?$_REQUEST['fate']:0;

$_SESSION['token']=empty($_SESSION['token'])?$token:$_SESSION['token'];
if(strlen($token)==96||$_SESSION['token']>0){
    require_once('../database/conexion.php');
    $encript1='';
    $encript2='';
    $hash='';
    $reset='';
    $rows=0;
    $email=(!empty($_POST['email']))?str_replace("'",'',strtolower(trim($_POST['email']))):'';
    if(!empty($_POST['email'])&&!empty($_POST['opassword'])&&!empty($_POST['password'])){
        $ifExists=mysqli_query($con,"SELECT users_nom_users,users_usr_users,users_hash_users,users_res_users FROM acausers WHERE users_eml_users='$email'");
        $user=$ifExists->fetch_assoc();
        $rows=mysqli_num_rows($ifExists);
        $name=!empty($user['users_nom_users'])?$user['users_nom_users']:'';
        $bootuser=!empty($user['users_usr_users'])?$user['users_usr_users']:'';
        $hash=!empty($user['users_hash_users'])?$user['users_hash_users']:'';
        $reset=!empty($user['users_res_users'])?$user['users_res_users']:0;
        $encript1=md5($name);
        $encript2=md5($email);
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Style Navbar-->
    <link rel="stylesheet" href="../css/formain.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <title>Repositorio</title>
    </head>
    <body>
        <script>
            for(i=0;i<3;i++)document.write("<br>") ;
        </script>
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
        </style>
        <form action="./reset" class="boot-form" method="POST">
            <h2>Restablecer contaseña</h2>
            <div class="form-group fullname">
                <label for="email">Correo</label>
                <input type="text" id="email" name="email" value="<?=$email;?>" placeholder="nombre de usuario" required>
            </div>
            <div class="form-group password">
                <label for="opassword">Nueva constraseña</label>
                <input type="password" id="opassword" name="opassword" placeholder="contraseña" required>
                <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
            </div>
            <div class="form-group password">
                <label for="password">Comfirmar constraseña</label>
                <input type="password" id="password" name="password" placeholder="contraseña" required>
                <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
                <?php
                if($encript1.$hash.$encript2==$_SESSION['token']){
                    if($reset==1){
                        if(!empty($_POST['password'])&&$_POST['opassword']==$_POST['password']){
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $restPassword = "UPDATE acausers SET users_pas_users='$password',users_hash_users='',users_res_users=0 WHERE users_eml_users='$email' AND users_res_users=1";
                            mysqli_query($con,$restPassword);
                            echo '<div class="success-txt" style="display:block">Tu contraseña ha sido cambiada correctamente</div>';
                        }else{
                            echo '<div class="error-txt" style="display:block">La contraseña debe estar igual en ambos campos</div>';
                        }
                    }
                }else if(!empty($email))echo '<div class="error-txt" style="display:block">Email inválido</div>';
                if($rows>0&&$reset==0&&!empty($email))echo '<div class="error-txt" style="display:block">Token obsoleto!</div>';
                ?>
            </div>
            <div class="form-group submit-btn">
                <a class="btn reg" style="color:azure" href="./login">Regresar al login</a>
                <input type="submit" value="Cambiar contraseña" class="btn enviar">
            </div>
        </form>
        <script>
            // Toggling password visibility
            const passwordInput = document.querySelectorAll(".password input");
            passwordInput.forEach(passToggleBtn=>{
                passToggleBtn.parentElement.querySelector("i").addEventListener("click",function(){
                    passToggleBtn.parentElement.querySelector("i").className = passToggleBtn.type === "password" ? "fa-solid fa-eye-slash" : "fa-solid fa-eye";
                    passToggleBtn.type = passToggleBtn.type === "password" ? "text" : "password";
                });
            });
        </script>
    </body>
    </html>
<?php
}else{
    echo'<script type="text/javascript">
    window.location.href="../session/login";
    </script>';
}
?>