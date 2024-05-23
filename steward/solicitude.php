<?php
    require_once('./microhead.php');
    require_once('../database/conexion.php');
    $id=!empty($_REQUEST['id'])?$_REQUEST['id']:'';
?>
        <style>
            @media (max-width: 400px) {
                .home-section{
                    left: 0;
                }
            }
            form .submit-btn .autocom-box{
                width: 300px;
            }
            .table-striped tbody tr td:nth-child(6){
                text-align: center;
            }
        </style>
        <div class="home-content">
            <div class="container" style="min-width:409.141px">
                <?php $solicitude=mysqli_query($con,"SELECT solic_cod_solic,solic_prj_solic,solic_ubi_solic,solic_mot_solic,solic_rev_solic,solic_fil_solic FROM acasolic WHERE solic_cod_solic=$id");
                $solicitude=mysqli_fetch_assoc($solicitude);
                $rev=($solicitude['solic_rev_solic']==0)?"SIN REVISAR":"REVISADO";
                ?>
                <br>
                <article class="check-solic"><p><?=$rev;?></p>
                <div><i class="fa-solid fa-check" data-href="id=<?=$solicitude['solic_cod_solic'];?>&rev=1"></i>&nbsp;&nbsp;<i class="fa-solid fa-x" data-href="id=<?=$solicitude['solic_cod_solic'];?>&rev=0"></i></div></article>
                <br>
                <label>Titulo:</label>
                <input type="text" name="title" value="<?=$solicitude['solic_prj_solic'];?>" class="form-control" form="usrform" disabled><br>

                <label>Materia o ubicación en la que desea establecer:</label>
                <input type="text" name="ubication" value="<?=$solicitude['solic_ubi_solic'];?>" class="form-control" form="usrform" disabled><br>

                <label>Motivo o/y descripción:</label>
                <textarea name="reason" rows="4" class="form-control" form="usrform" disabled><?=$solicitude['solic_mot_solic'];?></textarea><br>
                <?php $archivo=$solicitude['solic_fil_solic'];
                if(file_exists($archivo)){?>
                <div class="panel panel-info"><div class="panel-heading">Ficheros en este ítem: </div>
                <table class="table panel-body"><tr><th id="t1" class="standard">Fichero </th>
                    <th id="t2" class="standard">Descripción</th>
                    <?php
                    $tamanio=filesize($archivo)/1000;
                    $tamanio=($tamanio<1024)?number_format($tamanio,2)." KB":number_format($tamanio*1000/(1024*1024),2)." MB";
                    ?>
                    <th id="t3" class="standard">Tamaño</th>
                    <th id="t4" class="standard">Formato </th><th>&nbsp;</th></tr>
                    <tr><td headers="t1" class="standard"><a target="_blank" href="<?=$solicitude['solic_fil_solic'];?>"><?=str_replace('../files/temp/','',$solicitude['solic_fil_solic']);?></a></td><td headers="t2" class="standard">PROYECTO DE GRADO A TEXTO COMPLETO</td><td headers="t3" class="standard"><?=str_replace(".",',',$tamanio);?></td><td headers="t4" class="standard">Adobe PDF</td><td class="standard" align="center"><a class="btn btn-primary" target="_blank" href="<?=$solicitude['solic_fil_solic'];?>">Visualizar/Abrir </a></td></tr>
                </table>
                <?php }?>
                <br>
                <a name="cancel" href="./list?solic=edit">Regresar</a><br>
            </div>
        </div>
        <script src="../js/coders.js"></script>
        <script src="../js/check.js"></script>
        <script src="../js/ajax.js"></script>
        <script>
            autocom(document.querySelector("form > .submit-btn > div > #listuser"),"../api");
        </script>
    </body>
</html>
