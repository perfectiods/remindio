<?php
require_once dirname(dirname(__FILE__)) . '/scripts/DR_class.php';

/*
ini_set('display_errors', 'On');
error_reporting(E_ALL);
*/

?>


<html> 
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>День рождения</title>
    
    <link rel="stylesheet" type="text/css" href="/www/css/style.css">
    <link rel="stylesheet" type="text/css" href="/www/css/style_birthdays.css">
    <link rel="stylesheet" type="text/css" href="/www/css/style_faq.css">
    
    <script src=https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js></script>
    
    <!--<script type="text/javascript" src="/download/a/js/jquery-3.0.0.js"></script>-->
    <script type="text/javascript" src="/www/js/delete.js"></script>
    
   <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>-->
    <script type="text/javascript" src="/www/js/edit_cell.js"></script>
  </head>
  
 <?php include 'header.php'; ?>

  <body>
   <table class="tbl">
     <caption><h3 id="table_title">Записная книжка именинников</h3></caption>
      <thead>
       <tr>
        <th scope="col">Имя</th>
        <th scope="col">Фамилия</th>
        <th scope="col">День рождения</th>
        <th colspan="2">Первое напоминание</th>
        <th colspan="2">Второе напоминание</th>
        <th colspan="2">Третье напоминание</th>
        <th scope="col">Удалить запись</th>
       </tr>
      </thead>
     
     <tbody>
 <?php
      foreach($show as $k=>$value) {
       
       $name = decryptName($value['name']);
       $surname = decryptName($value['surname']);

 ?>
       <div id="birthday-data">
         <tr class="table-row">
          <td aria-label="Имя"> <?php echo $name;?></td>
          <td aria-label="Фамилия"><?php echo $surname; ?></td>
          <td aria-label="День рождения"><?php echo $value['birthday']; ?></td>

          <td aria-label="Первое напоминание" contenteditable="true" onBlur="saveToDatabase(this,'select1','<?php echo $show[$k]["id"]; ?>')" onClick="showEdit(this);"><?php echo $show[$k]["select1"]; ?></td>
          <td id="one"><?php echo $value['day_remind1']; ?></td>
          <td aria-label="Второе напоминание" contenteditable="true" onBlur="saveToDatabase(this,'select2','<?php echo $show[$k]["id"]; ?>')" onClick="showEdit(this);"><?php echo $show[$k]["select2"]; ?></td>
          <td id="two"><?php echo $value['day_remind2']; ?></td>
          <td aria-label="Третье напоминание" contenteditable="true" onBlur="saveToDatabase(this,'select3','<?php echo $show[$k]["id"]; ?>')" onClick="showEdit(this);"><?php echo $show[$k]["select3"]; ?></td>
          <td id="three"><?php echo $value['day_remind3']; ?></td>
          <td align='center'>
             <span class='delete' id='del_<?php echo $show[$k]["id"]; ?>'><img id="delete_img" src="/www/img/delete_icon.png"></span>
          </td>
        </tr>
       </div>
<?php
    }
?>  
    </tbody>
	</table>
    
  <?php include(realpath(__DIR__) . '/faq.php'); ?>
    
 </body>
</html>
<?php include(realpath(__DIR__) . '/footer-confident.php'); ?>
