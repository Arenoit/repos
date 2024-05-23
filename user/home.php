<?php
    require_once('./microhead.php');
    require_once('../database/home.php');
    $voidCarers = [];$i=0;
?>
        <style>
            @media (max-width: 400px) {
                .home-section{
                    left: 89px;
                }
                .sidebar.active ~ .home-section .home-content{
                    width: 100%;
                    overflow-x: scroll;
                    margin-bottom: 30px;
                }
            }
            @media (max-width: 650px) {
                .home-section{
                    left: 80px;
                }
            }
        </style>
        <br><br><br>
        <banner>
            <div>
                <img src="../images/banner-istvl.jpg" alt="">
            </div>
        </banner>
        <br><br><br>
        <div class="container">
            <div class="document-center">
                <div class="col-md-10">
                    <div class="panel panel-primary">        
                    <div id="wrapper-carousel" class="panel-heading carousel slide">
                        <h3 style="display:table">Envíos recientes <a href="../rss?v=1.0"><img src="../images/rss-v1.svg" alt="RSS Feed" width="80" height="15"></a>&nbsp;<a href="../rss"  style="display:table-cell;vertical-align:middle"><img src="../images/Feed-icon.png" alt="RSS Feed" width="27" height="27"></a></h3>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                                <?php
                                    $contador=0;
                                    foreach($resultCarousel as $added){
                                    $contador++;
                                ?>
                                    <div style="padding-bottom: 50px; min-height: 200px;" class="item <?php if($contador==1)echo 'active';?>">
                                        <div style="padding-left: 80px; padding-right: 80px;"><?=$added['projc_tit_projc'];?>
                                        <a class="btn btn-success" href="handler?id=<?=$added['projc_cod_projc'];?>">Ver</a>
                                        <p style="text-align:justify" ><?php $palabras_arreglo = explode(" ", $added['projc_rem_projc']);
                                            $texto_resumido = implode(" ", array_slice($palabras_arreglo, 0,80));
                                            echo $texto_resumido;?></p>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                        </div>
                    
                            <!-- Controls -->
                        <a class="left carousel-control" data-slide="prev">
                            <span class="icon-prev"></span>
                        </a>
                        <a class="right carousel-control" data-slide="next">
                            <span class="icon-next"></span>
                        </a>
            
                        <ol class="carousel-indicators">
                        </ol>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-content">
            <div class="container" style="min-width:409.141px">
                <div class="document-center" style="flex-wrap:wrap;flex-direction:column">
                        <!--This carousel-container only exists so we can do the 
                    aspect ratio tricks in CSS-->
                    <br><br>
                    <div class="default-group">
                        <div class="separador">
                            <div class="title"><h2> Carreras</h2></div>
                            <div class="tacuerpo">
                                <table class="table">
                                    <tbody>
                                    <?php
                                    foreach($resultCareers as $career){
                                    ?>
                                        <tr><td scope="row"><a href="./search?item1=<?=$career['carer_nom_carer'];?>"><?=$career['carer_nom_carer'];?>&nbsp;</a><span><?=$career['contador'];?></span></td></tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="separador">
                        <div class="title"><h2>Autor</h2></div>
                        <div class="tacuerpo">
                            <table class="table">
                                <tbody>
                                    <?php
                                    foreach($resultAutors as $autor){
                                    ?>
                                        <tr><td scope="row"><a href="./search?item2=<?=$autor['autor_nom_autor'];?>"><?=$autor['autor_nom_autor'];?>&nbsp;</a><span><?=$autor['contador'];?></span></td></tr>
                                    <?php
                                    }
                                    if($sliceItem+7<$totalAutors){
                                    ?>
                                    <tr><td scope="row"><a href="./home?slideItem=<?=$slideItem+1;?>">next ></a></td></tr>
                                    <?php
                                        }else if($sliceItem!=0){
                                    ?>
                                    <tr><td scope="row"><a href="./home?slideItem=<?=$slideItem-1;?>">< previous</a></td></tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="separador">
                        <div class="title"><h2>fecha</h2></div>
                        <div class="tacuerpo">
                            <table class="table">
                                <tbody>
                                    <?php
                                    for ($i=0; $i < count($daterange); $i++) {
                                    ?>
                                        <tr><td scope="row"><a href="./search?item3=<?=$daterange[$i];?>" ><?=$daterange[$i];?></a><span><?=$countDates[$i];?></span></td></tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/carousel.js"></script>
        <script src="../js/coders.js"></script>
    </body>
</html>
