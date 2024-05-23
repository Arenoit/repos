<?php
    require_once('conexion.php');
    $newCarer=!empty($_REQUEST['carer'])?str_replace("'",'',trim($_REQUEST['carer'])):"";
    $editCarer=!empty($_REQUEST['ecarer'])?str_replace("'",'',trim($_REQUEST['ecarer'])):"";
    $deleteCarer=!empty($_REQUEST['dcarer'])?str_replace("'",'',trim($_REQUEST['dcarer'])):"";

    $newDate=!empty($_REQUEST['newdate'])?str_replace("'",'',$_REQUEST['newdate']):"";
    $editDate=!empty($_REQUEST['editdate'])?str_replace("'",'',$_REQUEST['editdate']):"";
    $deleteDate=!empty($_REQUEST['deletedate'])?str_replace("'",'',$_REQUEST['deletedate']):"";
    $initDate=!empty($_REQUEST['idate'])?str_replace("'",'',trim($_REQUEST['idate'])):"";
    $finitDate=!empty($_REQUEST['fdate'])?str_replace("'",'',trim($_REQUEST['fdate'])):"";

    $editCollec=!empty($_REQUEST['ecollec'])?str_replace("'",'',trim($_REQUEST['ecollec'])):"";

    $direction=!empty($_REQUEST['direction'])?str_replace("'",'',trim($_REQUEST['direction'])):"";
    if($_SERVER["REQUEST_METHOD"]=='POST'){
        if(!empty($newCarer)){
            $notrepeat="";
            $updateCareers = mysqli_query($con,"SELECT carer_nom_carer FROM acacarer WHERE carer_nom_carer='$newCarer'");
            if(mysqli_num_rows($updateCareers)>0)$notrepeat="No se puede agregar repetidos";
            echo $notrepeat;
            if(empty($notrepeat)){
                mysqli_query($con,"INSERT INTO acacarer(carer_nom_carer) VALUES ('$newCarer')");
                echo "success";
            }
        }
        if(!empty($editCarer)){
            $notrepeat="";
            $updateCareers = mysqli_query($con,"SELECT carer_nom_carer FROM acacarer WHERE carer_nom_carer='$editCarer'");
            if(mysqli_num_rows($updateCareers)>0)$notrepeat="No se puede agregar repetidos";
            echo $notrepeat;
            if(empty($notrepeat)){
                mysqli_query($con,"UPDATE acacarer SET carer_nom_carer='$editCarer' WHERE carer_nom_carer='$direction'");
                echo "success";
            }
        }
        if(!empty($deleteCarer)){
            $resultCareers=mysqli_query($con,"SELECT carer_nom_carer, count(carer_nom_carer) as contador FROM acacarer JOIN acacolec ON colec_cod_carer=carer_cod_carer JOIN acaprojc ON projc_cod_colec=colec_cod_colec WHERE carer_nom_carer='$deleteCarer' GROUP BY carer_nom_carer");
            $resultCareers=mysqli_fetch_assoc($resultCareers);
            if(empty($resultCareers['contador'])){
                mysqli_query($con,"DELETE FROM acacarer WHERE carer_nom_carer='$deleteCarer'");
                echo "success";
            }else{
                echo "Solo se puede eliminar carreras que no tienen proyectos";
            }
        }
        if($initDate<=$finitDate){
            if(!empty($initDate)&&!empty($finitDate)){
                if(!empty($newDate)){
                    $notrepeat="";
                    foreach ($rangedates as $range){
                        if($initDate==$range['config_ifec_config']&&$finitDate==$range['config_ffec_config'])$notrepeat="No se puede agregar repetidos";
                    }
                    echo $notrepeat;
                    if(empty($notrepeat)){
                        mysqli_query($con,"INSERT INTO acaconfig(config_ifec_config,config_ffec_config) VALUES ('$initDate','$finitDate')");
                        echo "success";
                    }
                }
                if(!empty($editDate)){
                    $direction=str_replace('-','',$direction);
                    $akeyword=explode(" ", $direction);
                    $notrepeat="";
                    foreach ($rangedates as $range){
                        if($initDate==$range['config_ifec_config']&&$finitDate==$range['config_ffec_config'])$notrepeat="No se puede agregar repetidos";
                    }
                    echo $notrepeat;
                    if(empty($notrepeat)){
                        mysqli_query($con,"UPDATE acaconfig SET config_ifec_config='$initDate',config_ffec_config='$finitDate' WHERE config_ifec_config='$akeyword[0]' AND config_ffec_config='$akeyword[2]'");
                        echo "success";
                    }
                }
            }else if(!empty($newDate)||!empty($editDate)){
                echo "Los campos no deben estar vacios";
            }
            if(!empty($deleteDate)){
                $deleteDate=str_replace('-','',$deleteDate);
                $akeyword=explode(" ", $deleteDate);
                mysqli_query($con,"DELETE FROM acaconfig WHERE config_ifec_config='$akeyword[0]' AND config_ffec_config='$akeyword[2]'");
                echo "success";
            }
        }else{
            echo "El rango de años es de menor a mayor";
        }
        if(!empty($editCollec)){
            $notrepeat="";
            $updateCollection=mysqli_query($con,"SELECT colec_nom_colec FROM acaprojc JOIN acacolec ON projc_cod_colec=colec_cod_colec JOIN acacarer ON carer_cod_carer=colec_cod_carer WHERE colec_nom_colec='$editCollec' GROUP BY colec_nom_colec");
            if(mysqli_num_rows($updateCollection)>0)echo $notrepeat="No se puede agregar repetidos";
            if(empty($notrepeat)){
                mysqli_query($con,"UPDATE acacolec SET colec_nom_colec='$editCollec' WHERE colec_nom_colec='$direction'");
                echo "success";
            }
        }
    }
?>