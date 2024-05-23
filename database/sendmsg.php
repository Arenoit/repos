<?php
    session_start();
    error_reporting(0);
    require_once('conexion.php');
    $incoming=(!empty($_POST['incoming'])&&is_numeric($_POST['incoming']))?$_POST['incoming']:0;
    $outgoing=!empty($_SESSION['codusr'])?$_SESSION['codusr']:'';
    $menssage=!empty($_POST['menssage'])?mysqli_real_escape_string($con,$_POST['menssage']):'';
    if(!empty($menssage)){//If want load static messages
        $sql=mysqli_query($con,"SELECT chats_omsg_chats FROM acachats LIMIT 1");
        $msg = (strlen($ulmsg)>200)?substr($menssage,0,200).'...':$menssage;
        if(mysqli_num_rows($sql)==0){
            mysqli_query($con,"INSERT INTO acachats(chats_cod_chats,chats_imsg_chats,chats_omsg_chats,chats_read_chats,chats_msg_chats,chats_time_chats) VALUES (1,'$incoming','$outgoing','1','$menssage',NOW())");//CURRENT_TIMESTAMP
            echo $msg;
        }else{
            mysqli_query($con,"INSERT INTO acachats(chats_cod_chats,chats_imsg_chats,chats_omsg_chats,chats_read_chats,chats_msg_chats,chats_time_chats) SELECT (chats_cod_chats+1),'$incoming','$outgoing','1','$menssage',NOW() FROM acachats ORDER BY chats_cod_chats DESC LIMIT 1");
            echo $msg;
        }
        $sql=mysqli_query($con,"SELECT xchat_cod_xchat FROM acaxchat LIMIT 1");
        if(mysqli_num_rows($sql)==0)mysqli_query($con,"INSERT INTO acaxchat(xchat_imsg_xchat,xchat_omsg_xchat,xchat_bell_xchat,xchat_evn_xchat) VALUES ('$incoming','$outgoing',1,1)");
        else{
            mysqli_query($con,"INSERT INTO acaxchat(xchat_imsg_xchat,xchat_omsg_xchat,xchat_bell_xchat,xchat_evn_xchat) SELECT '$incoming','$outgoing',1,1 FROM acaxchat WHERE NOT EXISTS(SELECT 1 FROM acaxchat WHERE xchat_imsg_xchat='$incoming' AND xchat_omsg_xchat='$outgoing') ORDER BY xchat_cod_xchat DESC LIMIT 1");
            mysqli_query($con,"UPDATE acaxchat SET xchat_bell_xchat=1,xchat_evn_xchat=1 WHERE xchat_imsg_xchat='$incoming' AND xchat_omsg_xchat='$outgoing'");
        }
    }
?>