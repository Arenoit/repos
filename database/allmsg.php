<?php
    session_start();
    error_reporting(0);
    require_once('conexion.php');
    $incoming=(!empty($_POST['incoming'])&&is_numeric($_POST['incoming']))?$_POST['incoming']:0;
    $outgoing=!empty($_SESSION['codusr'])?$_SESSION['codusr']:'';
    $menssage=(!empty($_POST['menssage'])&&is_numeric($_POST['menssage']))?$_POST['menssage']:0;
    if(!empty($outgoing)){
        $sql=mysqli_query($con,"SELECT chats_cod_chats,chats_msg_chats,chats_omsg_chats,users_img_users FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE ((chats_omsg_chats='$outgoing' AND chats_imsg_chats='$incoming') OR (chats_omsg_chats='$incoming' AND chats_imsg_chats='$outgoing')) AND acachats.chats_cod_chats<=$menssage ORDER BY chats_cod_chats DESC LIMIT 1");
        $refer=mysqli_fetch_assoc($sql);
        $headers = @get_headers(!empty($image)?str_replace("https://","http://",$refer['users_img_users']):'error');
        $image=(($headers && strpos($headers[0],'200'))?$refer['users_img_users']:'../images/default-user.jpeg');
        $sql=mysqli_query($con,"SELECT chats_cod_chats,chats_msg_chats,chats_omsg_chats FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE ((chats_omsg_chats='$outgoing' AND chats_imsg_chats='$incoming') OR (chats_omsg_chats='$incoming' AND chats_imsg_chats='$outgoing')) AND acachats.chats_cod_chats<=$menssage ORDER BY chats_cod_chats DESC LIMIT 5");
        if(mysqli_num_rows($sql)>0){
            $variables=array();$item=[];
            $item = [
                'msg'=>(!empty($menssage)?$menssage-5:0),
                'image'=>(!empty($menssage)?$menssage:0)
            ];
            array_push($variables,$item);
            while($row = mysqli_fetch_assoc($sql)){
                //Object JSON and it is not traverse in the same way as an array
                if($row['chats_omsg_chats'] === $outgoing){//if this is equal to then he is a msg render
                    $item = [
                        'msg'=>$row['chats_msg_chats'],
                        'image'=>''
                    ];
                }else{
                    $item = [
                        'msg'=>$row['chats_msg_chats'],
                        'image'=>$image
                    ];
                }     
                array_push($variables,$item);
            }echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
        }
    }
?>