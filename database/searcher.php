<?php
require_once('conexion.php');
$totalregistros='';
$resultOptions;
$limit=(isset($_REQUEST['limit'])&&is_numeric($_REQUEST['limit'])&&$_REQUEST['limit']>=0)?$_REQUEST['limit']:5;
$pagina=(isset($_REQUEST['nume'])&&is_numeric($_REQUEST['nume'])&&$_REQUEST['nume']>0)?$_REQUEST['nume']:1;
$inicio=($pagina>1)?($limit*($pagina-1)):0;
$item3=(!empty($_REQUEST['item3']))?str_replace("'",'',$_REQUEST['item3']):'';
//Searcher with filters
$seeker=(!empty($_REQUEST['seeker']))?str_replace("'",'',$_REQUEST['seeker']):'';
$career=(!empty($_REQUEST['item1']))?str_replace("'",'',$_REQUEST['item1']):'';
$autor=(!empty($_REQUEST['item2']))?str_replace("'",'',$_REQUEST['item2']):'';
$rangedate=(!empty($item3)&&substr_count($item3,'-')==1&&str_word_count($item3)==1)?$item3:
(!empty($item3)&&substr_count($item3,'-')<=1&&(str_word_count($item3)==0)?"$item3 - $item3":'');
$updateCareers=mysqli_query($con,"SELECT carer_nom_carer FROM acacarer");
function stickout_phrase($string,$frase,$taga = '<b style="color:#ff8400">',$tagb = '</b>'){
    $string=($string!=''&&$frase !=''&&strlen($frase)>2)?preg_replace('/('.preg_quote($frase,'/').')/i'.('true'?'u':''),$taga.'\\1'.$tagb,$string):$string;
    $frase=explode(" ", $frase);
    for ($i=0; $i < count($frase); $i++) { 
        $string=($string!=''&&$frase[$i] !=''&&strlen($frase[$i])>2)?preg_replace('/('.preg_quote($frase[$i],'/').')/i'.('true'?'u':''),$taga.'\\1'.$tagb,$string):$string;
    }
    return $string;
}
function sanitize($seeker){
    $akeyword=str_replace('\x33\x39',' ',$seeker);//'
    $akeyword=str_replace('\x34\x35\x34\x35',' ',$seeker);//--
    $akeyword=str_replace('.',' ',$seeker);
    $akeyword=str_replace('\x34\x32',' ',$seeker);//*
    $akeyword=str_replace('(',' ',$seeker);
    $akeyword=str_replace(')',' ',$seeker);
    $akeyword=str_replace('\x34\x34',' ',$seeker);//,
    return $seeker;
}
function paginator($pagina,$paginas){
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
    echo '</ul>
    </div>';
}
if(!isset($_REQUEST['assortment'])){
    $counting="(SELECT COUNT(*) reg FROM acaprojc)";
    $filter[0]=(!empty($_REQUEST['item1']))?"AND car.carer_nom_carer = '".str_replace("'",'',$_REQUEST['item1'])."'":'';
    $filter[1]=(!empty($_REQUEST['item2']))?"AND aut.autor_nom_autor = '".str_replace("'",'',$_REQUEST['item2'])."'":'';
    $filter[2]=(!empty($_REQUEST['item3']))?"AND YEAR(projc_fec_projc) BETWEEN  ".str_replace('-',' AND ',$rangedate)."":'';
    
    if(!empty($seeker)||!empty($career)||!empty($autor)||!empty($rangedate)){
        $akeyword=sanitize($seeker);
        $akeyword=explode(" ", $akeyword);
        $selectSearch="SELECT prj.projc_cod_projc,prj.projc_fec_projc,prj.projc_tit_projc,aut.autor_nom_autor,prj.projc_fil_projc FROM acaprojc prj JOIN acaautor aut ON prj.projc_cod_projc=autor_cod_projc JOIN acatutor tor ON tor.tutor_cod_tutor=aut.autor_cod_tutor JOIN acacolec erv ON erv.colec_cod_colec=prj.projc_cod_colec JOIN acacarer car ON car.carer_cod_carer=erv.colec_cod_carer WHERE (aut.autor_nom_autor LIKE '%".$akeyword[0]."%' OR tor.tutor_nom_tutor LIKE '%".$akeyword[0]."%' OR prj.projc_fec_projc LIKE '%".$akeyword[0]."%' OR prj.projc_rem_projc LIKE '%".$akeyword[0]."%'";
        for ($i=0; $i < count($akeyword); $i++) { 
            if(!empty($akeyword[$i]))$selectSearch.=" OR aut.autor_nom_autor LIKE '%".$akeyword[$i]."%' OR tor.tutor_nom_tutor LIKE '%".$akeyword[$i]."%' OR prj.projc_fec_projc LIKE '%".$akeyword[$i]."%' OR prj.projc_rem_projc LIKE '%".$akeyword[$i]."%'";
        }
        $selectSearch.=") $filter[0] $filter[1] $filter[2]";
        $totalregistros=$selectSearch;
        $selectSearch.=" LIMIT $limit OFFSET $inicio";
        $resultOptions=mysqli_query($con,$selectSearch);
    
        $totalregistros=mysqli_query($con,$totalregistros);
        $totalregistros=mysqli_num_rows($totalregistros);
    }else{
        $resultOptions=mysqli_query($con,"SELECT prj.projc_cod_projc,prj.projc_fec_projc,prj.projc_tit_projc,aut.autor_nom_autor,prj.projc_fil_projc FROM acaprojc prj JOIN acaautor aut ON prj.projc_cod_projc=autor_cod_projc ORDER BY prj.projc_cod_projc DESC LIMIT $limit OFFSET $inicio");
        //constructor count pages
        $quantity=mysqli_query($con,$counting);
        $totalregistros=$quantity->fetch_assoc();
        $totalregistros=$totalregistros['reg'];
    }
    //total count pages
    $paginas=(!empty($totalregistros))?ceil($totalregistros/$limit):0;
    if($pagina>$paginas){
        $pagina=$paginas;
        $inicio=($pagina>1)?($limit*($pagina-1)):0;
    }
}else{
    $akeyword=sanitize($seeker);
    $akeyword=explode(" ", $akeyword);
    if(empty($_REQUEST['browse'])||$_REQUEST['browse']=="Colección")$resultOptions=mysqli_query($con,"SELECT carer_nom_carer,colec_nom_colec,COUNT(colec_nom_colec) reg FROM acaprojc JOIN acacolec ON projc_cod_colec=colec_cod_colec JOIN acacarer ON carer_cod_carer=colec_cod_carer GROUP BY carer_nom_carer,colec_nom_colec");
    if(!empty($_REQUEST['browse'])&&$_REQUEST['browse']=="Autor"){
        $limit=20;$inicio=($pagina>1)?($limit*($pagina-1)):0;
        $letter=!empty($akeyword[0])?"WHERE autor_nom_autor LIKE '$akeyword[0]%' OR autor_nom_autor LIKE '%, $akeyword[0]%'":'';
        $selectSearch="SELECT autor_nom_autor,COUNT(autor_nom_autor) reg FROM acaprojc JOIN acaautor ON autor_cod_projc=projc_cod_projc $letter";
        //constructor count pages
        $quantity=mysqli_query($con,$selectSearch);
        $totalregistros=$quantity->fetch_assoc();
        $totalregistros=$totalregistros['reg'];
        //total count pages
        $paginas=(!empty($totalregistros))?ceil($totalregistros/$limit):0;
        if($pagina>$paginas){
            $pagina=$paginas;
            $inicio=($pagina>1)?($limit*($pagina-1)):0;
        }
        $selectSearch.=" GROUP BY autor_nom_autor LIMIT $limit OFFSET $inicio";
        $resultOptions=mysqli_query($con,$selectSearch);
    }
    if(!empty($_REQUEST['browse'])&&$_REQUEST['browse']=="Título"){
        $letter=!empty($akeyword[0])?"WHERE projc_tit_projc LIKE '$akeyword[0]%'":'';
        $selectSearch="SELECT projc_cod_projc,projc_fec_projc,projc_tit_projc,autor_nom_autor,projc_fil_projc,COUNT(projc_tit_projc) reg FROM acaprojc JOIN acaautor ON autor_cod_projc=projc_cod_projc $letter";
        //constructor count pages
        $quantity=mysqli_query($con,$selectSearch);
        $totalregistros=$quantity->fetch_assoc();
        $totalregistros=$totalregistros['reg'];
        //total count pages
        $paginas=(!empty($totalregistros))?ceil($totalregistros/$limit):0;
        if($pagina>$paginas){
            $pagina=$paginas;
            $inicio=($pagina>1)?($limit*($pagina-1)):0;
        }
        $selectSearch.=" GROUP BY projc_cod_projc LIMIT $limit OFFSET $inicio";
        $resultOptions=mysqli_query($con,$selectSearch);
    }
}
if(isset($_REQUEST['collec'])){
    $collec=(!empty($_REQUEST['collec']))?"AND erv.colec_nom_colec = '".$_REQUEST['collec']."'":'';
    if(isset($_REQUEST['collec'])){
        $selectSearch="SELECT prj.projc_cod_projc,prj.projc_fec_projc,prj.projc_tit_projc,aut.autor_nom_autor,prj.projc_fil_projc FROM acaprojc prj JOIN acaautor aut ON prj.projc_cod_projc=autor_cod_projc JOIN acatutor tor ON tor.tutor_cod_tutor=aut.autor_cod_tutor JOIN acacolec erv ON erv.colec_cod_colec=prj.projc_cod_colec JOIN acacarer car ON car.carer_cod_carer=erv.colec_cod_carer WHERE (aut.autor_nom_autor LIKE '%".$akeyword[0]."%' OR tor.tutor_nom_tutor LIKE '%".$akeyword[0]."%' OR prj.projc_fec_projc LIKE '%".$akeyword[0]."%' OR prj.projc_rem_projc LIKE '%".$akeyword[0]."%'";
        for ($i=0; $i < count($akeyword); $i++) { 
            if(!empty($akeyword[$i]))$selectSearch.=" OR aut.autor_nom_autor LIKE '%".$akeyword[$i]."%' OR tor.tutor_nom_tutor LIKE '%".$akeyword[$i]."%' OR prj.projc_fec_projc LIKE '%".$akeyword[$i]."%' OR prj.projc_rem_projc LIKE '%".$akeyword[$i]."%'";
        }
        $selectSearch.=") $collec GROUP BY prj.projc_cod_projc";
        $totalregistros=$selectSearch;
        $selectSearch.=" LIMIT $limit OFFSET $inicio";
        $resultOptions=mysqli_query($con,$selectSearch);
    
        $totalregistros=mysqli_query($con,$totalregistros);
        $totalregistros=mysqli_num_rows($totalregistros);
        //total count pages
        $paginas=(!empty($totalregistros))?ceil($totalregistros/$limit):0;
        if($pagina>$paginas){
            $pagina=$paginas;
            $inicio=($pagina>1)?($limit*($pagina-1)):0;
        }
    }
}
?>