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
<?php if($_COOKIE['teacher']): ?>
    <div class="container mt-4">
            <h1>Добавление мероприятия</h1>
            <form action="add-event-sql.php" method="post">
                <input required type="date" class="form-control" name='date' id='date'><br>
                <input minlength="5" maxlength="50" type="text" class="form-control" name='name' id='name' placeholder="Введите название мероприятия"><br>
                <textarea maxlength="200" class="form-control" name="comment" id="comment" cols="50" rows="5"></textarea><br>
                <button class="border textu2" type='submit'>Добавить</button>
            </form>
        </div>  
<?php endif ?>
<?php require "blocks/footer.php" ?>
</body>
</html>