<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Добавление оценок</title>
</head>
<body>
<?php require "blocks/header.php" ?>
<?php if($_COOKIE['teacher']!=''): ?>
<?php 
    if($_POST){
        $id_subject = $_POST['id_subject'];
    }else{
        $id_subject = $_COOKIE['subject'];
    }
    $today = date("Y-m-d");
    $mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
    $result = $mysql->query("SELECT Наименование FROM `предмет` WHERE `Код`='$id_subject'");
    $subject = $result->fetch_assoc();
    $subject = $subject['Наименование'];
    $result = $mysql->query("SELECT * FROM `класс` WHERE 1 ORDER BY id");
    $class = [];
    $id_class = [];
    while ($row = $result->fetch_assoc()){
        $id_class[] = $row["id"];
        $class[] = $row["Название"];
    }
?>
    <p class="p">>Вы хотите добавить оценку по предмету: <?php echo $subject;?></p>
    <form action="add-grade.php" method="POST">
        <p class="p">Выберите класс:</p>
        <input type="hidden" name="id_subject" value="<?php echo $id_subject ?>"></input>
        <select name="class" id="class">
        <?php for($i=0;$i<count($class);$i++){ ?>
            <option value="<?php echo $id_class[$i] ?>" <?php if ($id_class[$i]==$_POST['class']||$id_class[$i]==$_COOKIE['class']){echo 'selected';}  ?>><?php echo $class[$i] ?></option>
        <?php } ?>
        </select>
        <button type='submit' style='btn btn-success'>Выбрать</button>
    </form>
<?php 
    if($_POST['class']||$_COOKIE['class']):
        if($_POST){
            $id_class = $_POST['class'];
        }else{
            $id_class = $_COOKIE['class'];
        }
        $result = $mysql->query("SELECT Код, Фамилия, Имя FROM `ученик` WHERE `Класс_id`='$id_class' ORDER BY Фамилия");
        $firstnames= [];
        $lastnames = [];
        $id_stud = [];
        while ($row = $result->fetch_assoc()){
            $firstnames[] = $row["Имя"];
            $lastnames[] = $row["Фамилия"];
            $id_stud[] = $row["Код"];
        }
        ?>
        <form action="add-grade-sql.php" method="POST">
            Выберите Дату:
        <input type="date" name="date-grade" value="<?php echo $today ?>">
        <input type="hidden" name="subject" value="<?php echo $id_subject ?>">
            <table>
        <?php
        for($i=0;$i<count($firstnames);$i++){ 
            ?> <tr> <?php 
            echo '<td>'.$lastnames[$i]." ".$firstnames[$i].'</td>';
            ?>
        <td>
            <input type="hidden" name="class" value="<?php echo $id_class?>">
            <input type="hidden" name ="student<?php echo $i?>" value = "<?php echo $id_stud[$i]?>">
            <select name="grade<?php echo $i?>">
                <option value="No" selected>Нет</option>
                <?php for ($j=5;$j>1;$j--){
                ?>
                <option value="<?php echo $j ?>"><?php echo $j ?></option>
                    <?php } ?>
            </select>
        </td>
        </tr> <?php 
        }
?>
</table>
<input type="hidden" name="size" id="size" value="<?php echo count($firstnames)?>">
<button type='submit' style='btn btn-success'>Добавить</button>
</form>
<?php 
endif;
else: echo "Простите, кажется, у вас нет прав здесь находиться";
endif; 
    $mysql->close;
    setcookie('class', $_POST['class'], time() - 60,'/');?>
<?php 
require "blocks/footer.php" ?>
</body>
</html>