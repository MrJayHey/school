<?php 
$mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
$id_grade = $_POST['grade_id'];
$new_grade = $_POST['new_grade'];
if($new_grade!="Нет"){
$result = $mysql->query("UPDATE `сводная ведомость` SET `Оценка` = '$new_grade' WHERE `сводная ведомость`.`id` = $id_grade;");}
$mysql->close;
setcookie('subject', $_POST['subject_id'], time() + 60,'/');
setcookie('class', $_POST['selected_class'], time() + 60,'/');
setcookie('student', $_POST['student_id'], time() + 60,'/');
header("Location:/delete-grade.php");

?>