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
            //Si se supera el límite de solicitudes, mostrar un mensaje de error y detener la ejecución
            echo "Se ha superado el límite de solicitudes permitidas. Por favor, inténtalo de nuevo más tarde.";
            exit();
        }
    }
    //Actualizar el tiempo de la última solicitud en la sesión
    $_SESSION['antiDOS'] = $tiempo_actual;
    //Procesar la solicitud normalmente para evitar DoS
    require_once('conexion.php');
    if(!empty($_SESSION['codusr'])){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $imgubica="../images/users/USER-$_SESSION[codusr].jpeg";
            if(!empty($_POST['deleteimg'])){
                if(unlink($imgubica)){
                    echo$sql = "UPDATE acausers SET users_img_users='' WHERE users_cod_users='".$_SESSION['codusr']."'";
                    $result = $con->query($sql);
                }
            }else{
                $dominioURL = ($_SERVER['SERVER_NAME']=="localhost")?$_SERVER["REQUEST_SCHEME"]."://".$_SERVER['SERVER_NAME']."/".explode("/",$_SERVER["SCRIPT_NAME"])[1]:
                $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['SERVER_NAME'];
                if(!file_exists('../images/users')){
                    mkdir('../images/users',0777,true);//Crea una carpeta
                    if(file_exists('../images/users')){
                        // Obtener el contenido binario del cuerpo de la solicitud
                        $rawData = file_get_contents("php://input");
                        // Aquí $rawData contiene los datos binarios del ArrayBuffer enviado desde JavaScript
                        $file = fopen($imgubica, "wb");//crea el archivo
                        $content = fwrite($file, $rawData);//imprime los datos dentro del archivo
                        fclose($file);//cierra el proceso
                        //if($file == true) echo "Success";else echo "no se pudo";
                        if(file_exists($imgubica)){
                            $result = $con->query("UPDATE acausers SET users_img_users='".$dominioURL."/images/users/USER-$_SESSION[codusr].jpeg?t=".time()."' WHERE users_cod_users='".$_SESSION['codusr']."'");
                        }
                    }
                }else{
                    // Obtener el contenido binario del cuerpo de la solicitud
                    $rawData = file_get_contents("php://input");
                    // Aquí $rawData contiene los datos binarios del ArrayBuffer enviado desde JavaScript
                    $file = fopen($imgubica, "wb");//crea el archivo
                    $content = fwrite($file, $rawData);//imprime los datos dentro del archivo
                    fclose($file);//cierra el proceso
                    //if($file == true) echo "Success";else echo "no se pudo";
                    if(!empty($rawData)&&$content == true){
                        $result = $con->query("UPDATE acausers SET users_img_users='".$dominioURL."/images/users/USER-$_SESSION[codusr].jpeg?t=".time()."' WHERE users_cod_users='".$_SESSION['codusr']."'");
                    }
                }
            }
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