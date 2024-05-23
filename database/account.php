<?php
    session_start();
    require_once('conexion.php');
    if(!empty($_SESSION['codusr'])){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            //recibe datos formulario
            $json = file_get_contents("php://input");
            $data = json_decode($json);
            json_encode($data);//linea necesaria para acceder al objeto JSON enviado desde JavaScript
            //Puedes acceder a los valores como $data->user
            $menssage="";
            if($data == true){
                $repited=mysqli_query($con,"SELECT users_usr_users FROM acausers WHERE users_usr_users='".str_replace("'",'',strtolower(trim($data->user)))."' AND users_cod_users!=".$_SESSION['codusr']);
                $repited=mysqli_fetch_assoc($repited);
                if(!empty($repited['users_usr_users'])){
                    $menssage="nombre de usuario ya existe!";
                }else{
                    $sql = "UPDATE acausers SET users_nom_users='".str_replace("'",'',trim($data->name))."',
                    users_bio_users='".str_replace("'",'',trim($data->bio))."',users_ocu_users='".str_replace("'",'',trim($data->occupation))."'WHERE users_cod_users=".$_SESSION['codusr'];
                    $result = $con->query($sql);
                    $menssage="datos guardados correctamente";
                }
                $sql = "UPDATE acausers SET users_usr_users='".str_replace("'",'',strtolower(trim($data->user)))."',users_nom_users='".str_replace("'",'',trim($data->name))."',
                users_bio_users='".str_replace("'",'',trim($data->bio))."',users_ocu_users='".str_replace("'",'',trim($data->occupation))."'WHERE users_cod_users=".$_SESSION['codusr'].
                " AND users_usr_users IN (SELECT users_usr_users WHERE NOT EXISTS(SELECT 1 FROM acausers WHERE users_usr_users='".str_replace("'",'',strtolower(trim($data->user)))."'))";
                $result = $con->query($sql);
            }
            $variables=array();
            $sql = "SELECT users_img_users,users_nom_users,users_eml_users,users_usr_users,users_fec_users,
            users_bio_users,users_ocu_users FROM acausers WHERE users_cod_users='".$_SESSION['codusr']."'";
            $result = $con->query($sql);
            $row=$result->fetch_assoc();
            $item = [
                'menssage'=>$menssage,
                'img'=>$row['users_img_users'],
                'name'=>$row['users_nom_users'],
                'email'=>$row['users_eml_users'],
                'user'=>$row['users_usr_users'],
                'regisdate'=>$row['users_fec_users'],
                'bio'=>$row['users_bio_users'],
                'occupation'=>$row['users_ocu_users']
            ];
            array_push($variables,$item);
            echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
        }
    }else{
        echo'<script type="text/javascript">
        window.location.href="../session/login";
        </script>';
        session_destroy();
        die();
        exit();
    }
?>