<?php
    session_start();
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
            //Si se supera el límite de solicitudes y detener la ejecución
            exit();
        }
    }
    //Actualizar el tiempo de la última solicitud en la sesión
    $_SESSION['antiDOS'] = $tiempo_actual;
    //Procesar la solicitud normalmente para evitar DoS
    if($_SESSION['type']==0){
        $id=(!empty($_POST['varfile']))?$_POST['varfile']:'';
        $id=(is_numeric($id))?"null$id":"null$_SESSION[boot]";
        $file_name = $_FILES['file']['name'];//getting file name
        $tmp_name = $_FILES['file']['tmp_name'];//getting temp_name of file
    
        $allowedMIME = 'application/pdf';
        $finfo = finfo_open(FILEINFO_MIME_TYPE);//Create a FileInfo object
        $typeMIME = finfo_file($finfo,$tmp_name);//Get the MIME type of the uploaded file
        finfo_close($finfo);//Close the FileInfo object
        if($typeMIME === $allowedMIME){
            //$file_up_name = time().$file_name;//making file name dynamic by adding time before file name
            move_uploaded_file($tmp_name,"../files/ISTVL-$id.pdf");//moving file to the specified folfer with dynamic name
        }
    }else{
        $id=(!empty($_POST['varfile']))?$_POST['varfile']:'';
        $id=(is_numeric($id))?"null$id":"null$_SESSION[boot]";
        $file_name = $_FILES['file']['name'];//getting file name
        $tmp_name = $_FILES['file']['tmp_name'];//getting temp_name of file
        $allowedMIME = 'application/pdf';
        $finfo = finfo_open(FILEINFO_MIME_TYPE);//Create a FileInfo object
        $typeMIME = finfo_file($finfo,$tmp_name);//Get the MIME type of the uploaded file
        finfo_close($finfo);//Close the FileInfo object
        if($typeMIME === $allowedMIME){
            move_uploaded_file($tmp_name,"../files/temp/stack-$id.pdf");//moving file to the specified folfer with dynamic name
        }
    }
?>