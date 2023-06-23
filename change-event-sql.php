<?php 
$mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
$date = $_POST['date'];
$name = $_POST['name'];
$comment = $_POST['comment'];
$id = $_POST['id'];
$result = $mysql->query("UPDATE `мероприятия` SET `Дата` = '$date', `Наименование` = '$name', `Примечание` = '$comment' WHERE `мероприятия`.`id` = $id;");
$mysql->close;

setcookie('event_id', $_POST['id'], time() + 60,'/');
header("Location:/change-event.php");

?>