<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Личный кабинет</title>    
    <link rel="stylesheet" type="text/css" href="/www/css/style.css">
    <link rel="stylesheet" type="text/css" href="/www/css/style_cabinet.css">
  </head>
  
<?php include(realpath(__DIR__) . '/header.php'); ?>

<?php require_once dirname(dirname(__FILE__)) .'/scripts/dbconnect.php'; ?>
<?php require_once dirname(dirname(__FILE__)) . '/scripts/pas_change.php'; ?>
  
<?php

$loged = $_SESSION['auth_name'];

if (isset($_SESSION['auth_name'])) {
  
  $query = "SELECT * FROM users WHERE login=?"; 
  $stmt = $pdo -> prepare($query);
  $stmt -> execute([$loged]);
  $res = $stmt -> fetchAll();
  
  foreach ($res as $row) {
    $email = $row['email'];
  }
  
  $querycount = "SELECT count(*) FROM birthday_table WHERE login=?";
  $stmtcount = $pdo -> prepare($querycount);
  $stmtcount -> execute([$loged]);
  $count = $stmtcount -> fetchColumn(); // подсчет числа записанных именников
}
 
?>
  
  
  
<body>
  <div class="wrapper">
    <div class="container">
      <h2> Ваш личный кабинет </h2>
      <h4 class="info"> Имя: </h4> <p><?php echo $loged;?></p>
      <br>
      <h4 class="info"> E-mail: </h4> <p> <?php echo $row['email'];?></p>
      <h4> Количество именнинников: <?php echo $count;?>. <a href = "/include/birthdays.php">Показать таблицу</a></h4>
          
      <form id="form_pass" action="../scripts/pas_change.php" method="POST">
        <div id="form_pas_change">
          <h4 class="info"> Сменить пароль: </h4>
          <br>
          <input type="password" name="password_old" id="password_old" placeholder="Пароль" value="<?php echo @$data['password'];?>">
          <br>
          <input type="password" name="password_new" id="password_new" placeholder="Новый пароль" value="<?php echo @$data['password'];?>">
          <br>
          <input type="submit" name="change" id="change" value="Изменить">
       </div>
      </form>
      
      <h4 id="subscribe"> Подписаться на обновления проекта </h4>
      <input id="checkbox_cab" name="checkbox_cab" type="checkbox">
      
      <br>
      <h4 class="info"> Написать нам: </h4> <p> bot@remindio.ru </p>


      <div id="pass_change_ok">
         <?php echo $_SESSION['password_changed']; ?><?php echo $_SESSION['password_changed']="";?>
      </div>
        
        <div id="pass_change_err">
          <?php echo $_SESSION['password_not_changed']; ?><?php echo $_SESSION['password_not_changed']="";?>
        </div>
      </div>
      
      <!--
      <input type="checkbox" id="hd-1" class="hide" />
      <label for="hd-1"><h4>Пройти 1-минутный опрос, который поможет нам улучшить сервис</h4></label>
        <div id="opros">
          <form action="/download/a/include/opros.php" method="POST">
 
          <p id="message-remind" class="message-remind-success"></p> <!-- в случае успеха или ошибки выдать это сообщ

          <center><input type="text" id="email" name="email" placeholder="Первый вопрос"></center>
          <center><button type="submit" name="button-remind" id="button-remind">Отправить ответ</button></center>
          <!---formaction="/shop/include/forgot_password.php"
         </div>
       </form>   
     --->
    </div>
  </div>


<div class="footer">
  <a href="/confidentiality.php">Политика конфиденциальности</a>
</div>
  
</body>

</html> 
