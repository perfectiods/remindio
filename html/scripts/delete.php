<?php
/* Этот скрипт не используется, ф-ия определена в классе DR_class*/
require_once 'dbconnect.php';
function DeleteImen() { 
    global $pdo;
    $id = $_POST['id'];
    $del = "DELETE FROM birthday_table WHERE id = :id";
    $stm = $pdo -> prepare($del);
    $stm->bindValue(':id', $id);
    $stm->execute(); 
  } // end of function DeleteImen()
 
DeleteImen();

?>
