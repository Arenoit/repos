<?php
    require_once('./microhead.php');
    $year=!empty($_REQUEST['year'])?str_replace("'",'',$_REQUEST['year']):"";
    $month=!empty($_REQUEST['month'])?str_replace("'",'',$_REQUEST['month']):"";
    $_SESSION['year']=$year;$_SESSION['month']=$month;
    $espace=!empty($year&&$month)?" AND ":" ";$where=!empty($year||$month)?"WHERE":"";
    $item1=(!empty($month))?"MONTH(posts_fec_posts)=$month":"";$item2=(!empty($year))?"YEAR(posts_fec_posts)=$year":"";
    
    $graph = mysqli_query($con,"SELECT car.carer_nom_carer,COUNT(car.carer_nom_carer) stat FROM acacolec erv JOIN acaprojc prj ON erv.colec_cod_colec=prj.projc_cod_colec JOIN acacarer car ON car.carer_cod_carer=erv.colec_cod_carer JOIN acaposts vist ON vist.posts_file_down=prj.projc_cod_projc $where $item1 $espace $item2 GROUP BY car.carer_nom_carer ORDER BY stat ASC LIMIT 5");
    $suma_total = 0;$percentageGraph=[];$nameGraph=[];$percentage=[];$i=0;
    foreach($graph as $piegraph){
        $percentageGraph[$i]=$piegraph['stat'];
        $nameGraph[$i]=$piegraph['carer_nom_carer'];
        $suma_total += $piegraph['stat'];
        $i++;
    }
    for ($i=0; $i < count($nameGraph); $i++) { 
        $percentage[$i]=number_format($percentageGraph[$i]/$suma_total*100,2);
    }
    $dates = mysqli_query($con,"SELECT YEAR(posts_fec_posts) years,MONTH(posts_fec_posts) months,COUNT(posts_fec_posts) stat FROM acaposts WHERE posts_file_down=0 GROUP BY months ORDER BY MOD(MONTH(posts_fec_posts) - MONTH(NOW()) + 12, 12) LIMIT 5");
    $chart = mysqli_query($con,"SELECT YEAR(posts_fec_posts) years,MONTH(posts_fec_posts) months,COUNT(posts_fec_posts) stat FROM acaposts WHERE posts_file_down=0".(!empty($item1||$item2)?" AND ":" ")."$item1 $espace $item2 GROUP BY months ORDER BY MOD(MONTH(posts_fec_posts) - MONTH(NOW()) + 12, 12) LIMIT 5");
    $suma_chart = 0;$percentageChart=[];$nameChart=[]; $nameMonth=[];$numMonth=[];$i=0;
    function nameMonths($numMonths){//date('F',mktime(0,0,0,$monthNum,10)); in english
        $months="";
        switch($numMonths) {
            case "1":$months="Enero";break;
            case "2":$months="Febrero";break;
            case "3":$months="Marzo";break;
            case "4":$months="Abril";break;
            case "5":$months="Mayo";break;
            case "6":$months="Junio";break;
            case "7":$months="Julio";break;
            case "8":$months="Agosto";break;
            case "9":$months="Septiembre";break;
            case "10":$months="Octubre";break;
            case "11":$months="Noviembre";break;
            case "12":$months="Diciembre";break;
            default:break;
        }
        return $months;
    }
    foreach($chart as $barschart){
        $percentageChart[$i]=$barschart['stat'];
        $nameChart[$i]=nameMonths($barschart['months']);
        $suma_chart += $barschart['stat'];
        $i++;
    }$i=0;
    foreach($dates as $months){
        $numMonth[$i]=$months['months'];
        $nameMonth[$i]=nameMonths($months['months']);
        $i++;
    }
