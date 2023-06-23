<?php
    setcookie('teacher', $user['login'], time() - 60*30,'/');
    setcookie('student', $user['login'], time() - 60*30,'/');
    header("Location:/index.php");
?>