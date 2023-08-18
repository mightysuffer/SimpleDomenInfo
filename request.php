<?php
date_default_timezone_set("Europe/Moscow");
if (isset($_POST['dom']))
{
	$datetime = date('Y-m-d H:i:s');
	$dom = $_POST['dom'];
	$info = file_get_contents('https://ipwhois.app/json/' . $dom . '?lang=ru');
	$arr = json_decode($info, TRUE);
	$str = null;
	echo "Информация о " . $dom ."<br>";
	foreach ($arr as $i => $val) {
		echo $i.' : '.$val."<br>";
	}
	echo 'Время запроса: '.$datetime;
	$ip = $arr['ip'];
	$host = 'localhost';
	$user = 'root';
	$passw = NULL;
	$db_name = 'course';
	$link = mysqli_connect($host, $user, $passw, $db_name);
	$sql = mysqli_query($link, 
	"INSERT INTO
		course(DMN,IP,DT) 
	 VALUES 
	 	('{$_POST['dom']}','$ip','$datetime')");
	if ($sql) {
	 	echo '<p>Данные успешно добавлены в таблицу.</p>';
	 } else {
	 	echo '<p>Ошибка: ' . mysqli_error($link) . '</p>';
	 }
}
else
{
	echo "Укажите домен";
}
?>
<input type='button' value='Назад' onclick="location='http://localhost/course/form.php'">