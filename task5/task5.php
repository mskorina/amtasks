<h3>Информация о пользователях</h3>
<form method="POST">
    ID пользователя: <input type="text" name="iduser" /><br><br>
<select name="operation" size="1">
    <option value="id">Информация о пользователе</option>
    <option value="cities">Трансакции в одном городе</option>
    <option value="bigcity">Город с наибольшим кол-вом трансакций</option>
</select>
    <input type="submit" value="Проверить">
</form>
</body>
</html>


<?php
require_once 'connection.php';

$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

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

function GetBalance($link,$id) 
{
	$basesum=100.0000;
	$query ="SELECT amount,to_person_id FROM transactions where from_person_id=".$id." or to_person_id=".$id;
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	$rows = mysqli_num_rows($result); 

	if ($rows==0)
	{
		echo 'Такого человека нет или у него нет трансакций';
	}
	else 
	{
		for ($i = 0 ; $i < $rows ; ++$i)
		{
		    $row = mysqli_fetch_row($result);
		    if ($row[1]==$id) {
		    	$basesum+=$row[0];
		    }
		    else 
		    {
		    	$basesum-=$row[0];
		    }
		}
		mysqli_free_result($result);
		$query ="select fullname from persons where id=".$id;
		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
		$rows = mysqli_num_rows($result);	
			for ($i = 0 ; $i < $rows ; ++$i)
		{
		    $row = mysqli_fetch_row($result);
		    echo $row[0].' Баланс:'.$basesum;
		}
	}
}

function GetTransactionInOneCity($link) 
{
	$query ="SELECT transactions.transaction_id, transactions.from_person_id, transactions.to_person_id, transactions.amount FROM transactions where (select city_id from persons where id=transactions.from_person_id)=(select city_id from persons where id=transactions.to_person_id)";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	$rows = mysqli_num_rows($result); 

	if ($rows==0)
	{
		echo 'нет трансакций в одном городе';
	}
	else 
	{
		echo '<h4>Трансакции в одном городе</h4>';
		echo '<table border="1"><tbody><tr><th>ID</th><th>Id отправителя</th><th>Id получателя</th><th>Сумма</th></tr>';
		for ($i = 0 ; $i < $rows ; ++$i)
		{
		    $row = mysqli_fetch_row($result);
    		echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td></tr>';
		}
		mysqli_free_result($result);
		echo '</tbody></table>';
	}
}

function GetBigCity($link) 
{
	$query ="select persons.city_id,count(persons.city_id) as col from transactions join persons on transactions.to_person_id=persons.id or transactions.from_person_id=persons.id group by persons.city_id order by col desc LIMIT 1;";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	$rows = mysqli_num_rows($result); 

	if ($rows==0)
	{
		echo 'нет трансакций';
	}
	else 
	{
	    $row = mysqli_fetch_row($result);		
	    $city_id=$row[0];
		mysqli_free_result($result);
		$query="select name from cities where id=".$city_id;
		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 		
		$rows = mysqli_num_rows($result);
		echo '<h4>Город с наибольшим кол-вом трансакций</h4>';
		for ($i = 0 ; $i < $rows ; ++$i)
		{
		    $row = mysqli_fetch_row($result);
    		echo $row[0];
		}
		mysqli_free_result($result);
	}
}



if(isset($_POST['operation']))
{
    $operation = $_POST['operation'];
    if ($operation==="id") 
    {
    	if(isset($_POST['iduser']) && is_number($_POST['iduser'])) 
    	{
			GetBalance($link,$_POST['iduser']);
    	}
    	else 
    	{
    		echo 'Не корректный id';
    	}
    }
    else if ($operation==="cities")
    	GetTransactionInOneCity($link);
    else if ($operation==="bigcity")
    	GetBigCity($link);
}

     
// закрываем подключение
mysqli_close($link);
?>