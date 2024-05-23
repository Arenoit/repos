<?php
session_start();
require_once('conexion.php');
$changePassword=mysqli_query($con,"SELECT users_pas_users FROM acausers WHERE users_cod_users=$_SESSION[codusr]");
//constructor count pages
$reveal=$changePassword->fetch_assoc();
$pass = (!empty($_POST['ipassword']))?$_POST['ipassword']:'';
$hash=!empty($reveal['users_pas_users'])?$reveal['users_pas_users']:'';
if($_POST['opassword']==$_POST['password']){
    if(!password_verify($pass, $hash)) {
        echo 'Contraseña incorrecta';
    }else if(!empty($_POST['opassword'])){
        $newhash=password_hash($_POST['opassword'], PASSWORD_DEFAULT);
        $change=mysqli_query($con,"UPDATE acausers SET users_pas_users='$newhash' WHERE users_cod_users=$_SESSION[codusr]");
        echo 'Contraseña cambiada correctamente';
    }else{
        echo 'Llene todos los campos!';
    }
}else echo 'ambos campos deben que estar iguales';
?>
