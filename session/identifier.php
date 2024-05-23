<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Style Navbar-->
    <link rel="stylesheet" href="../css/formain.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
  <title>Repositorio</title>
</head>
<body>
    <script>
        for(i=0;i<3;i++)document.write("<br>") ;
    </script>
    <style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            min-height: 100vh;
            background-image: url("https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Biblioteca-montserrat.jpg/1200px-Biblioteca-montserrat.jpg");
            background-size: cover;
        }
    </style>
<?php
    $reset=(!empty($_GET['reset']))?str_replace("'",'',$_GET['reset']):'';
    if($reset!="password"){
?>
    <form action="../database/kwere" class="boot-form" method="POST">
        <h2>Inicio Sesión</h2>
        <div class="form-group fullname">
            <label for="reader">Usuario</label>
            <input type="text" id="reader" name="reader" placeholder="Nombre de usuario" required>
        </div>
        <div class="form-group password">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
            <div class="success-txt"></div>
            <div class="error-txt"></div>
        </div>
        <div class="form-group submit-btn">
            <a class="btn reg" style="color:azure" href="./meeting">Atrás</a>
            <input type="submit" value="Ingresar" class="btn enviar">
        </div>
    </form>
    <script src="../js/alrtsession.js"></script>
    <script>
        alertSession("../database/kwere");
    </script>
<?php
    }else{
?>
    <form action="../database/reset" class="boot-form" method="POST">
        <h2 style="margin:0">Restablecer su contraseña</h2>
        <div class="form-group fullname">
            <label for="email">Dirección de correo electrónico</label>
            <input type="text" id="email" name="email" placeholder="Correo electrónico" required>
            <div class="success-txt"></div>
            <div class="error-txt"></div>
            <div class="warning-txt">Ingrese su dirección de correo electrónico que utilizó para registrarse. Le enviaremos un correo electrónico con un enlace para restablecer su contraseña.</div>
        </div>
        <div class="form-group submit-btn">
            <a class="btn reg" style="color:azure" href="./login">Regresar al login</a>
            <input type="submit" value="Enviar" class="btn enviar">
        </div>
    </form>
    <script src="../js/reset.js"></script>
<?php
    }
?>
</body>
</html>
