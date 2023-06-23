<?php 
$mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
$id = $_POST['id'];
$result = $mysql->query("DELETE FROM `мероприятия` WHERE `мероприятия`.`id` = $id");
$mysql->close;

header("Location:/index.php");

?>