?>
        <style>
            .home-content,body{
                background: #333;
            }
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
                    <div class="graph">
                        <form action="./stats" method="GET" id="usrform">
                            <label>mes
                                <select name="month" aria-controls="tablaUsuarios" class="custom-select custom-select-sm form-control form-control-sm" form="usrform">
                                    <?php
                                        if(empty($month))echo '<option value="">--Todo--</option>';
                                        for($i=0;$i<count($nameMonth);$i++){
                                            if($month==$i)echo "<option value='$numMonth[$i]'>$nameMonth[$i]</option>";
                                        }
                                        for($i=0;$i<count($nameMonth);$i++){
                                            if($month!=$i)echo "<option value='$numMonth[$i]'>$nameMonth[$i]</option>";
                                        }
                                        if(!empty($month))echo '<option value="">--Todo--</option>';
                                    ?>
                                </select>
                            </label>
                            <label>año
                                <select name="year" aria-controls="tablaUsuarios" class="custom-select custom-select-sm form-control form-control-sm" form="usrform">
                                    <?php
                                        if(empty($year))echo '<option value="">--Todo--</option>';$noRepeat="";
                                        foreach($dates as $years){
                                            if($years['years']!=$noRepeat){
                                                if($year==$years['years'])echo "<option value='$years[years]'>$years[years]</option>";
                                                $noRepeat=$years['years'];
                                            }
                                        }$noRepeat="";
                                        foreach($dates as $years1){
                                            if($years1['years']!=$noRepeat){
                                                if($year!=$years1['years'])echo "<option value='$years1[years]'>$years1[years]</option>";
                                                $noRepeat=$years1['years'];
                                            }
                                        }
                                        if(!empty($year))echo '<option value="">--Todo--</option>';
                                    ?>
                                </select>
                            </label>
                            <input type="submit" class="btn btn-save" style="padding:6px 15px" form="usrform">
                        </form>
                        <h2>Proyectos de carreras polulares</h2>
                        <!-- <figure class="pie-graph"><div id="colorPicker"></div></figure> -->
                        <div class="pie-graph">
                            <svg viewBox='0 0 62 62'>
                                <circle class="pie1" cx='30' r='15.9' data-percentage="100"></circle>
                                <?php if($percentageGraph[1]>0){?><circle class='pie2' cx='30' r='15.9' data-percentage='<?=number_format(($suma_total-$percentageGraph[0])/$suma_total*100,2);?>'></circle><?php }?>
                                <?php if($percentageGraph[2]>0){?><circle class='pie3' cx='30' r='15.9' data-percentage='<?=number_format(($suma_total-$percentageGraph[0]-$percentageGraph[1])/$suma_total*100,2);?>'></circle><?php }?>
                                <?php if($percentageGraph[3]>0){?><circle class='pie4' cx='30' r='15.9' data-percentage='<?=number_format(($suma_total-$percentageGraph[0]-$percentageGraph[1]-$percentageGraph[2])/$suma_total*100,2);?>'></circle><?php }?>
                                <?php if($percentageGraph[4]>0){?><circle class='pie5' cx='30' r='15.9' data-percentage='<?=number_format(($suma_total-$percentageGraph[0]-$percentageGraph[1]-$percentageGraph[2]-$percentageGraph[3])/$suma_total*100,2);?>'></circle><?php }?>
                            </svg>
                            <?php
                            for ($i=0; $i < count($nameGraph); $i++) { 
                                echo "<span class='tooltip'>$nameGraph[$i] $percentage[$i]%</span>";
                            }
                            ?>
                        </div>
                        <p>
                            <?php
                            for ($i=0; $i < count($nameGraph); $i++) { 
                                echo "$nameGraph[$i] $percentageGraph[$i] <span></span><br>";
                            }
                            ?>
                        </p>
                        <h3>Descargas realizadas</h3>
                    </div>
                    <br>
                    <div class="chart">
                        <h2>Porcentaje de visitas</h2>
                        <ul class="numbers">
                            <li><span>100%</span></li>
                            <li><span>50%</span></li>
                            <li><span>0%</span></li>
                        </ul>
                        <ul class="bars">
                            <?php
                            for ($i=0;$i<count($nameChart);$i++) {
                            ?>
                                <li><div class='bar' data-percentage='<?=number_format(($percentageChart[$i]/$suma_chart)*100,2);?>'></div><span><?=$nameChart[$i];?></span></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                        for ($i=0;$i<count($nameChart);$i++) { 
                            echo "<span class='tooltip'>Visitas $percentageChart[$i]</span>";
                        }
                        ?>
                    </div>
                    <br>
                    <style>
                        .btn-save{
                            border: none;
                            outline: none;
                            color: #fff;
                            cursor: pointer;
                            font-size: 14px;
                            padding: 9px 15px;
                            border-radius: 5px;
                            background-color: #00ffaa;
                        }
                        .btn-save:hover{
                            background: #3addc7;
                        }
                    </style>
                    <div>
                        <a href="./reporte" target="_blank" class="btn btn-save">Generar Reporte</a>
                        <a href="./reporte" download="reporte.pdf" class="btn btn-save"><i class="fa-solid fa-download"></i></a>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
        <script src="../js/stats.js"></script>
        <script src="../js/coders.js"></script>
    </body>
</html>