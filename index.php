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
    <?php $mysql = new mysqli('std-mysql','std_1918_school','12345678','std_1918_school');
    ?>
    <?php if($_COOKIE['teacher']!=''):?> <br>
    <dl id='ticker'>
      <p class="zag">Новости нашей школы</p>
      <?php 
      $today = date("Y-m-d");
      $result = $mysql->query("SELECT * FROM `мероприятия` WHERE `Дата` BETWEEN '$today' and '2100-12-30' ORDER BY `Дата`"); 
      $event_id = [];
      $event_name = [];
      $event_date = [];
      $event_comment = [];
      while ($row = $result->fetch_assoc()){
        $event_id[] = $row["id"];
        $event_name[] = $row["Наименование"];
        $event_date[] = $row['Дата'];
        $event_comment[] = $row['Примечание'];
    }
    for($i=0;$i<count($event_id);$i++){
      ?>
      <dt><?php echo $event_name[$i] ?></dt><dd><?php echo $event_comment[$i] ?></dd><p class="date"><?php echo $event_date[$i] ?></p><form action="change-event.php" method="POST"><input name="event_id" type="hidden" value="<?php echo $event_id[$i] ?>"><button class="border" type='submit'>Изменить</button><br><br></form>
        
<?php } ?>
<a class="border add textu2" href="add-event.php">Добавить мероприятие</a>
    </dl>
    
    <?php endif ?>
    <?php if($_COOKIE['student']!=''): ?> 
        <dl id='ticker'>
      <p class="zag">Новости нашей школы</p>
      <?php 
      $today = date("Y-m-d");
      $result = $mysql->query("SELECT * FROM `мероприятия` WHERE `Дата` BETWEEN '$today' and '2100-12-30'"); 
      $event_id = [];
      $event_name = [];
      $event_date = [];
      $event_comment = [];
      while ($row = $result->fetch_assoc()){
        $event_id[] = $row["id"];
        $event_name[] = $row["Наименование"];
        $event_date[] = $row['Дата'];
        $event_comment[] = $row['Примечание'];
    }
    for($i=0;$i<count($event_id);$i++){
      ?>
      <dt><?php echo $event_name[$i] ?></dt><dd><?php echo $event_comment[$i] ?></dd><p class="date"><?php echo $event_date[$i] ?></p>
        
<?php } ?>
    </dl>
    <?php endif ?><br><br><br><br><br><br><br><br><br><br>
    <?php $mysql->close; 
    require "blocks/footer.php"; ?>
</body>
</html>