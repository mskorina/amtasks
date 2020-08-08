<?php

function is_number($var)
{
    if ($var === intval($var,0)) 
    {
        return is_numeric($var);
    }
    if ($var >= 0 && is_string($var) && !is_float($var)) {
        return ctype_digit($var);
    }
    return is_numeric($var);
}

function getResultArray($checknumbers) 
{
    $numbers=array();
    foreach ($checknumbers as $checknum) 
    {
    
        if(is_number($checknum))
        {
            $numbers[]=intval($checknum);
        }
    }
    
    $setnumbers=array_unique($numbers);
    $result=asort($setnumbers,SORT_NUMERIC);
    return $setnumbers;
}

function arraytoString($intarray)
{
    $resultstr="";
    foreach($intarray as $num) 
    {

        $resultstr.=strval($num)." ";
    }
    return $resultstr;
}

if ($argc==2)
{
$checknumbers=explode(" ",$argv[1]);
$resultarray=getResultArray($checknumbers);
$resultstr=arraytoString($resultarray);
print($resultstr);
}
else
{
    print("No correct input");
}
?>



