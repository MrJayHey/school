<?php 
$mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
$date = $_POST['date'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$result = $mysql->query("INSERT INTO `мероприятия` (`id`, `Дата`, `Наименование`, `Примечание`) VALUES (NULL, '$date', '$name', '$comment');");
$mysql->close;
header("Location:/add-event.php");
?>