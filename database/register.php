<?php
require_once('conexion.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require('../PHPMailer/PHPMailer.php');
require('../PHPMailer/SMTP.php');
require('../PHPMailer/Exception.php');

$bootuser = isset($_POST['bootuser'])?str_replace("'",'',strtolower(trim($_POST['bootuser']))):'';
$name = isset($_POST['name'])?str_replace("'",'',trim($_POST['name'])):'';
$email = isset($_POST['email'])?str_replace("'",'',strtolower(trim($_POST['email']))):'';
$regex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
$password = isset($_POST['password'])?$_POST['password']:'';
$hash = password_hash($password, PASSWORD_DEFAULT);
$hashValidate = md5(rand(0,1000));


$dominioURL = ($_SERVER['SERVER_NAME']=="localhost")?$_SERVER["REQUEST_SCHEME"]."://".$_SERVER['SERVER_NAME']."/".explode("/",$_SERVER["SCRIPT_NAME"])[1]:
                $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['SERVER_NAME'];

$userExists = mysqli_query($con,"SELECT users_usr_users userExist FROM acausers WHERE users_usr_users='$bootuser'");
$menssage1=$userExists->fetch_assoc();
$emailExists = mysqli_query($con,"SELECT users_eml_users emailExist FROM acausers WHERE users_eml_users='$email' AND users_val_users=1");
$menssage2=$emailExists->fetch_assoc();

if(!empty($bootuser)&&!empty($name)&&preg_match($regex,$email)&&!empty($password)){
    if(!empty($menssage1['userExist'])&&!empty($menssage2['emailExist']))echo 'Usuario y correo ya existentes';
    elseif(!empty($menssage1['userExist']))echo 'Usuario de inicio ya existe';
    elseif(!empty($menssage2['emailExist']))echo 'Correo ya existe';
    else{
        $signin = "INSERT INTO acausers(users_usr_users,users_nom_users,users_eml_users,users_pas_users,users_typ_users,users_hash_users,users_bit_users,users_bio_users,users_ocu_users,users_img_users,users_sts_users,users_val_users,users_res_users,users_fec_users)  SELECT '$bootuser','$name','$email','$hash',1,'$hashValidate',CURRENT_DATE,'','','',0,0,0,CURRENT_DATE WHERE NOT EXISTS(SELECT 1 FROM acausers WHERE users_eml_users='$email' AND users_val_users=1)";
        $result = mysqli_query($con, $signin);
        $userExists = mysqli_query($con,"SELECT users_cod_users FROM acausers WHERE users_usr_users='$bootuser'");
        $menssage1=$userExists->fetch_assoc();
        $id=$menssage1['users_cod_users'];
        //Create an instance; passing `true` enables exceptions
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
            <h2>!Gracias por registrarte¡</h2>
            <p><br>Tu cuenta ha sido creada, ahora puedes iniciar tu cuenta
            <br>
            -------------------------
            <br>Nickname: $bootuser
            <br>Correo: $email;
            <br>-------------------------
            <br>
            <br>Por favor haz click en el enlace para activar tu cuenta:
            <br>$dominioURL/session/activate?email=$email&hash=$hashValidate$id
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
            $mail->Subject = 'Sign up | Validar Cuenta';
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
}else echo 'Todos los datos son requeridos';
?>