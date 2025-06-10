<?php
mb_internal_encoding("UTF-8");
//-----------amniat ID-----------//
function cleanId($id)
{
    if(!is_numeric($id)){
        die('Access Denied!');
    }
    if($id<0){
        die('Access Denied!');
    }
    return $id;
}
//-----------END amniat ID-----------//

function clean($value)
{
    $value=trim($value);
    $value=str_replace('ي','ی',$value);
    $value=str_replace('ك','ک',$value);
    $value=htmlentities($value);
    return $value;
}

function priceFormat($value)
{
    $value=number_format($value, 0, '.', ',');
    return $value;
}

require_once './includes/jdf.php';
function dateFormat($value){
    $value=jdate('d F Y',$value);
    return $value;
}
?>


