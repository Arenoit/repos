<?php
    session_start();
    //Definir el tiempo límite en segundos
    $tiempo_limite = 1; //Por ejemplo, cada 5 segundos
    //Obtener el tiempo actual
    $tiempo_actual = time();
    //Obtener la última vez que se realizó una solicitud por parte del usuario (si existe)
    if(isset($_SESSION['antiDOS2'])){
        $ultima_solicitud = $_SESSION['antiDOS2'];
        //Calcular el tiempo transcurrido desde la última solicitud
        $tiempo_transcurrido = $tiempo_actual - $ultima_solicitud;
        //Verificar si el tiempo transcurrido es menor que el tiempo límite
        if($tiempo_transcurrido < $tiempo_limite){
            //Si se supera el límite de solicitudes, mostrar un mensaje de error y detener la ejecución
            exit();
        }
    }
    //Actualizar el tiempo de la última solicitud en la sesión
    $_SESSION['antiDOS2'] = $tiempo_actual;
    //Procesar la solicitud normalmente para evitar DoS
    require_once('conexion.php');
    $id=!empty($_REQUEST['id'])?str_replace("'",'',$_REQUEST['id']):"";
    $title=!empty($_REQUEST['title'])?str_replace("'",'',$_REQUEST['title']):"";
    $ubication=!empty($_REQUEST['ubication'])?str_replace("'",'',$_REQUEST['ubication']):"";
    $reason=!empty($_REQUEST['reason'])?str_replace("'",'',$_REQUEST['reason']):"";
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(!empty($_SESSION['codusr'])&&!empty($title&&$ubication&&$reason)&&empty($id)){
            mysqli_query($con,"INSERT INTO acasolic(solic_cod_users,solic_prj_solic,solic_ubi_solic,solic_mot_solic,solic_rev_solic,solic_fil_solic) VALUES ('8','$title','$ubication','$reason',0,'')");
            $result = $con->query("SELECT MAX(solic_cod_solic) id FROM acasolic");
            $id=mysqli_fetch_assoc($result);$id=$id['id'];
            $archivo="../files/temp/stack-null$_SESSION[boot].pdf";
            if(file_exists($archivo)){
                if(rename($archivo,str_replace("null$_SESSION[boot]",$id,$archivo))){
                    $result = $con->query("UPDATE acasolic SET solic_fil_solic='".str_replace("null$_SESSION[boot]",$id,$archivo)."' WHERE solic_cod_users=$_SESSION[codusr] AND solic_cod_solic=$id");
                }
            }
        }
        if(!empty($id)&&!empty($title&&$ubication&&$reason)){
            $archivo="../files/temp/stack-null$id.pdf";
            if(file_exists($archivo)){
                if(rename($archivo,str_replace("null","",$archivo))){
                    mysqli_query($con,"UPDATE acasolic SET solic_fil_solic='".str_replace("null","",$archivo)."' WHERE solic_cod_users=$_SESSION[codusr] AND solic_cod_solic=$id");
                }
            }
            mysqli_query($con,"UPDATE acasolic SET solic_prj_solic='$title',solic_ubi_solic='$ubication',solic_mot_solic='$reason' WHERE solic_cod_users=$_SESSION[codusr] AND solic_cod_solic=$id");
        }
        echo'<script type="text/javascript">
                window.location.href="../user/";
                </script>';
    }
?>