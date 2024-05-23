<?php
    session_start();
    //Definir el tiempo límite en segundos
    $tiempo_limite = 0.3; //Por ejemplo, cada 5 segundos
    //Obtener el tiempo actual
    $tiempo_actual = time();
    //Obtener la última vez que se realizó una solicitud por parte del usuario (si existe)
    if(isset($_SESSION['ultima_solicitud'])){
        $ultima_solicitud = $_SESSION['ultima_solicitud'];
        //Calcular el tiempo transcurrido desde la última solicitud
        $tiempo_transcurrido = $tiempo_actual - $ultima_solicitud;
        //Verificar si el tiempo transcurrido es menor que el tiempo límite
        if($tiempo_transcurrido < $tiempo_limite){
            //Si se supera el límite de solicitudes, mostrar un mensaje de error y detener la ejecución
            exit();
        }
    }
    //Actualizar el tiempo de la última solicitud en la sesión
    $_SESSION['ultima_solicitud'] = $tiempo_actual;
    //Procesar la solicitud normalmente para evitar DoS
    error_reporting(0);
    require_once('conexion.php');
    $incoming=(!empty($_POST['incoming'])&&is_numeric($_POST['incoming']))?$_POST['incoming']:0;
    if(!empty($_SESSION['codusr'])&&$_SERVER["REQUEST_METHOD"]=='POST'){
        $variables=array();$item=[];
        if(!empty($incoming)){
            $sql=mysqli_query($con,"SELECT chats_cod_chats,chats_msg_chats,users_img_users FROM acachats JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_omsg_chats=$incoming AND chats_read_chats=1 LIMIT 1");
            if($sql=mysqli_fetch_assoc($sql)){
                $headers = @get_headers(!empty($image)?str_replace("https://","http://",$sql['users_img_users']):'error');
                $image=(($headers && strpos($headers[0],'200'))?$sql['users_img_users']:'../images/default-user.jpeg');
                $item = [
                    'imsg'=>"$sql[chats_msg_chats]",
                    'image'=>$image
                ];
                array_push($variables,$item);
                mysqli_query($con,"UPDATE acachats SET chats_read_chats=0 WHERE chats_cod_chats=$sql[chats_cod_chats] AND chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1");
            }
        }
        $permiso=mysqli_query($con,"SELECT xchat_omsg_xchat FROM acaxchat WHERE xchat_bell_xchat=1 AND xchat_imsg_xchat=$_SESSION[codusr] LIMIT 1");
        if($permiso=mysqli_fetch_assoc($permiso)){
            $notice=mysqli_query($con,"SELECT COUNT(*) notice FROM acachats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1");
            $notice=mysqli_fetch_assoc($notice);
            $msg=mysqli_query($con,"SELECT SUBSTRING(chats_msg_chats,1,15) AS msg FROM acachats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_omsg_chats=$permiso[xchat_omsg_xchat] AND chats_read_chats=1 ORDER BY chats_cod_chats DESC LIMIT 1");
            $msg=mysqli_fetch_assoc($msg);
            $usr=mysqli_query($con,"SELECT users_usr_users,users_sts_users FROM acausers WHERE users_cod_users=$permiso[xchat_omsg_xchat]");
            $usr=mysqli_fetch_assoc($usr);
            $reader=mysqli_query($con,"SELECT COUNT(chats_read_chats) readed FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE chats_omsg_chats=$permiso[xchat_omsg_xchat] AND chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1");
            $reader=mysqli_fetch_assoc($reader);
            $ulmsg=(strlen($msg['msg'])>15)?substr($msg['msg'],0,15).'...':$msg['msg'];
            $item = [
                'cod'=>"$permiso[xchat_omsg_xchat]",
                'nth'=>"$notice[notice]",
                'image'=>"../images/default-user.jpeg",
                'msg'=>"$ulmsg",
                'usr'=>"$usr[users_usr_users]",
                'read'=>"$reader[readed]",
                'sts'=>"$usr[users_sts_users]"
            ];
            array_push($variables,$item);
            mysqli_query($con,"UPDATE acaxchat SET xchat_bell_xchat=0,xchat_evn_xchat=1 WHERE xchat_imsg_xchat=$_SESSION[codusr] AND xchat_omsg_xchat=$permiso[xchat_omsg_xchat]");
        }
        echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
    }
?>