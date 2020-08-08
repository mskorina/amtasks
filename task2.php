<?php

$colorsName=array("red", "blue", "green", "yellow", "lime", "magenta", "black", "gold", "gray", "tomato");
$colors=array("#ff0000", "#0000ff", "#00FFa0", "#ffd000", "#aaff00", "#ff00ff", "#000000", "#ffb700", "#6a5f31", "#a12312");

function GetIndexColor() 
{
    return rand(0,9);
}

function GetLineTest($len) 
{

    $oldname=-1; //Variables to save the past state of colors and words are needed so that they do not coincide in a row
    $oldcolor=-1;
    // This problem can be solved by increasing the pseudo-random number, but you will have to complicate the logic of selecting an element from the array, in addition,
    //the entropy on the machine can be low (this is often typical for VDS \ VPS)
    // Even random_int () won't help on small numbers
    for ($i=0;$i<$len;$i++)
    {
        global $colors,$colorsName;
        $pos1=GetIndexColor();
        $pos2=GetIndexColor();
        
        while ($pos1==$pos2 or $oldname==$pos2 or $oldcolor==$pos1) // if the positions match
        {
            $pos1=GetIndexColor();
            $pos2=GetIndexColor();
        }
        $oldcolor=$pos1;
        $oldname=$pos2;
        
        echo "<span style=\"color: $colors[$pos1]\">$colorsName[$pos2]</span>\n";
        
    }
    echo "<br>\n";
}

function GetTest($widthCol,$hightCol) 
{
    for ($i=0;$i<$hightCol;$i++)
    {
        GetLineTest($widthCol);
    }
}

GetTest(5,5);


?>



