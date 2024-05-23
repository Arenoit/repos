<?php
require_once('../database/searcher.php');
require_once('./microhead.php');
?>
        <br><br><br>
        <banner>
            <div>
                <img src="../images/banner-istvl.jpg" alt="">
            </div>
        </banner>
        <?php
            if(!isset($_REQUEST['assortment'])){
        ?>
        <style>
            .table-striped .sorting{
                background: linear-gradient(to right, #0575E6, #00F260);
                color:white;
            }
            .form-control{
                border-radius: 5px;
                border: 1px solid #a6a6a6;
            }
        </style>
        <div class="container">
            <div style="display:flex;justify-content:space-between;flex-wrap:wrap">
                <div>
                    <form action="./search" method="GET" id="usrform">
                        <h2>Búsqueda</h2>
                        <div class="submit-btn" style="display: flex;">
                            <label>Buscar:&nbsp;</label>
                            <div><input autocomplete="off" type="text" id="seeker" name="seeker" value="<?=$seeker?>" class="form-control" form="usrform"></div><input type="submit" class="btn btn-save" form="usrform">
                        </div>
                    </form>
                    <form action="./search" method="GET" id="filform">
                        <?php
                            if($selecciones=='Sin filtros'){
                                $career='';
                                $autor='';
                                $rangedate='';
                            }
                        ?>
                        <?php if(!empty($career)){?><input type="text" id="item1" name="item1" autocomplete="off" value="<?=$_REQUEST['item1']?>" style="display:none" form="filform"><?php }?>
                        <?php if(!empty($autor)){?><input type="text" id="item2" name="item2" autocomplete="off" value="<?=$_REQUEST['item2']?>" style="display:none" form="filform"><?php }?>
                        <?php if(!empty($rangedate)){?><input type="text" id="item3" name="item3" autocomplete="off" value="<?=$_REQUEST['item3']?>" style="display:none" form="filform"><?php }?>
                        <label>Filtros:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div style="display:flex;padding-bottom:9px">
                                <select name="selecciones" id="selecciones" class="custom-select form-control form-control-sm" style="width:6rem">
                                    <?php
                                    $items=['Sin filtros','Carrera','Autor','Fecha'];
                                    //if(!empty($selecciones))echo "<option value='$selecciones'>$selecciones</option>";
                                    for ($i=0; $i < 4; $i++) { 
                                        //if($items[$i]!=$selecciones) {
                                            echo "<option value='$items[$i]'>$items[$i]</option>";
                                        //}
                                    }
                                    ?>
                                </select>
                                <div style="display:flex;">
                                    <button type="submit">Agregar</button>
                                </div>
                            </div>
                            <a class="btn-save" href="./search?assortment">Surtido</a>
                        </label>
                    </form>
                </div>
                
                <div>
                    <div style="max-width:300">
                        <?php if(!empty($career)){?>
                            <div style="display: flex">
                                <label>Filtro:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="selecciones" id="selecciones" class="custom-select form-control form-control-sm" style="width:6rem">
                                        <option value="item">Carrera</option>
                                    </select>
                                </label>
                                <label>&nbsp;
                                    <div style="display: flex">
                                    <?php
                                        echo "<select name='item1' id='item1' class='form-control' form='usrform'>";
                                            if(!empty($career)){
                                                echo "<option value='$career'>$career</option>";
                                            }else{
                                                echo "<option value=''>--Eligir opciones--</option>";
                                            }
                                            foreach($updateCareers as $options){
                                                if($options['carer_nom_carer']!=$career){
                                            echo "<option value='$options[carer_nom_carer]'>$options[carer_nom_carer]</option>";
                                                }
                                            }
                                        echo "</select><input type='submit' class='btn-filter' value='Filtrar' form='usrform'>
                                        <input type='submit' class='btn-dl-filter' value='X' id='deleteCareer' style='padding-left:10px;padding-right:10px' form='usrform'>";
                                    ?>
                                    </div>
                                </label>
                            </div>
                        <?php }?>
                        <?php if(!empty($autor)){?>
                            <div style="display: flex">
                                <label>Filtro:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="selecciones" id="selecciones" class="custom-select form-control form-control-sm" style="width:6rem">
                                        <option value="item">Autor</option>
                                    </select>
                                </label>
                                <label>&nbsp;
                                    <div>
                                        <div style="display: flex">
                                            <input type="text" id="item2" name="item2" value="<?=$autor?>" autocomplete="off" class="form-control" form="usrform">
                                            <input type="submit" class='btn-filter' value="Filtrar" form="usrform">
                                            <input type='submit' class='btn-dl-filter' value='X' id='deleteAutor' style='padding-left:10px;padding-right:10px' form='usrform'>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        <?php }?>
                        <?php if(!empty($rangedate)){?>
                            <div style="display: flex">
                                <label>Filtro:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="selecciones" id="selecciones" class="custom-select form-control form-control-sm" style="width:6rem">
                                        <option value="item">Fecha</option>
                                    </select>
                                </label>
                                <label>&nbsp;
                                    <div>
                                        <div style="display: flex">
                                            <input type="text" id="item3" name="item3" value="<?=$rangedate?>" autocomplete="off" class="form-control" form="usrform">
                                            <input type="submit" class='btn-filter' value="Filtrar" form="usrform">
                                            <input type='submit' class='btn-dl-filter' value='X' id='deleteDate' style='padding-left:10px;padding-right:10px' form='usrform'>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        <?php }?>
                    </div>
                </div>
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
            <?php
                $nomCareer=array();$additionCareers=0;
                foreach($updateCareers as $listCareer){
                //Object JSON and it is not traverse in the same way as an array
                $iteca[]= array(
                    explode(",",$listCareer['carer_nom_carer']),
                );
                array_push($nomCareer,$iteca);
                $additionCareers++;
                }
            ?>
            <!-- JavaScript for Searcher -->
            <script>
                var filterSearcher=document.getElementById('usrform'),
                deleteItem1=document.getElementById('deleteCareer');
                deleteItem1?.addEventListener("click", () => {
                    filterSearcher.item1.value='';
                });
                var deleteItem2=document.getElementById('deleteAutor');
                deleteItem2?.addEventListener("click", () => {
                    filterSearcher.item2.value='';
                });
                var deleteItem3=document.getElementById('deleteDate');
                deleteItem3?.addEventListener("click", () => {
                    filterSearcher.item3.value='';
                });
                var compensator=document.querySelector('#tablaUsuarios_length > label > select');
                compensator.value=<?=$limit?>;
                compensator.addEventListener("change", () => {
                    var valor=compensator.value;
                    if(valor!=<?=$limit?>)document.querySelector('#usrform > div > input').click();
                });
                var selections=document.querySelector('#selecciones');
                selections.addEventListener("change", () => {
                    var inputFilter=document.createElement('input');
                    inputFilter.setAttribute('id','inputFilter');
                    inputFilter.setAttribute('class','form-control');
                    var selectFilter=document.createElement('select');
                    var valor=selections.value;
                        if(valor!="Sin filtros"){
                            if(valor=="Carrera"){
                                selectFilter.setAttribute('name','item1');
                                selectFilter.setAttribute('id','item1');
                                <?php for ($i=0; $i < $additionCareers; $i++) { 
                                ?>
                                    var dataset=JSON.parse('<?php echo json_encode($nomCareer[$i]); ?>');
                                <?php
                                }?>
                                for (let index = 0; index < <?=$additionCareers?>; index++) {
                                    var option=document.createElement('option');
                                    option.value=dataset[index];
                                    option.text=dataset[index];
                                    selectFilter.appendChild(option);
                                }
                            }
                            if(valor=="Autor"){
                                inputFilter.setAttribute('name','item2');
                                inputFilter.setAttribute('id','item2');
                                inputFilter.setAttribute('autocomplete','off');
                            }
                            if(valor=="Fecha"){
                                inputFilter.setAttribute('name','item3');
                                inputFilter.setAttribute('id','item3');
                                inputFilter.setAttribute('autocomplete','off');
                            }
                            document.querySelectorAll('#filform > label > div > div > #item1').forEach(select => select.remove());
                            if(valor=="Carrera")document.querySelector('#filform > label > div > div > button').before(selectFilter);
                            document.querySelectorAll('#filform > label > div > div > input').forEach(input => input.remove());
                            if(valor!="Carrera")document.querySelector('#filform > label > div > div > button').before(inputFilter);
                        }else {
                            document.querySelectorAll('#filform > label > div > div > #item1').forEach(select => select.remove());
                            document.querySelectorAll('#filform > label > div > div > input').forEach(input => input.remove());
                        }
                });
            </script>
            <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                <thead class="sorting" style="background: #251b1b;color: white;">
                    <tr role="row"><th tabindex="0" style="width: 107px;height:30px">Fecha de publicacion</th>
                    <th tabindex="0" style="width: 321px;">Titulo</th>
                    <th tabindex="0" style="width: 172px;">Autor(es)</th>
                    <th tabindex="0" style="width: 86px;">Descargar</th>
                </thead>
                <tbody>
                <?php
                    $registros=0;
                    foreach($resultOptions as $libreria){
                ?>
                        <tr>
                            <?php $foo=date("Y-m-d", strtotime($libreria['projc_fec_projc']))?>
                            <td><?=stickout_phrase((strpos($foo,'-0001-11-30') !== false)?"":date("Y-m-d", strtotime($libreria['projc_fec_projc'])),$seeker);?></td>
                            <td>
                                <a href='handler?id=<?=$libreria['projc_cod_projc']?>'><?=stickout_phrase($libreria['projc_tit_projc'],$seeker);?></a>
                                <br>
                            </td>
                            <td><?=stickout_phrase($libreria['autor_nom_autor'],$seeker);?></td>
                            <td class="download-post download-posts">
                                <?php
                                $archivo=$libreria['projc_fil_projc'];
                                echo (file_exists($archivo))?"<a target='_blank' href='$archivo'><i class='fa-solid fa-eye'></i></a> <a href='$archivo' download='".str_replace('../files/','',$archivo)."'><i class='fa-solid fa-circle-down'></i></a>":"———";
                                ?>
                            </td>
                        </tr>
                <?php
                    $registros++;
                    }
                ?>
                </tbody>
            </table>
            <div class="dataTables_info">Viendo <?=$registros;?> de <?=$totalregistros;?> resultados</div>
            <div class="dataTables_paginate" style="display: flex;justify-content: center;">
                <ul class="pagination" id="pagsearch" style="display: flex;flex-wrap: wrap;">
                <?php
                    paginator($pagina,$paginas);
                ?>
                </ul>
            </div>
        </div>
        <br><br><br><br>
        <script>var pagination=document.querySelectorAll('#pagsearch li a');
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
        <?php
        }else{//Searcher SURTIDO/ASSORMENT
        ?>
        <div class="container">
            <div class="panel-primary browser">
                <div class="panel-heading">Buscar por:</div>
                <div class="panel-body">
                    <form action="./search">
                        <input type="text" name="assortment" style="display:none">
                        <input type="submit" name="browse" value="Colección">
                        <input type="submit" name="browse" value="Autor">
                        <input type="submit" name="browse" value="Título">
                    </form>
                </div>
                <br>
                <?php
                if((empty($_REQUEST['browse'])||$_REQUEST['browse']=="Colección")&&!isset($_REQUEST['collec'])){
                    echo '<div class="collection-projects">';
                    $coleccion="";
                    foreach($resultOptions as $colecciones){
                        if($colecciones['carer_nom_carer']!=$coleccion)echo "<h3>$colecciones[carer_nom_carer]</h3>";
                        $coleccion=$colecciones['carer_nom_carer'];
                ?>
                    <ul>
                        <li><a href="./search?assortment&collec=<?=$colecciones['colec_nom_colec'];?>"><?=$colecciones['colec_nom_colec'];?></a> <span><?=$colecciones['reg'];?></span></li>
                    </ul>
                <?php
                    }
                    echo '</div>';
                }
                if($_REQUEST['browse']=="Autor"){
                    $registros=0;
                    echo "<div class='document-center' style='flex-wrap:wrap'>
                        <a class='classify-item' href='./search?assortment&browse=Autor&seeker=&nume=$pagina'>0-9</a>";
                        for($i=65; $i<=90; $i++) {  
                            $letter = chr($i);
                            echo "<a class='classify-item' href='./search?assortment&browse=Autor&seeker=$letter&nume=$pagina'>$letter</a>";  
                        } 
                    echo "</div><br>";
                    echo '<div class="document-center">
                            <div class="panel-primary counter">
                                <div class="panel-heading">Mostrando resultados: Autor</div>
                                    <div class="panel-body">';
                    foreach($resultOptions as $autor){
                ?>
                    <ul>
                        <a href="./search?item2=<?=$autor['autor_nom_autor'];?>"><?=$autor['autor_nom_autor'];?></a> <span><?=$autor['reg'];?></span>
                    </ul>
                <?php
                            $registros++;
                        }
                        echo '</div>
                            </div>
                        </div>';
                        echo "<div class='dataTables_info' style='text-align:center'>Viendo $registros de $totalregistros resultados</div>
                                <div class='dataTables_paginate' style='display: flex;justify-content:center;'>
                                    <ul class='pagination' id='pagsearch' style='display: flex;flex-wrap: wrap;'>";
                        paginator($pagina,$paginas);
                        echo '</ul>
                        </div>';
                    }
                    if($_REQUEST['browse']=="Título"){
                        $registros=0;
                        echo "<div class='document-center' style='flex-wrap:wrap'>
                            <a class='classify-item' href='./search?assortment&browse=Título&limit=$limit&seeker=&nume=$pagina'>0-9</a>";
                            for($i=65; $i<=90; $i++) {  
                                $letter = chr($i);
                                echo "<a class='classify-item' href='./search?assortment&browse=Título&limit=$limit&seeker=$letter&nume=$pagina'>$letter</a>";  
                            } 
                        echo "</div><br>";
                    ?>
                        <div style="display:flex;justify-content: space-between;flex-wrap: wrap;">
                            <form action="./search" method="GET" id="usrform">
                                <div class="submit-btn" style="display:flex;">
                                    <input type="text" name="seeker" value="<?=$seeker;?>" style="display:none">
                                    <input type="text" name="browse" value="<?=$_REQUEST['browse'];?>" style="display:none">
                                    <input type="text" name="assortment" style="display:none">
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
                        <script>
                            var compensator=document.querySelector('#tablaUsuarios_length > label > select');
                            compensator.value=<?=$limit?>;
                            compensator.addEventListener("change", () => {
                                var valor=compensator.value;
                                if(valor!=<?=$limit?>)document.querySelector('#usrform').submit();
                            });
                        </script>
                        <br>
                        <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                        <thead class="sorting" style="background: #251b1b;color: white;">
                            <tr role="row"><th tabindex="0" style="width: 107px;height:30px">Fecha de publicacion</th>
                            <th tabindex="0" style="width: 321px;">Titulo</th>
                            <th tabindex="0" style="width: 172px;">Autor(es)</th>
                            <th tabindex="0" style="width: 86px;">Descargar</th>
                        </thead>
                        <tbody>
                        <?php
                            $registros=0;
                            foreach($resultOptions as $libreria){
                        ?>
                                <tr>
                                    <?php $foo=date("Y-m-d", strtotime($libreria['projc_fec_projc']))?>
                                    <td><?=stickout_phrase((strpos($foo,'-0001-11-30') !== false)?"":date("Y-m-d", strtotime($libreria['projc_fec_projc'])),$seeker);?></td>
                                    <td>
                                        <a href='handler?id=<?=$libreria['projc_cod_projc']?>'><?=stickout_phrase($libreria['projc_tit_projc'],$seeker);?></a>
                                        <br>
                                    </td>
                                    <td><?=stickout_phrase($libreria['autor_nom_autor'],$seeker);?></td>
                                    <td class="download-post download-posts">
                                        <?php
                                        $archivo=$libreria['projc_fil_projc'];
                                        echo (file_exists($archivo))?"<a target='_blank' href='$archivo'><i class='fa-solid fa-eye'></i></a> <a href='$archivo' download='".str_replace('../files/','',$archivo)."'><i class='fa-solid fa-circle-down'></i></a>":"———";
                                        ?>
                                    </td>
                                </tr>
                        <?php
                            $registros++;
                            }
                        ?>
                        </tbody>
                        </table>
                        <div class="dataTables_info">Viendo <?=$registros;?> de <?=$totalregistros;?> resultados</div>
                        <div class="dataTables_paginate" style="display: flex;justify-content: center;">
                            <ul class="pagination" id="pagsearch" style="display: flex;flex-wrap: wrap;">
                            <?php
                                paginator($pagina,$paginas);
                            ?>
                            </ul>
                        </div>
                        <script>var pagination=document.querySelectorAll('#pagsearch li a');
                        pagination.forEach(plist=>{
                            plist.addEventListener('click',(e)=>{
                                e.preventDefault();
                                var pages=document.createElement('input');
                                pages.setAttribute('value',plist.getAttribute('value'));
                                pages.setAttribute('name','nume');
                                pages.setAttribute('style','display:none');
                                document.getElementById('usrform').prepend(pages);
                                document.querySelector("#usrform").submit();
                            })
                        });
                        </script>
                    <?php
                    }


                    if(isset($_REQUEST['collec'])){
                ?>
                    <div style="display:flex;justify-content: space-between;flex-wrap: wrap;">
                        <form action="./search" method="GET" id="usrform">
                            <h2>Búsqueda</h2>
                            <div class="submit-btn" style="display:flex;">
                                <label>Buscar:&nbsp;</label>
                                <div><input autocomplete="off" type="text" id="seeker" name="seeker" value="<?=$seeker?>" class="form-control" form="usrform"></div><input type="submit" class="btn btn-save" form="usrform">
                                <input type="text" name="collec" value="<?=$_REQUEST['collec'];?>" style="display:none">
                                <input type="text" name="assortment" style="display:none">
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
                    <script>
                        var compensator=document.querySelector('#tablaUsuarios_length > label > select');
                        compensator.value=<?=$limit?>;
                        compensator.addEventListener("change", () => {
                            var valor=compensator.value;
                            if(valor!=<?=$limit?>)document.querySelector('#usrform > div > input').click();
                        });
                    </script>
                    <br>
                    <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                    <thead class="sorting" style="background: #251b1b;color: white;">
                        <tr role="row"><th tabindex="0" style="width: 107px;height:30px">Fecha de publicacion</th>
                        <th tabindex="0" style="width: 321px;">Titulo</th>
                        <th tabindex="0" style="width: 172px;">Autor(es)</th>
                        <th tabindex="0" style="width: 86px;">Descargar</th>
                    </thead>
                    <tbody>
                    <?php
                        $registros=0;
                        foreach($resultOptions as $libreria){
                    ?>
                            <tr>
                                <?php $foo=date("Y-m-d", strtotime($libreria['projc_fec_projc']))?>
                                <td><?=stickout_phrase((strpos($foo,'-0001-11-30') !== false)?"":date("Y-m-d", strtotime($libreria['projc_fec_projc'])),$seeker);?></td>
                                <td>
                                    <a href='handler?id=<?=$libreria['projc_cod_projc']?>'><?=stickout_phrase($libreria['projc_tit_projc'],$seeker);?></a>
                                    <br>
                                </td>
                                <td><?=stickout_phrase($libreria['autor_nom_autor'],$seeker);?></td>
                                <td class="download-post download-posts">
                                    <?php
                                    $archivo=$libreria['projc_fil_projc'];
                                    echo (file_exists($archivo))?"<a target='_blank' href='$archivo'><i class='fa-solid fa-eye'></i></a> <a href='$archivo' download='".str_replace('../files/','',$archivo)."'><i class='fa-solid fa-circle-down'></i></a>":"———";
                                    ?>
                                </td>
                            </tr>
                    <?php
                        $registros++;
                        }
                    ?>
                    </tbody>
                </table>
                <div class="dataTables_info">Viendo <?=$registros;?> de <?=$totalregistros;?> resultados</div>
                <div class="dataTables_paginate" style="display: flex;justify-content: center;">
                    <ul class="pagination" id="pagsearch" style="display: flex;flex-wrap: wrap;">
                    <?php
                        paginator($pagina,$paginas);
                    ?>
                    </ul>
                </div>
                <script>var pagination=document.querySelectorAll('#pagsearch li a');
                pagination.forEach(plist=>{
                    plist.addEventListener('click',(e)=>{
                        e.preventDefault();
                        var pages=document.createElement('input');
                        pages.setAttribute('value',plist.getAttribute('value'));
                        pages.setAttribute('name','nume');
                        pages.setAttribute('style','display:none');
                        document.getElementById('usrform').prepend(pages);
                        document.querySelector('#usrform > div > input').click();
                    })
                });
                </script>
                <?php
                    }
                ?>
                <br><br><br><br>
            </div>
        </div>
        <?php
        }
        ?>
        <script src="../js/coders.js"></script>
        <script src="../js/ajax.js"></script>
        <script>
            autocom(document.querySelector("form > .submit-btn > div > #seeker"),"../api","click");
            document.querySelector("body").addEventListener("change",function () {
                autocom(document.querySelector("#filform > label > div > div > #item2"),"../api","click");
            });
            autocom(document.querySelector("label > div > div > #item2"),"../api","click");
        </script>
        <script src="../js/downloads.js"></script>
        <script>
            downloadViewer("../database/downloads");
        </script>
    </body>
</html>