<!DOCTYPE html>
<html>
   <ul class="cb-slideshow">
    <li><span>Image 01</span><div><h3>bir·th·day</h3></div></li>
    <li><span>Image 02</span><div><h3>res·pe·ct</h3></div></li>
    <li><span>Image 03</span><div><h3>hap·py·ness</h3></div></li>
    <li><span>Image 04</span><div><h3>ce·leb·ra·tion</h3></div></li>
  </ul>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>День рождения</title>
    
    <link rel="stylesheet" type="text/css" href="/download/a/www/css/style.css">
    <link rel="stylesheet" type="text/css" href="/download/a/www/css/style_background.css">
    
    <script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js></script>
    <script type="text/javascript" src="/a/www/js/modern.js"></script> 
  </head>
  
 <?php //include '/home/cabox/workspace/download/a/include/header.php';
  include dirname(dirname(__FILE__)) . '/include/header.php';?>
 
 <body>
  <div class="wrapper">
    <form id="wrapper-form" action="../include/birthdays.php" method="POST">
      <h2>Кого поздравляете?</h2>
      <input type="text" placeholder="Имя" name="name">
      <input type="text" placeholder="Фамилия" name="surname">
      <h3>Когда день рождения?</h3>
      <input type="date" name="birthday">
      <h3>За сколько дней выслать напоминание? (Можно выбрать три оповещения)</h3>
      <!-- первый выпадающий список обязателен к выбору -->
      <select name="select1" required>
       <?php
       for ($i = 1; $i <= 20; $i++) {
       echo "<option>".$i."</option>"; 
       }
       ?>
       </select>
       <select name="select2">
       <?php
       for ($i = 1; $i < 21; $i++) {
       echo "<option>".$i."</option>"; 
       }
       ?>
       </select>
       <select name="select3">
       <?php
       for ($i = 1; $i < 21; $i++) {
       echo "<option>".$i."</option>"; 
       }
       ?>
       </select>
      <!--
      <h3>| Или выбрать день напоминания на календаре</h3>
      <input type="date" name="reminder">
      -->
      <br>
      <input type="submit" name="button_ok" id="button_ok" value="Записать">
   
      <?php
        if (!empty($_SESSION['auth_name'])) {
          echo '<input type="submit" class="button" name="show" id="show" value="Показать">';
        }   
      ?>
    </form>

    <div id="message">
      <p><?php echo $_SESSION['msg']; ?><?php echo $_SESSION['msg']=''; ?></p>
    </div>
    
   </div>
  </body> 
 </html>