<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Сетевая среда "Школа №49"</title>
</head>
<body>
<?php require "blocks/header.php" ?>
    
    
    <?php if($_COOKIE['teacher']!=''): ?>
    <p class="p">Ваши предметы:
    <?php 
    $login = $_COOKIE['teacher'];
    $mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
    $result = $mysql->query("SELECT Код FROM `учителя` WHERE `login`='$login'");
    $id_teacher = $result->fetch_assoc();
    $id_teacher = $id_teacher['Код'];
    $result = $mysql->query("SELECT Предмет_Код FROM `предмет_has_учителя` WHERE `Учителя_Код`='$id_teacher'");
    $id_subject = [];
    while ($row = $result->fetch_assoc()){
        $id_subject[] = $row["Предмет_Код"];
    }
    for ($i=0;$i<count($id_subject);$i++){
        $result = $mysql->query("SELECT Наименование FROM `предмет` WHERE `Код`='$id_subject[$i]'");
        $subject = $result->fetch_assoc();
        $subject = $subject['Наименование'];
        echo $subject." ";
    }
    $today = date("Y-m-d");
    ?></p><div class="container mt-4">
    <form action="journal.php" method="post">
        <?php
        if($_POST){
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
        }else{
            $date1 = '1999-01-01';
            $date2 = $today;
        }
        $result = $mysql->query("SELECT * FROM `класс` WHERE 1 ORDER BY id");
    $class = [];
    $id_class = [];
    while ($row = $result->fetch_assoc()){
        $id_class[] = $row["id"];
        $class[] = $row["Название"];
    }
        ?>
        <p class="p">Введите даты, за которые необходимо вывести оценки:</p>
        <select name="class" id="class">
        <?php
        for($i=0;$i<count($class);$i++){ ?>
            <option value="<?php echo $id_class[$i] ?>" <?php if ($id_class[$i]==$_POST['class']||$id_class[$i]==$_COOKIE['class']){echo 'selected';}  ?>><?php echo $class[$i] ?></option>
        <?php } ?>
        </select>
        <input type="date" class="form-control" name="date1" id="date1" value='<?php if($_POST){echo $_POST['date1'];}else{echo '1999-01-01';} ?>'>
        <input type="date" class="form-control" name="date2" id="date2" value='<?php if($_POST){echo $_POST['date2'];}else{echo $today;} ?>'>
        <button type='submit' style='btn btn-success'>Показать</button>
    </form>
    <p class="p">Нынешний диапазон дат:</p><?php echo $date1." - ".$date2 ?>
