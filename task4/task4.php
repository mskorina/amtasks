<h3>Результат команды по годам (2009-2020)</h3>
<form method="POST">
    Название команды: <input type="text" name="nameteam" /><br><br>
    <input type="submit" value="Проверить">
</form>
</body>
</html>

<?php
include('simple_html_dom.php');

$baseurls='https://terrikon.com/football/italy/championship/';
$urls=array('table','2018-19/table','2017-18/table','2016-17/table','2015-16/table','2014-15/table','2013-14/table','2012-13/table','2011-12/table','2010-11/table','2009-10/table');
$baseyear=2020;

function ParsePos($baseurls,$urls,$nameteam) 
{
	$pos=array();
	for($i=0;$i<count($urls);$i++) 
	{
		$html = file_get_html($baseurls.$urls[$i]);

		foreach($html->find('body div[2] div[2] div[2] div[2] table[1] tr') as $e)
		{
			if ($e->children(1)->plaintext===$nameteam) 
			{
				$pos[]=explode('.',$e->children(0)->plaintext)[0];
			}
		}

	}
	return $pos;
}

function CreateTable($nameteam,$posarray,$baseyear) 
{
	echo '<h4>'.$nameteam.'</h4>';
	echo '<table border="1"><tbody><tr><th>Место</th><th>Год</th></tr>';
	foreach ($posarray as $pos) {
		echo '<tr><td>'.$pos.'</td><td>'.$baseyear.'-'.($baseyear-1).'</td></tr>';
		$baseyear-=1;
	}
	echo '</tbody></table>';
}

if(isset($_POST['nameteam']))
{
	if ($_POST['nameteam']!=="") 
	{
		$nameteam=strip_tags($_POST['nameteam']);
		$posarray=ParsePos($baseurls,$urls,$nameteam);
		if (count($posarray)>0) 
		{
			CreateTable($nameteam,$posarray,$baseyear);
		}
		else 
		{
			echo 'Такой команды нет';
		}
	}
	else 
	{
		echo 'Вы не указали название команды';
	}
}

?>
