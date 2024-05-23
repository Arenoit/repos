<?php
    require_once('conexion.php');
    $totalregistros='';
    $limit=(isset($_REQUEST['limit'])&&is_numeric($_REQUEST['limit'])&&$_REQUEST['limit']>=0)?$_REQUEST['limit']:15;
    $pagina=(isset($_REQUEST['nume'])&&is_numeric($_REQUEST['nume'])&&$_REQUEST['nume']>0)?$_REQUEST['nume']:1;
    $inicio=($pagina>1)?($limit*($pagina-1)):0;

    //Searcher with filters
    $listuser=(!empty($_REQUEST['listuser']))?str_replace("'",'',$_REQUEST['listuser']):'';
    $solic=(!empty($_REQUEST['solic']))?str_replace("'",'',$_REQUEST['solic']):'';
    $status=(!empty($_REQUEST['status']))?str_replace("'",'',$_REQUEST['status']):"";
    $type=(!empty($_REQUEST['type']))?str_replace("'",'',$_REQUEST['type']):"";
    function stickout_phrase($string,$frase,$taga = '<b style="color:#ff8400">',$tagb = '</b>'){
        $string=($string!=''&&$frase !=''&&strlen($frase)>2)?preg_replace('/('.preg_quote($frase,'/').')/i'.('true'?'u':''),$taga.'\\1'.$tagb,$string):$string;
        $frase=explode(" ", $frase);
        for ($i=0; $i < count($frase); $i++) { 
            $string=($string!=''&&$frase[$i] !=''&&strlen($frase[$i])>2)?preg_replace('/('.preg_quote($frase[$i],'/').')/i'.('true'?'u':''),$taga.'\\1'.$tagb,$string):$string;
        }
        return $string;
    }

    $akeyword=str_replace('\x33\x39',' ',$listuser);//'
    $akeyword=str_replace('\x34\x35\x34\x35',' ',$listuser);//--
    $akeyword=str_replace('.',' ',$listuser);
    $akeyword=str_replace('\x34\x32',' ',$listuser);//*
    $akeyword=str_replace('(',' ',$listuser);
    $akeyword=str_replace(')',' ',$listuser);
    $akeyword=str_replace('\x34\x34',' ',$listuser);//,
    $akeyword=explode(" ", $akeyword);
    if(empty($solic)){
        $counting="(SELECT COUNT(*) reg FROM acausers)";
        $selectSearch="SELECT users_cod_users,users_fec_users,users_usr_users,users_eml_users,users_sts_users,users_typ_users FROM acausers ORDER BY users_cod_users LIMIT $limit OFFSET $inicio";
        $resultOptions=mysqli_query($con,$selectSearch);
        //constructor count pages
        $quantity=mysqli_query($con,$counting);
        $totalregistros=$quantity->fetch_assoc();
        $totalregistros=$totalregistros['reg'];

        $filter[0]=[''];
        if(!empty($status)){
            if($status=="activos")$filter[0]="AND users_sts_users = 1";
            else $filter[0]="AND users_sts_users = 0";
        }else $filter[0]="";
        if(!empty($type)){
            if($type=="normal")$filter[1]="AND users_typ_users = 1";
            else $filter[1]="AND users_typ_users = 0";
        }else $filter[1]="";
        
        if(!empty($listuser)||!empty($status)||!empty($type)){
            $selectSearch="SELECT users_fec_users,users_usr_users,users_eml_users,users_sts_users,users_typ_users FROM acausers WHERE (users_usr_users LIKE '%".$akeyword[0]."%' OR users_eml_users LIKE '%".$akeyword[0]."%' OR users_fec_users LIKE '%".$akeyword[0]."%'";
            for ($i=0; $i < count($akeyword); $i++) { 
                if(!empty($akeyword[$i]))$selectSearch.=" OR users_usr_users LIKE '%".$akeyword[$i]."%' OR users_eml_users LIKE '%".$akeyword[$i]."%' OR users_fec_users LIKE '%".$akeyword[$i]."%'";
            }
            $totalregistros=$selectSearch.")";
            echo $selectSearch.=") $filter[0] $filter[1] ORDER BY users_cod_users LIMIT $limit OFFSET $inicio";
            $resultOptions=mysqli_query($con,$selectSearch);
        
            $totalregistros=mysqli_query($con,$totalregistros);
            $totalregistros=mysqli_num_rows($totalregistros);
        }
        //total count pages
        $paginas=(!empty($totalregistros))?ceil($totalregistros/$limit):'';
        if($pagina>$paginas){
            $pagina=$paginas;
            $inicio=($pagina>1)?($limit*($pagina-1)):0;
        }
    }else{
        $counting="(SELECT COUNT(*) reg FROM acasolic)";
        $resultOptions=mysqli_query($con,"SELECT solic_cod_solic,solic_prj_solic,solic_ubi_solic,solic_mot_solic,solic_rev_solic FROM acasolic ORDER BY solic_cod_solic LIMIT $limit OFFSET $inicio");
        //constructor count pages
        $quantity=mysqli_query($con,$counting);
        $totalregistros=$quantity->fetch_assoc();
        $totalregistros=$totalregistros['reg'];
        if(!empty($listuser)){
            $selectSearch="SELECT solic_cod_solic,solic_prj_solic,solic_ubi_solic,solic_mot_solic,solic_rev_solic FROM acasolic JOIN acausers ON users_cod_users=solic_cod_users WHERE (users_usr_users='%".$akeyword[0]."%'";
            for ($i=0; $i < count($akeyword); $i++) { 
                if(!empty($akeyword[$i]))$selectSearch.=" OR users_usr_users LIKE '%".$akeyword[$i]."%'";
            }
            $totalregistros=$selectSearch.")";
            $selectSearch.=") ORDER BY solic_cod_solic LIMIT $limit OFFSET $inicio";
            $resultOptions=mysqli_query($con,$selectSearch);
        
            $totalregistros=mysqli_query($con,$totalregistros);
            $totalregistros=mysqli_num_rows($totalregistros);
        }
        //total count pages
        $paginas=(!empty($totalregistros))?ceil($totalregistros/$limit):0;
        if($pagina>$paginas){
            $pagina=$paginas;
            $inicio=($pagina>1)?($limit*($pagina-1)):0;
        }
    }
?>