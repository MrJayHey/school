<?php 
$mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
$subject = $_POST['subject'];
$date_grade =  $_POST['date-grade'];
for ($i=0;$i<$_POST['size'];$i++){  
    $student = 'student'.$i;
    $grade = 'grade'.$i;
    $student = $_POST[$student];
    $grade= $_POST[$grade];
    echo $student.":".$grade."<br>";
    if ($grade!="No"){
    $result = $mysql->query("INSERT INTO `сводная ведомость` (`Предмет_Код`, `Ученик_Код`, `Дата`, `Оценка`) VALUES ('$subject', '$student', '$date_grade', '$grade')");}
}
$mysql->close;
setcookie('subject', $subject, time() + 60,'/');
setcookie('class', $_POST['class'], time() + 60,'/');
header("Location:/add-grade.php");
?>