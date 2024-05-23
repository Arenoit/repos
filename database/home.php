<?php
$resultCarousel=mysqli_query($con,"SELECT prj.projc_cod_projc,prj.projc_fec_projc,prj.projc_tit_projc, prj.projc_rem_projc FROM acaprojc prj ORDER BY prj.projc_cod_projc DESC LIMIT 6");
$resultCareers=mysqli_query($con,"SELECT carer_nom_carer, count(carer_nom_carer) as contador FROM acacarer JOIN acacolec ON colec_cod_carer=carer_cod_carer JOIN acaprojc ON projc_cod_colec=colec_cod_colec GROUP BY carer_nom_carer");

$totalAutors="SELECT COUNT(aux.creg) reg FROM (SELECT DISTINCT (SELECT COUNT(1)) creg,acaautor.autor_nom_autor FROM acaautor GROUP BY acaautor.autor_nom_autor) aux";
$quant=mysqli_query($con,$totalAutors);
$totalAutors=mysqli_fetch_assoc($quant);
$totalAutors=$totalAutors['reg'];
$slideItem=(isset($_REQUEST['slideItem'])&&$_REQUEST['slideItem']>0&&$_REQUEST['slideItem']<=ceil($totalAutors/7))?$_REQUEST['slideItem']:1;
$sliceItem=($slideItem!=1)?(7*($slideItem-1)):0;

$resultAutors=mysqli_query($con,"SELECT autor_nom_autor, COUNT(acaautor.autor_nom_autor) as contador FROM acaautor JOIN acaprojc ON acaprojc.projc_cod_projc=acaautor.autor_cod_projc GROUP BY autor_nom_autor  LIMIT 7 OFFSET $sliceItem");

$dates = "SELECT config_ifec_config,config_ffec_config FROM acaconfig WHERE config_ifec_config!=0000 AND config_ffec_config !=0000";
$rangedates=mysqli_query($con,$dates);
$countDates=[];$daterange=[];$i=0;
foreach($rangedates as $dates){ 
    $resultDates=mysqli_query($con,"SELECT COUNT(*) dates FROM acaprojc WHERE YEAR(projc_fec_projc) BETWEEN '".$dates['config_ifec_config']."' AND '".$dates['config_ffec_config']."'");
    $resultDates=mysqli_fetch_assoc($resultDates);
    $countDates[$i]=$resultDates['dates'];
    $daterange[$i]=$dates['config_ifec_config']." - ".$dates['config_ffec_config'];
    $i++;
}
?>