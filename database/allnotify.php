<?php
    session_start();
    error_reporting(0);
    //Definir el tiempo límite en segundos
    $tiempo_limite = 1; //Por ejemplo, cada 5 segundos
    //Obtener el tiempo actual
    $tiempo_actual = time();
    //Obtener la última vez que se realizó una solicitud por parte del usuario (si existe)
    if(isset($_SESSION['antiDOS'])){
        $ultima_solicitud = $_SESSION['antiDOS'];
        //Calcular el tiempo transcurrido desde la última solicitud
        $tiempo_transcurrido = $tiempo_actual - $ultima_solicitud;
        //Verificar si el tiempo transcurrido es menor que el tiempo límite
        if($tiempo_transcurrido < $tiempo_limite){
            //Si se supera el límite de solicitudes detener la ejecución
            exit();
        }
    }
    //Actualizar el tiempo de la última solicitud en la sesión
    $_SESSION['antiDOS'] = $tiempo_actual;
    //Procesar la solicitud normalmente para evitar DoS
    require_once('conexion.php');
    if(!empty($_SESSION['codusr'])&&$_SERVER["REQUEST_METHOD"]=='POST'){
        $notification=mysqli_query($con,"SELECT DISTINCT chats_omsg_chats FROM acachats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1 ORDER BY chats_cod_chats DESC LIMIT 3");
        if(mysqli_num_rows($notification)>0){
            $variables=array();$item=[];
            while($notify=mysqli_fetch_assoc($notification)){
                $notice=mysqli_query($con,"SELECT COUNT(*) notice FROM acachats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1");
                $notice=mysqli_fetch_assoc($notice);
                $msg=mysqli_query($con,"SELECT SUBSTRING(chats_msg_chats,1,15) AS msg FROM acachats WHERE chats_imsg_chats=$_SESSION[codusr] AND chats_omsg_chats=$notify[chats_omsg_chats] AND chats_read_chats=1 ORDER BY chats_cod_chats DESC LIMIT 1");
                $msg=mysqli_fetch_assoc($msg);
                $usr=mysqli_query($con,"SELECT users_usr_users,users_sts_users FROM acausers WHERE users_cod_users=$notify[chats_omsg_chats]");
                $usr=mysqli_fetch_assoc($usr);
                $reader=mysqli_query($con,"SELECT COUNT(chats_read_chats) readed FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE chats_omsg_chats=$notify[chats_omsg_chats] AND chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1");
                $reader=mysqli_fetch_assoc($reader);
                $ulmsg=(strlen($msg['msg'])>15)?substr($msg['msg'],0,15).'...':$msg['msg'];
                $item = [
                    'cod'=>"$notify[chats_omsg_chats]",
                    'nth'=>"$notice[notice]",
                    'image'=>"../images/default-user.jpeg",
                    'msg'=>"$ulmsg",
                    'usr'=>"$usr[users_usr_users]",
                    'read'=>"$reader[readed]",
                    'sts'=>"$usr[users_sts_users]"
                ];
                array_push($variables,$item);
            }
            echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
        }
    }
?>