</div>
    <div class="container">
        <?php
            for ($i=0;$i<count($id_subject);$i++){
                $result = $mysql->query("SELECT Наименование FROM `предмет` WHERE `Код`='$id_subject[$i]'");
                $subject = $result->fetch_assoc();
                $subject = $subject['Наименование'];
        ?>
        
        <p class="p">
            
            <?php
            echo $subject;
            ?>
        </p><div class="container">
            <form action="add-grade.php" method="POST">
                <input type="hidden" value="<?php echo $id_subject[$i]; ?>" name="id_subject">
                <button type='submit' style='btn btn-success mt-4'>Добавить оценку</button><br><br>
            </form>
            <form action="delete-grade.php" method="POST">
                <input type="hidden" value="<?php echo $id_subject[$i]; ?>" name="id_subject">
                <button type='submit' style='btn btn-success mt-4'>Изменить оценку</button><br><br>
            </form>
        </div>
        <table>
        <?php
            $result = $mysql->query("SELECT Ученик_Код FROM `предмет_has_ученик` WHERE `Предмет_Код`='$id_subject[$i]'");
            $id_student = [];
            while ($row = $result->fetch_assoc()){
                $id_student[] = $row["Ученик_Код"];
            }
            $student_id = [];
            $lastnames = [];
            $firstnames = [];
            for ($j=0;$j<count($id_student);$j++){
                $student_class = $_POST['class'];
                if (!$_POST){
                $result = $mysql->query("SELECT Код, Фамилия, Имя FROM `ученик` WHERE `Код`='$id_student[$j]'");}else{
                    $result = $mysql->query("SELECT Код, Фамилия, Имя FROM `ученик` WHERE `Код`='$id_student[$j]' AND `Класс_id`='$student_class'");
                }
                $student = $result->fetch_assoc();
                $student_id[] = $student['Код'];
                $lastnames[] = $student['Фамилия'];
                $firstnames[] = $student['Имя'];}
                ?>
                <tr>
                <?php for ($j=0;$j<count($student_id);$j++){?>
                <td>
                <?php
                echo $lastnames[$j]." ".$firstnames[$j];
                ?></td>
                <?php
                $sum=0;
                $kol=0;
                $grades = [];
                $result = $mysql->query("SELECT Оценка FROM `сводная ведомость` WHERE `Предмет_Код`='$id_subject[$i]' AND `Ученик_Код`='$student_id[$j]' AND `Дата` BETWEEN '$date1' AND '$date2' ORDER BY Дата");
                while ($row = $result->fetch_assoc()){
                    $grades[] = $row["Оценка"];
                }
                for ($k=0;$k<50;$k++){ 
                    if ($k<count($grades)){
                    $sum = $sum + $grades[$k];
                    $kol++;?>
                <td>
                <?php
                    echo $grades[$k]; ?>
                    </td>
                    <?php
                    }else { ?>
                    <td>
                        </td>
                        <?php } ?>
                
                        <?php }
                ?>
                <td><?php if (count($grades)!=0){echo round($sum/$kol, 2);} else {echo 0;} ?></td>
            </tr>
                <?php
            }
        ?>
        </table>
    <?php } ?></div>
    <?php elseif($_COOKIE['student']!=''): ?><div class="container"> <form action="journal.php" method="post">
        <?php
        $today = date("Y-m-d");
        if($_POST){
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
        }else{
            $date1 = '1999-01-01';
            $date2 = $today;
        }
        ?>
        <p class="p">Введите даты, за которые необходимо вывести оценки:</p>
        <input type="date" class="form-control user-form" name="date1" id="date1" value='<?php if($_POST){echo $_POST['date1'];}else{echo '1999-01-01';} ?>'><br>
        <input type="date" class="form-control user-form" name="date2" id="date2" value='<?php if($_POST){echo $_POST['date2'];}else{echo $today;} ?>'><br>
        <button type='submit' style='btn btn-success'>Показать</button><br>
    </form>
    <text><p class="p">Нынешний диапазон дат:</p>   </text><p class="p"><?php echo $date1." - ".$date2 ?></p><br><br>

        
    <?php 
    $login = $_COOKIE['student'];
    $mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
    $result = $mysql->query("SELECT Код FROM `ученик` WHERE `login`='$login'");
    $id_student = $result->fetch_assoc();
    $id_student = $id_student['Код'];    
    $result = $mysql->query("SELECT Предмет_Код FROM `предмет_has_ученик` WHERE `Ученик_Код`='$id_student'");
    $id_subject = [];
    while ($row = $result->fetch_assoc()){
        $id_subject[] = $row["Предмет_Код"];
    }
    $subject = [];
    for($i=0;$i<count($id_subject);$i++){
        $id = $id_subject[$i];
        $result = $mysql->query("SELECT Наименование FROM `предмет` WHERE `Код`='$id'");
        $subject[] = $result->fetch_assoc()['Наименование'];
    }
    ?> 
    <table>
    <?php for($i=0;$i<count($id_subject);$i++) {
        $result = $mysql->query("SELECT Оценка FROM `сводная ведомость` WHERE `Предмет_Код`='$id_subject[$i]' AND `Ученик_Код`='$id_student' AND `Дата` BETWEEN '$date1' AND '$date2' ORDER BY Дата");
        $grades = [];
        $sum =0;
        $kol = 0;
        while ($row = $result->fetch_assoc()){
            $grades[] = $row["Оценка"];
        }
        ?>
        <tr>
            <td><?php echo $subject[$i] ?></td><?php for ($k=0;$k<50;$k++){ ?>
                <td>
                <?php
                    if ($k<count($grades)){echo $grades[$k];
                        $sum = $sum+$grades[$k];
                        $kol++;} ?>
                    </td>
                    <?php
                }
                ?>
                <td><?php if (count($grades)!=0){echo round($sum/$kol, 2);} else {echo 0;} ?></td>
        </tr>
    <?php }?>   
    </table></div>
    <?php endif; 
    $mysql->close;?><br><br><br><br><br><br><br><br><br><br>
    <?php require "blocks/footer.php" ?>
</body>
</html>