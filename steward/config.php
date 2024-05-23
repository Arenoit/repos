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
        <div class="home-content">
            <div class="container" style="min-width:409.141px">
                <div class="document-center" style="flex-wrap:wrap;flex-direction:column">
                        <!--This carousel-container only exists so we can do the 
                    aspect ratio tricks in CSS-->
                    <br><br>
                    <div class="default-group">
                        <div class="separador">
                            <div class="title"><h2> Carreras</h2><a class="btn btn-success" href="#"><i class="fa-solid fa-plus"></i></a></div>
                            <div class="tacuerpo">
                                <table class="table">
                                    <tbody>
                                    <?php
                                        foreach($resultCareers as $career){
                                        $voidCarers[$i]=$career['carer_nom_carer'];
                                    ?>
                                        <tr><td scope="row"><a href="./search?item1=<?=$career['carer_nom_carer'];?>"><?=$career['carer_nom_carer'];?>&nbsp;</a><span><?=$career['contador'];?></span>
                                            <a class="btn btn-success" name="edit" direction="<?=$career['carer_nom_carer'];?>" href="#"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-danger" name="delete" direction="<?=$career['carer_nom_carer'];?>" href="#"><i class="fa-solid fa-trash"></i></a>
                                        </td></tr>
                                    <?php
                                        $i++;
                                        }
                                        $allCarers="SELECT carer_nom_carer FROM acacarer WHERE carer_nom_carer!='$voidCarers[0]'";
                                        for ($i=1; $i < count($voidCarers); $i++) { 
                                            $allCarers.=" AND carer_nom_carer!='$voidCarers[$i]'";
                                        }
                                        $allCarers = mysqli_query($con,$allCarers);
                                        foreach($allCarers as $voidcarer){
                                    ?>
                                        <tr><td scope="row"><a href="./search?item1=<?=$voidcarer['carer_nom_carer'];?>"><?=$voidcarer['carer_nom_carer'];?>&nbsp;</a><span>0</span>
                                            <a class="btn btn-success" name="edit" direction="<?=$voidcarer['carer_nom_carer'];?>" href="#"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-danger" name="delete" direction="<?=$voidcarer['carer_nom_carer'];?>" href="#"><i class="fa-solid fa-trash"></i></a>
                                        </td></tr>
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
                                    <tr><td scope="row"><a href="./config?slideItem=<?=$slideItem+1;?>">next ></a></td></tr>
                                    <?php
                                        }else if($sliceItem!=0){
                                    ?>
                                    <tr><td scope="row"><a href="./config?slideItem=<?=$slideItem-1;?>">< previous</a></td></tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="separador">
                        <div class="title"><h2>fecha</h2><a class="btn btn-success" href="#"><i class="fa-solid fa-plus"></i></a></div>
                        <div class="tacuerpo">
                            <table class="table">
                                <tbody>
                                    <?php
                                    for ($i=0; $i < count($daterange); $i++) {
                                    ?>
                                        <tr><td scope="row"><a href="./search?item3=<?=$daterange[$i];?>" ><?=$daterange[$i];?></a><span><?=$countDates[$i];?></span>
                                            <a class="btn btn-success" name="edit" direction="<?=$daterange[$i];?>" href="#"><i class="fa-solid fa-pencil"></i></a>
                                            <a class="btn btn-danger" name="delete" direction="<?=$daterange[$i];?>" href="#"><i class="fa-solid fa-trash"></i></a>
                                        </td></tr>
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
        <script src="../js/config.js"></script>
        <script src="../js/coders.js"></script>
    </body>
</html>
