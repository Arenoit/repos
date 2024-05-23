<?php
    require_once('./microhead.php');
    require_once('../database/list.php');
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
            .table-striped tbody tr td:nth-child(5){
                text-align: center;
            }
            .table-striped tbody tr td:nth-child(6){
                text-align: center;
            }
        </style>
        <div class="home-content">
            <div class="container" style="min-width:409.141px">
                <br>
                <form action="./list" method="POST">
                    <input class="btn btn-success" type="submit" value="Lista de usuarios">
                    <a class="btn btn-request" href="./list?solic=edit">Solicitudes</a>
                </form>
                <br>
                <?php if(empty($_REQUEST['solic'])){?>
                    <div style="display:flex;justify-content:space-between;flex-wrap:wrap">
                        <form action="./list" method="GET" id="usrform" style="margin-right:40px">
                            <h2>Usuarios</h2>
                            <div class="submit-btn" style="display: flex;">
                                <label>Buscar:&nbsp;</label>
                                <div><input autocomplete="off" type="text" id="listuser" name="listuser" value="<?=$listuser?>" class="form-control" form="usrform"></div><input type="submit" class="btn btn-save" form="usrform">
                            </div>
                        </form>
                        <label>Status
                            <select name="status" aria-controls="tablaUsuarios" class="custom-select custom-select-sm form-control form-control-sm" form="usrform">
                                <option value="">--Todo--</option>
                                <option value="activos">activos</option>
                                <option value="inactivos">inactivos</option>
                            </select>tickets
                        </label>
                        <label>Tipo
                            <select name="type" aria-controls="tablaUsuarios" class="custom-select custom-select-sm form-control form-control-sm" form="usrform">
                                <option value="">--Todo--</option>
                                <option value="admin">admin</option>
                                <option value="normal">normal</option>
                            </select>tickets
                        </label>
                        <div class="dataTables_length" id="tablaUsuarios_length">
                            <label>ver
                                <select name="limit" aria-controls="tablaUsuarios" class="custom-select custom-select-sm form-control form-control-sm" form="usrform">
                                    <option value="5">5</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>tickets
                            </label>
                        </div>
                    </div>
                    <!-- JavaScript for Searcher -->
                    <script>
                        var compensator=document.querySelector('#tablaUsuarios_length > label > select[name=limit]');
                        compensator.value=<?=$limit?>;
                        compensator.addEventListener("change", () => {
                            var valor=compensator.value;
                            if(valor!=<?=$limit?>)document.querySelector('#usrform > div > input').click();
                        });
                        var filter1=document.querySelector('label > select[name=status]');
                        filter1.value="<?=$status?>";
                        filter1.addEventListener("change", () => {
                            var valor=filter1.value;
                            if(valor!="<?=$status?>")document.querySelector('#usrform > div > input').click();
                        });
                        var filter2=document.querySelector('label > select[name=type]');
                        filter2.value="<?=$type?>";
                        filter2.addEventListener("change", () => {
                            var valor=filter2.value;
                            if(valor!="<?=$type?>")document.querySelector('#usrform > div > input').click();
                        });
                    </script>
                    <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                        <thead class="sorting">
                            <tr role="row"><th tabindex="0" style="width: 107px;height:30px">Fecha</th>
                            <th rowspan="1" colspan="1">Usuario</th>
                            <th rowspan="1" colspan="1">Email</th>
                            <th rowspan="1" colspan="1">Status</th>
                            <th rowspan="1" colspan="1">Tipo</th>
                            <th rowspan="1" colspan="1">Opciones</th>
                        </thead>
                        <tbody>
                        <?php
                            $registros=0;
                            while($users=$resultOptions->fetch_assoc()){
                        ?>
                            <tr>
                                <?php $foo=date("Y-m-d", strtotime($users['users_fec_users']))?>
                                <td><?=stickout_phrase((strpos($foo,'-0001-11-30') !== false)?"":date("Y-m-d", strtotime($libreria['projc_fec_projc'])),$listuser);?></td>
                                <td>
                                    <?=stickout_phrase($users['users_usr_users'],$listuser);?>
                                </td>
                                <td><?=stickout_phrase($users['users_eml_users'],$listuser);?></td>
                                <td><?=($users['users_sts_users']==1)?"activo":"inactivo";?></td>
                                <td><?=($users['users_typ_users']==0)?"admin":"normal";?></td>
                                <td><a class="btn btn-success" href="./user?id=<?=$users['users_cod_users'];?>"><i class="fa-solid fa-clipboard-list"></i></a></td>
                            </tr>
                        <?php
                            $registros++;
                            }
                        ?>
                        </tbody>
                    </table>
                <?php }else{ ?>
                    <div style="display:flex;justify-content:space-between;flex-wrap:wrap">
                        <form action="./list" method="GET" id="usrform" style="margin-right:40px">
                            <h2>Solicitudes</h2>
                            <div class="submit-btn" style="display: flex;">
                                <label>Buscar:&nbsp;</label>
                                <div><input autocomplete="off" type="text" id="listuser" name="listuser" value="<?=$listuser?>" class="form-control" form="usrform"></div><input type="submit" class="btn btn-save" form="usrform"><input type="hidden" name="solic" value="edit">
                            </div>
                        </form>
                        <div class="dataTables_length" id="tablaUsuarios_length">
                            <label>ver
                                <select name="limit" aria-controls="tablaUsuarios" class="custom-select custom-select-sm form-control form-control-sm" form="usrform">
                                    <option value="5">5</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>tickets
                            </label>
                        </div>
                    </div>
                    <!-- JavaScript for Searcher -->
                    <script>
                        var compensator=document.querySelector('#tablaUsuarios_length > label > select[name=limit]');
                        compensator.value=<?=$limit?>;
                        compensator.addEventListener("change", () => {
                            var valor=compensator.value;
                            if(valor!=<?=$limit?>)document.querySelector('#usrform > div > input').click();
                        });
                    </script>
                    <br>
                    <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                        <thead class="sorting">
                        <tr role="row"><th tabindex="0" style="width:66px;height:30px">Índice</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width:250px;">Titulo</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width:185px;">Materia/ubicación</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width:80px;">Revisado</th>
                        <th tabindex="0" rowspan="1" colspan="1" style="width:113px;">Acciones</th>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            foreach($resultOptions as $edits){
                                $rev=($edits['solic_rev_solic']==0)?"SIN REVISAR":"REVISADO";
                                ?>
                                <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$edits['solic_prj_solic'];?></td>
                                    <td><?=$edits['solic_ubi_solic'];?></td>
                                    <td><?=$rev;?></td>
                                    <td>
                                        <a class="btn btn-success" href="./solicitude?id=<?=$edits['solic_cod_solic'];?>"><i class="fa-solid fa-clipboard-list"></i></a>
                                        <a class='btn btn-danger' name="delete" tabindex="<?=$edits['solic_cod_solic'];?>" direction='id=<?=$edits['solic_cod_solic'];?>' href='#'><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php 
                            $i++;}$registros=$i-1?>
                        </tbody>
                    </table>
                <?php }?>
                <div class="dataTables_info">Viendo <?=$registros;?> de <?=$totalregistros;?> resultados</div>
                <div class="dataTables_paginate" style="display: flex;justify-content: center;">
                    <ul class="pagination" id="pagsearch" style="display: flex;flex-wrap: wrap;">
                    <?php
                        $ant=$pagina-1;
                        if($pagina > "1" ){
                            echo '<li class="page-item previous""><a value="'.$ant.'" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>';
                        }else{
                            echo '<li class="page-item previous disabled""><a href="#" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>';
                        }
                        $ancho=5;
                        $paginator=$pagina-ceil($ancho/2)+1;
                        $paginator=($paginator<0||$paginator==0)?1:$paginator;
                        //for auxiliar paginator 
                        $aux=0;
                        for($i=$paginas-ceil($ancho/2)+1;$i<$pagina;$i++){
                            if($pagina>$paginas-ceil($ancho/2)+1)$aux++;
                        }
                        if($pagina>$ancho-2)echo '<li class="page-item"><a class="page-link" value="1">1</a></li>
                        <li class="page-item span-page disabled"><a href="#" data-dt-idx="0" tabindex="0" class="page-link">...</a></li>';
                        //for paginator previous
                        for ($i=$paginator-$aux; $i < $pagina; $i++) {
                            if($i<=$paginas&&$i>0)echo '<li class="page-item"><a class="page-link" value="'.$i.'">'.$i.'</a></li>';
                        }
                        //for paginator later
                        for ($i=$pagina; $i < $ancho+$paginator; $i++) {
                            $active=($pagina==$i)?'active':'';
                            if($i<=$paginas)echo '<li class="page-item '.$active.'"><a class="page-link" value="'.$i.'">'.$i.'</a></li>';
                        }$sig=$pagina+1;
                        if($pagina<$paginas-ceil($ancho/2)+1)echo '<li class="page-item span-page disabled"><a href="#" data-dt-idx="0" tabindex="0" class="page-link">...</a></li>
                        <li class="page-item"><a class="page-link" value="'.$paginas.'">'.$paginas.'</a></li>';
                        if ($pagina<$paginas && $paginas>1)echo '<li class="page-item next""><a value="'.$sig.'" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li></li>';
                        else echo '<li class="page-item next disabled""><a href="#" data-dt-idx="8" tabindex="0" class="page-link">Next</a></li>';
                    ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Pagination JavaScript -->
        <script>
            var filterSearcher=document.getElementById('usrform');
            var pagination=document.querySelectorAll('#pagsearch li a');
                pagination.forEach(plist=>{
                    plist.addEventListener('click',(e)=>{
                        e.preventDefault();
                        var pages=document.createElement('input');
                        pages.setAttribute('value',plist.getAttribute('value'));
                        pages.setAttribute('name','nume');
                        pages.setAttribute('style','display:none');
                        filterSearcher.prepend(pages);
                        document.querySelector('#usrform > div > input').click();
                    })
                });
        </script>
        <script src="../js/modal.js"></script>
        <script>
            deleteFile("../database/deletesolici","yes");
        </script>
        <script src="../js/coders.js"></script>
        <script src="../js/ajax.js"></script>
        <script>
            autocom(document.querySelector("form > .submit-btn > div > #listuser"),"../api","click");
        </script>
    </body>
</html>
