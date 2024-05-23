<?php
require_once('./microhead.php');
?>
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
        background-image: url("https://img.freepik.com/foto-gratis/mujer-disfruta-leyendo-libros_329181-19648.jpg");
        background-size: cover;
    }
    .submit-btn input {
        float:none
    }
</style>
<form action="../database/register" class="boot-form" method="POST">
    <h2>Registrate</h2>
    <div class="form-group fullname">
        <label for="name">Nombre personal*</label>
        <input type="text" id="name" required name="name" autocomplete="off">
    </div>
    <div class="form-group fullname">
        <label for="email">Correo*</label>
        <input type="email" id="email" required name="email"  autocomplete="on">
    </div>
    <div class="form-group fullname">
        <label for="bootuser">Usuario de inicio*</label>
        <input type="text" id="bootuser" required name="bootuser" autocomplete="off">
    </div>
    <div class="form-group password">
        <label for="password">Contraseña*</label>
        <input type="password" id="password" required name="password">
        <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
        <div class="success-txt"></div>
        <div class="error-txt"></div>
    </div>
    <div class="form-group submit-btn">
        <input type="submit" value="Registrar" class="btn enviar">
        <a class="btn reg" style="color:azure" href="./login">atrás</a>
    </div>
</form>
<script src="../js/ajax.js"></script>
<script>
    autocom(document.querySelector("nav > .search-box > #seeker"),"../api","click");
</script>
<script src="../js/alrtsession.js"></script>
<script>
    alertSession("../database/register");
</script>