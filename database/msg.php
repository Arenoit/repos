<?php
    session_start();
    error_reporting(0);
    require_once('conexion.php');
    if(!empty($_SESSION['codusr'])&&$_SERVER["REQUEST_METHOD"]=='POST'){
        //Case to menssage
        $incoming=(!empty($_POST['incoming'])&&is_numeric($_POST['incoming']))?$_POST['incoming']:0;
        $outgoing=!empty($_SESSION['codusr'])?$_SESSION['codusr']:'';
        //If want delete
        if(!empty($_POST['deletemsg'])&&!empty($incoming)){
            $sqli = mysqli_query($con,"DELETE FROM acachats WHERE (chats_omsg_chats='$outgoing' AND chats_imsg_chats='$incoming') OR (chats_omsg_chats='$incoming' AND chats_imsg_chats='$outgoing')");
            mysqli_query($con,"UPDATE acaxchat SET xchat_bell_xchat=1,xchat_evn_xchat=0 WHERE xchat_imsg_xchat='$incoming' AND xchat_omsg_xchat='$outgoing'");
        }
        if(!empty($incoming)&&!empty($_SESSION['codusr'])){
            $countMessages=mysqli_query($con,"SELECT COUNT(chats_msg_chats) ant FROM acachats WHERE ((chats_omsg_chats='$outgoing' AND chats_imsg_chats='$incoming') OR (chats_omsg_chats='$incoming' AND chats_imsg_chats='$outgoing'))");
            $countMessages=mysqli_fetch_assoc($countMessages);
            $sql=mysqli_query($con,"SELECT chats_cod_chats,chats_msg_chats,chats_omsg_chats FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE ((chats_omsg_chats='$outgoing' AND chats_imsg_chats='$incoming') OR (chats_omsg_chats='$incoming' AND chats_imsg_chats='$outgoing')) ORDER BY chats_cod_chats DESC LIMIT 1");
            $refer=mysqli_fetch_assoc($sql);
            $sql=mysqli_query($con,"SELECT chats_cod_chats,chats_msg_chats,chats_omsg_chats FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE ((chats_omsg_chats='$outgoing' AND chats_imsg_chats='$incoming') OR (chats_omsg_chats='$incoming' AND chats_imsg_chats='$outgoing')) ORDER BY chats_cod_chats DESC LIMIT 5");
            $sqlImg = mysqli_query($con,"SELECT users_img_users FROM acausers WHERE users_cod_users='$incoming'");
            $img=mysqli_fetch_assoc($sqlImg);
            $image=($_SERVER['REQUEST_SCHEME']=='http')?str_replace("https://","http://",$img['users_img_users']):str_replace("http://","https://",$img['users_img_users']);
            $headers=@get_headers(!empty($image)?str_replace("https://","http://",$image):'error');
            $image=(($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg');
            $readed = mysqli_query($con,"UPDATE acachats SET chats_read_chats='0' WHERE chats_omsg_chats=$incoming AND chats_imsg_chats=$outgoing AND chats_read_chats=1");
            if(mysqli_num_rows($sql)>0){
                $variables=array();//Object JSON and it is not traverse in the same way as an array
                $item = [
                    'msg'=>!empty($countMessages['ant'])?$countMessages['ant']:0,
                    'image'=>($refer['chats_cod_chats']-5)
                ];
                array_push($variables,$item);
                while($row = mysqli_fetch_assoc($sql)){
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
    }else{
        echo'<script type="text/javascript">
        window.location.href="../session/login";
        </script>';
    }
?>