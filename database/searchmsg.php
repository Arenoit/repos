<?php
session_start();
error_reporting(0);
require_once('conexion.php');
$searchTerm=!empty($_REQUEST['searchTerm'])?str_replace("'",'',$_REQUEST['searchTerm']):"";
if(!empty($_SESSION['codusr'])&&empty($_POST['outgoing'])){//Case search in searcher
    if(!empty($searchTerm)){
        $sql = mysqli_query($con,"SELECT users_cod_users,users_eml_users,users_usr_users,users_img_users FROM acausers WHERE (users_usr_users LIKE '".$searchTerm."%' OR users_eml_users LIKE '".$searchTerm."%') AND users_cod_users!='$_SESSION[codusr]'".(($_SESSION['type']==1)?"AND users_typ_users=0":"")." LIMIT 7");
        if(mysqli_num_rows($sql)>0){
            $variables=array();$item=[];
            while($row = mysqli_fetch_assoc($sql)){
                $image=($_SERVER['REQUEST_SCHEME']== 'http')?str_replace("https://","http://",$row['users_img_users']):str_replace("http://","https://",$row['users_img_users']);
                $headers=@get_headers(!empty($row['users_img_users'])?str_replace("https://","http://",$row['users_img_users']):'error');
                $image=(($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg');
                $item = [
                    'cod'=>"$row[users_cod_users]",
                    'image'=>$image,
                    'usr'=>"$row[users_usr_users]",
                    'eml'=>"$row[users_eml_users]",
                ];
                array_push($variables,$item);
            }echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
        }
    }else{
        $sql = mysqli_query($con,"SELECT DISTINCT users_cod_users,MAX(chats_time_chats) timer,users_eml_users,users_usr_users,users_img_users,users_typ_users,users_sts_users FROM acausers,acachats WHERE users_cod_users!='$_SESSION[codusr]'".(($_SESSION['type']==1)?" AND users_typ_users=0":"")." AND (acachats.chats_imsg_chats=acausers.users_cod_users OR acachats.chats_omsg_chats=acausers.users_cod_users) GROUP BY users_usr_users ORDER BY timer DESC");
        if(mysqli_num_rows($sql)>0){$ulmsg="";$variables=array();$item=[];
            while($row = mysqli_fetch_assoc($sql)){
                $sql2 = mysqli_query($con,"SELECT SUBSTRING(chats_msg_chats,1,15) AS msg,chats_omsg_chats FROM acachats WHERE (chats_imsg_chats=$row[users_cod_users] OR chats_omsg_chats=$row[users_cod_users]) AND (chats_omsg_chats=$_SESSION[codusr] OR chats_imsg_chats=$_SESSION[codusr]) ORDER BY chats_cod_chats DESC LIMIT 1");
                $row2 = mysqli_fetch_assoc($sql2);
                $sql3 = mysqli_query($con,"SELECT COUNT(chats_read_chats) readed FROM acachats LEFT JOIN acausers ON acausers.users_cod_users=acachats.chats_imsg_chats WHERE chats_omsg_chats=$row[users_cod_users] AND chats_imsg_chats=$_SESSION[codusr] AND chats_read_chats=1");
                $row3 = mysqli_fetch_assoc($sql3);//query unread Messages
                if(mysqli_num_rows($sql2)>0){
                    $ulmsg = $row2['msg'];
                }else{
                    $ulmsg = "Sin mensajes";
                }
                if(mysqli_num_rows($sql2)>0||$_SESSION['type']==1){//only shows users with messages
                    //triming message if word are more than 28
                    $msg = (strlen($ulmsg)>15)?substr($ulmsg,0,15).'...':$ulmsg;
                    $image=($_SERVER['REQUEST_SCHEME']=='http')?str_replace("https://","http://",$row['users_img_users']):str_replace("http://","https://",$row['users_img_users']);
                    $headers = @get_headers(!empty($row['users_img_users'])?str_replace("https://","http://",$row['users_img_users']):'error');
                    //adding you: text before msg if login id send msg 
                    $you=($_SESSION['codusr']==$row2['chats_omsg_chats'])?"Tú: $msg":$msg;
                    $item = [
                        'cod'=>$row['users_cod_users'],
                        'usr'=>$row['users_usr_users'],
                        'image'=>(($headers && strpos($headers[0],'200'))?$image:'../images/default-user.jpeg'),
                        'msg'=>$you,
                        'read'=>$row3['readed'],
                        'sts'=>$row['users_sts_users']
                    ];
                    array_push($variables,$item);
                }
            }echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
        }
    }
}
?>