<?php
require_once('conexion.php');
$archivo=basename($_POST['file']);
$codproject = preg_replace("/[^0-9]/", "", $archivo);
$ipAddress = (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
$stmt = $con->prepare("INSERT INTO acaposts (posts_ips_posts,posts_file_down,posts_fec_posts) VALUES ('$ipAddress',?,'".date("Y-m-d H:i:s")."')");
$stmt->bind_param("s", $codproject);

if ($stmt->execute()) {
    echo "Registro de descarga exitoso";
} else {
    echo "Error al registrar la descarga: " . $stmt->error;
}

$stmt->close();
$con->close();
?>