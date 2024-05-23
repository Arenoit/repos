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
            background-image: url("https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Biblioteca-montserrat.jpg/1200px-Biblioteca-montserrat.jpg");
            background-size: cover;
        }
    </style>
    <form action="../database/kwere" class="boot-form" method="POST">
        <h2>Inicio Sesión</h2>
        <div class="form-group fullname">
            <label for="reader">Usuario</label>
            <input type="text" id="reader" name="reader" placeholder="nombre de usuario" required>
        </div>
        <div class="form-group password" style="margin-bottom:0">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="contraseña" required>
            <i id="pass-toggle-btn" class="fa-solid fa-eye"></i>
            <div class="success-txt"></div>
            <div class="error-txt"></div>
            <a class="btn reset" style="color:azure" href="./identifier?reset=password">¿Olvidaste la contraseña?</a>
        </div>
        <div class="form-group submit-btn">
            <a class="btn reg" style="color:azure" href="./signin">Crear Cuenta</a>
            <input type="submit" value="Ingresar" class="btn enviar">
        </div>
    </form>
</body>
<script src="../js/ajax.js"></script>
<script>
    autocom(document.querySelector("nav > .search-box > #seeker"),"../api","click");
</script>
<script src="../js/alrtsession.js"></script>
<script>
    alertSession("../database/kwere");
</script>
</html>
