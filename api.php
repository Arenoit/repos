<?php
require_once('./database/conexion.php');
$seeker=(!empty($_POST['seeker']))?$_POST['seeker']:'';
$item2=(!empty($_POST['item2']))?$_POST['item2']:'';
$listuser=(!empty($_REQUEST['listuser']))?$_REQUEST['listuser']:'';
$coleccion=(!empty($_REQUEST['coleccion']))?$_REQUEST['coleccion']:'';
if($_SERVER["REQUEST_METHOD"]=='POST'){
    //POST method: Show the data of the client
    function sanitize($seeker){
        $akeyword=str_replace(',',' ',$seeker);
        $akeyword=str_replace('.',' ',$seeker);
        $akeyword=str_replace('*',' ',$seeker);
        $akeyword=str_replace('(',' ',$seeker);
        $akeyword=str_replace(')',' ',$seeker);
        $akeyword=str_replace('--',' ',$seeker);
        return $seeker;
    }
    $variables['items']=array();
    if(!empty($_POST['seeker'])){
        $akeyword=sanitize($seeker);
        $akeyword=explode(" ", $akeyword);
        $selectAutocomplete="SELECT DISTINCT prj.projc_tit_projc FROM acaprojc prj JOIN acaautor aut ON prj.projc_cod_projc=autor_cod_projc JOIN acatutor tor ON tor.tutor_cod_tutor=aut.autor_cod_tutor JOIN acacolec erv ON erv.colec_cod_colec=prj.projc_cod_colec JOIN acacarer car ON car.carer_cod_carer=erv.colec_cod_carer WHERE (aut.autor_nom_autor LIKE '%".$akeyword[0]."%') OR (tor.tutor_nom_tutor LIKE '%".$akeyword[0]."%') OR (prj.projc_fec_projc LIKE '%".$akeyword[0]."%') OR (prj.projc_rem_projc LIKE '%".$akeyword[0]."%')";
        for ($i=0; $i < count($akeyword); $i++) { 
            if(!empty($akeyword[$i]))$selectAutocomplete.=" OR (aut.autor_nom_autor LIKE '%".$akeyword[$i]."%') OR (tor.tutor_nom_tutor LIKE '%".$akeyword[$i]."%') OR (prj.projc_fec_projc LIKE '%".$akeyword[$i]."%') OR (prj.projc_rem_projc LIKE '%".$akeyword[$i]."%')";
        }
        $selectAutocomplete.=" LIMIT 7";$consultAuto=mysqli_query($con,$selectAutocomplete);
        
        while($row=$consultAuto->fetch_assoc()){
            //Object JSON and it is not traverse in the same way as an array
            $item = [
                'nombre'=>$row['projc_tit_projc']
            ];
            array_push($variables['items'],$item);
        }
    }elseif(!empty($_POST['item2'])){
        $akeyword=sanitize($item2);
        $akeyword=explode(" ", $akeyword);
        $selectAutocomplete="SELECT DISTINCT autor_nom_autor FROM acaautor WHERE autor_nom_autor LIKE '%".$akeyword[0]."%'";
        for ($i=0; $i < count($akeyword); $i++) {
            if(!empty($akeyword[$i]))$selectAutocomplete.=" OR autor_nom_autor LIKE '%".$akeyword[$i]."%'";
        }
        $selectAutocomplete.=" LIMIT 7";$consultAuto=mysqli_query($con,$selectAutocomplete);
        
        while($row=$consultAuto->fetch_assoc()){
            //Object JSON and it is not traverse in the same way as an array
            $item = [
                'nombre'=>$row['autor_nom_autor']
            ];
            array_push($variables['items'],$item);
        }
    }elseif(!empty($_POST['listuser'])){
        $akeyword=sanitize($listuser);
        $akeyword=explode(" ", $akeyword);
        $selectAutocomplete="SELECT DISTINCT users_usr_users FROM acausers WHERE users_usr_users LIKE '%".$akeyword[0]."%'";
        for ($i=0; $i < count($akeyword); $i++) {
            if(!empty($akeyword[$i]))$selectAutocomplete.=" OR users_usr_users LIKE '%".$akeyword[$i]."%'";
        }
        $selectAutocomplete.=" LIMIT 7";$consultAuto=mysqli_query($con,$selectAutocomplete);
        
        while($row=$consultAuto->fetch_assoc()){
            //Object JSON and it is not traverse in the same way as an array
            $item = [
                'nombre'=>$row['users_usr_users']
            ];
            array_push($variables['items'],$item);
        }
    }elseif(!empty($coleccion)){
        $akeyword=sanitize($coleccion);
        $akeyword=explode(" ", $akeyword);
        $selectAutocomplete="SELECT DISTINCT colec_nom_colec FROM acacolec WHERE colec_nom_colec LIKE '%".$akeyword[0]."%'";
        for ($i=0; $i < count($akeyword); $i++) {
            if(!empty($akeyword[$i]))$selectAutocomplete.=" OR colec_nom_colec LIKE '%".$akeyword[$i]."%'";
        }
        $selectAutocomplete.=" LIMIT 7";$consultAuto=mysqli_query($con,$selectAutocomplete);
        
        while($row=$consultAuto->fetch_assoc()){
            //Object JSON and it is not traverse in the same way as an array
            $item = [
                'nombre'=>$row['colec_nom_colec']
            ];
            array_push($variables['items'],$item);
        }
    }
    echo json_encode($variables, \JSON_UNESCAPED_UNICODE);
}
?>