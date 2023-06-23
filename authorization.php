<?php
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
    $radio = $_POST['radio'];
    $mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
    if($radio=="ученик"){
        $result = $mysql->query("SELECT * FROM `ученик` WHERE `login`='$login' AND `password`='$pass'");
        if (mysqli_num_rows($result)!=0){
        $user = $result->fetch_assoc();
        setcookie('student', $user['login'], time() + 60*30,'/');
        $mysql->close;
        header("Location:/index.php");}
        else{
            echo "Такой пользователь не найден.<br>Попробуйте еще раз.";
        }
    }
    if($radio=="учитель"){
        $result = $mysql->query("SELECT * FROM `учителя` WHERE `login`='$login' AND `password`='$pass'");
        if (mysqli_num_rows($result)!=0){
        $user = $result->fetch_assoc();
        setcookie('teacher', $user['login'], time() + 60*30,'/');
        $mysql->close;
        header("Location:/index.php");}
        else{
            echo "Такой пользователь не найден.<br>Попробуйте еще раз.";
        }
    }
?>