<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Добавление мероприятия</title>
</head>
<body>
<?php require "blocks/header.php" ?>
<?php 
    if($_POST){
    $event_id = $_POST['event_id'];
}else{ 
    $event_id = $_COOKIE['event_id']; 
    setcookie('event_id', $_POST['id'], time() - 60,'/');
    }
    $mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
    $result = $mysql->query("SELECT * FROM `мероприятия` WHERE `id`='$event_id'");
    $event = $result->fetch_assoc();
    $event_name = $event['Наименование'];
    $event_date = $event['Дата'];
    $event_comment = $event['Примечание'];
    ?>


 
<?php if($_COOKIE['teacher']): ?>
    <div class="container mt-4">
            <h1>Добавление мероприятия</h1>
            <form action="change-event-sql.php" method="post">
                <input type="hidden" value="<?php echo $event_id ?>" name="id">
                <input value="<?php echo $event_date ?>" required type="date" class="form-control" name='date' id='date'><br>
                <input value="<?php echo $event_name ?>" minlength="5" maxlength="50" type="text" class="form-control" name='name' id='name' placeholder="Введите название мероприятия"><br>
                <textarea  maxlength="200" class="form-control" name="comment" id="comment" cols="50" rows="5"><?php echo $event_comment ?></textarea><br>
                <button class="border textu2" type='submit'>Изменить</button>
            </form><br>
            <form action="delete-event-sql.php" method="post">
                <input type="hidden" value="<?php echo $event_id ?>" name="id">
                <button class="border textu2" type='submit'>Удалить</button>
            </form>
        </div>
<?php endif ?>
<?php  $mysql->close;
?>
<?php require "blocks/footer.php" ?>
</body>
</html>