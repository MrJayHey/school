<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Вход в аккаунт</title>
</head>
<body>

    <?php require "blocks/header.php" ?>
    <dl id='ticker'><dt>Данные для пробного входа</dt><dd>Логин:ObYxoB Пароль:12345678</dd></dl>
        <div class="container mt-4">
            <h1>Форма авторизации</h1>
            <form action="authorization.php" method="post">
                <input type="text" class="form-control" name='login' id='login' placeholder="Введите логин"><br>
                <input type="password" class="form-control" name='pass' id='pass' placeholder="Введите пароль"><br>
                <p class="p">Должность:</p>
                <input type="radio"  value="учитель" name="radio" id="учитель"><label for="учитель"><p class="p">Учитель</p></label><br>
                <input type="radio"  value="ученик" name="radio" id="ученик" checked="checked"><label for="ученик"><p class="p">Ученик</p></label><br>
                <button class="border textu" type='submit'>Вход</button>
            </form>
        </div>  
    <?php require "blocks/footer.php" ?>
</body>
</html>