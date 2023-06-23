<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Удаление оценок</title>
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
    <p class="p">Вы хотите удалить или изменить оценку по предмету: <?php echo $subject;?></p>
    <form action="delete-grade.php" method="POST">
        <p class="p">Выберите класс:</p>
        <input type="hidden" name="id_subject" value="<?php echo $id_subject ?>"></input>
        <select name="class" id="class">
        <?php for($i=0;$i<count($class);$i++){ ?>
            <option value="<?php echo $id_class[$i] ?>" <?php if ($id_class[$i]==$_POST['class']||$id_class[$i]==$_COOKIE['class']){echo 'selected';}  ?>><?php echo $class[$i] ?></option>
        <?php } ?>
        </select>
        <button type='submit' style='btn btn-success'>Выбрать</button>
    </form>
    <?PHP 
    if ($_POST['class']||$_COOKIE['class']){
        if ($_POST['class']){
        $selected_class = $_POST['class'];} else{
        $selected_class = $_COOKIE['class'];
        }
        $student_id = [];
        $name = [];
        $firstname = [];
        $result = $mysql->query("SELECT Код, Фамилия, Имя FROM `ученик` WHERE `Класс_id`='$selected_class'");
        while ($row = $result->fetch_assoc()){
            $student_id [] = $row["Код"];
            $name [] = $row["Имя"];
            $firstname [] = $row["Фамилия"];
        }
        ?>
        <form action="delete-grade.php" method="POST">
        <p class="p">Выберите ученика:</p>
        <input type="hidden" name="id_subject" value="<?php echo $id_subject ?>"></input>
        <input type="hidden" name="class" value="<?php echo $selected_class ?>"></input>
        <select name="student" id="student">
        <?php for($i=0;$i<count($name);$i++){ ?>
            <option value="<?php echo $student_id[$i] ?>" <?php if ($student_id[$i]==$_POST['student']||$student_id[$i]==$_COOKIE['student']){echo 'selected';}  ?>><?php echo $firstname[$i]." ".$name[$i]; ?></option>
        <?php } ?>
        </select>
        <button type='submit' style='btn btn-success'>Выбрать</button>
    </form><?php 
        if ($_POST['student']||$_COOKIE['student']){
            if ($_POST['student']){
            $id_student = $_POST['student'];}else{
            $id_student = $_COOKIE['student'];
            }
            $result = $mysql->query("SELECT id, Дата, Оценка FROM `сводная ведомость` WHERE `Предмет_Код`='$id_subject' AND `Ученик_Код`='$id_student' ORDER BY Дата");
            $id_grade = [];
            $date_grade = [];
            $grade = [];
            while ($row = $result->fetch_assoc()){
                $id_grade [] = $row["id"];
                $date_grade [] = $row["Дата"];
                $grade [] = $row["Оценка"];
            }

            ?>
            <table>
                <?php 
                    for($i=0;$i<count($id_grade);$i++){ 
                ?>
                <tr>
                    <td><?php echo $date_grade[$i] ?></td>
                    
                    <td>
                        <form action="change-grade.php" method="post">
                            <select name="new_grade" id="new_grade">
                                <option value="5" <?php if ($grade[$i]==5){ echo 'selected';} ?>>5</option>
                                <option value="4" <?php if ($grade[$i]==4){ echo 'selected';} ?>>4</option>
                                <option value="3" <?php if ($grade[$i]==3){ echo 'selected';} ?>>3</option>
                                <option value="2" <?php if ($grade[$i]==2){ echo 'selected';} ?>>2</option>
                            </select>
                            <input type="hidden" name="grade_id" id="grade_id" value="<?php echo $id_grade[$i] ?>">
                            <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $id_subject ?>">
                            <input type="hidden" name="selected_class" id="selected_class" value="<?php echo $selected_class ?>">
                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $id_student ?>">
                            <button type='submit' style='btn btn-success'>Изменить</button>
                        </form>
                    </td>
                    <td>
                        <form action="delete-grade-sql.php" method="post">
                            <input type="hidden" name="grade_id" id="grade_id" value="<?php echo $id_grade[$i] ?>">
                            <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $id_subject ?>">
                            <input type="hidden" name="selected_class" id="selected_class" value="<?php echo $selected_class ?>">
                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $id_student ?>">
                            <button type='submit' style='btn btn-success'>Удалить</button>
                        </form>
                        </td>
                        
                </tr>
                <?php } ?>
            </table>
           
           <?php }
    }
    ?>
    <?PHP setcookie('subject', $_POST['subject_id'], time() - 60,'/');
setcookie('class', $_POST['selected_class'], time() - 60,'/');
setcookie('student', $_POST['student_id'], time() - 60,'/');
    $mysql->close;
    setcookie('class', $_POST['class'], time() - 60,'/');?>
<?php 
endif;
require "blocks/footer.php" ?>
</body>
</html>