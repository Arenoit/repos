<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Load Composer's autoloader
    require('../PHPMailer/PHPMailer.php');
    require('../PHPMailer/SMTP.php');
    require('../PHPMailer/Exception.php');
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        require_once('conexion.php');
        $email=(!empty($_POST['email']))?strtolower(trim($_POST['email'])):'';
        $regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
        $hash = md5($email);
        $dominioURL = ($_SERVER['SERVER_NAME']=="localhost")?$_SERVER["REQUEST_SCHEME"]."://".$_SERVER['SERVER_NAME']."/".explode("/",$_SERVER["SCRIPT_NAME"])[1]:
                    $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['SERVER_NAME'];
        if(preg_match($regex,$email)){
            $email=(!empty($_POST['email']))?str_replace("'",'',$email):'';
            //Create an instance; passing `true` enables exceptions
            $userExists = "SELECT users_nom_users,users_usr_users FROM acausers WHERE users_eml_users='$email'";
            $ifExists = mysqli_query($con,$userExists);
            $user=$ifExists->fetch_assoc();
            $name=(!empty($user['users_nom_users']))?$user['users_nom_users']:'';
            $bootuser=(!empty($user['users_usr_users']))?$user['users_usr_users']:'';
            $encript1=md5($name);
            $encript2=md5($email);
            if(mysqli_num_rows($ifExists)>0){
                $resetPass = "UPDATE acausers SET users_hash_users='$hash',users_res_users='1' WHERE users_eml_users='$email' AND users_val_users=1";
                mysqli_query($con,$resetPass);
                $mail = new PHPMailer(true);
                try{
                    //Server settings
                    $mail->SMTPDebug = 0;//Enable verbose debug output
                    $mail->isSMTP();//Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';//Set the SMTP server to send through
                    $mail->SMTPAuth   = true;//Enable SMTP authentication
                    $mail->Username   = 'davidrylacer@gmail.com';//SMTP username
                    $mail->Password   = 'tusd xbzg gfnh fgal';//google Alias or password SMTP Corporation
                    $mail->SMTPSecure = 'tls';//Enable implicit TLS or SSL encryption
                    $mail->Port       = 587;//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
                    $menssage = <<<HTML
                    <h2>Recuperación de cuenta</h2>
                    <p>Alguien (¡esperamos que usted!) Solicitó restablecer la contraseña de su cuenta.
                    <br>-------------------------
                    <br>Nickname: $bootuser
                    <br>Correo: $email;
                    <br>-------------------------
                    <br>
                    <br>Por favor Haga clic en el enlace a continuación para elegir una nueva contraseña:
                    <br>$dominioURL/session/reset?fate=$encript1$hash$encript2
                    <br>Nota: Este token de restauración solo funciona una vez.
                    <br>Si desea realizar de nuevo esta transacción vuelva a realizar la petición en:
                    <br>$dominioURL/session/identifier?reset=password
                    <br>
                    <br>Todos los derechos reservados</p>
                    HTML;
                    //Recipients
                    $mail->setFrom('istvlrepos@projectesis.infinityfreeapp.com','ISTVL');
                    $mail->addAddress($email,$name);     //Add a recipient
                    //$mail->addAddress('ellen@example.com');               //Name is optional
                    //$mail->addReplyTo('info@example.com', 'Information');
                    //$mail->addCC('cc@example.com');
                    //$mail->addBCC('bcc@example.com');
    
                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
                    //Content
                    //$mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Reset Password | Recuperar Cuenta';
                    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                    $mail->msgHTML($menssage);
                    $mail->AltBody = strip_tags($menssage);
    
                    $mail->send();
                    echo 'validate';
                    /* echo'<script type="text/javascript">
                    //alert("Registro Correcto");
                    window.location.href="../session/login";
                    </script>'; */
                }catch(Exception $e){
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            else echo 'Email no válido!';
        }else echo 'Email no válido!';
    }
?>