<?php
session_start();
error_reporting(0);
require_once('conexion.php');
$read = (!empty($_POST['reader']))?str_replace("'",'',strtolower(trim($_POST['reader']))):'';
$pass = (!empty($_POST['password']))?$_POST['password']:'';

//Login
if(!empty($read)&&!empty($pass)){
    $resultAux = mysqli_query($con,"SELECT * from acausers WHERE (users_usr_users='".$read."' OR users_eml_users='".$read."') AND users_val_users=1");
    
    $verify=$resultAux->fetch_assoc();
    $user=!empty($verify['users_usr_users'])?$verify['users_usr_users']:'';
    $email=!empty($verify['users_eml_users'])?$verify['users_eml_users']:'';
    
    $hash=!empty($verify['users_pas_users'])?$verify['users_pas_users']:'';

    if(!password_verify($pass, $hash)) {
        echo 'El usuario o la contraseña son incorrectos';
        mysqli_close($con);
        session_destroy();//session_abort();
    }else{
        if($user==$read||$email==$read){
            $_SESSION['codusr']=$verify['users_cod_users'];
            $_SESSION['boot']=$verify['users_usr_users'];
            $_SESSION['type']=$verify['users_typ_users'];
            mysqli_query($con,"UPDATE acausers SET users_sts_users=1,users_bit_users=CURTIME() WHERE users_eml_users='".$email."'");//update status
            mysqli_query($con,"UPDATE acausers SET users_sts_users=0 WHERE users_bit_users<ADDTIME(CURTIME(),'-01:00:00')");//inactive users 
            echo 'success';
            /* echo '<script type="text/javascript">
            window.location.href="../steward/dashboard";
            </script>'; */
        }else{
            mysqli_query($con,"DELETE FROM acausers WHERE users_fec_users < DATE_SUB(NOW(), INTERVAL 5 DAY) AND acausers.users_val_users=0");
            echo 'El usuario o la contraseña son incorrectos o el usuario no ha sido habilitado';
            /* mysqli_close($con);
            session_abort();
            session_destroy(); */
        }
    }
}else{
    /* echo'<script type="text/javascript">
    window.location.href="../session/login";
    </script>'; */
    echo 'Todos los datos son requeridos';
    mysqli_close($con);
    //session_abort();
    session_destroy();
}
?>