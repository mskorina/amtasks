<?php
class First 
{
    public function getClassname() 
    {
        echo static::class ."\n"; // use late static binding
    }
    public function getLetter() 
    {
        echo "A\n";
    }
}

class Second extends First 
{
    public function getLetter() 
    {
        echo "B\n";
    }
}

$class1=new First();
$class2=new Second();

$class1->getClassname();
$class2->getClassname();

$class1->getLetter();
$class2->getLetter();


?>



