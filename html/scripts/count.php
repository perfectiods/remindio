<?php
require_once 'dbconnect.php';

$loged = $_SESSION['auth_name'];

/**
* Функция пересчета дат уведомлений после интерактивного изменения селектов пользователем
**/

function countDaysNewData() {  // должны быть использованы измененные пользоватлем селекты
    global $pdo, $loged;
    global $result;

  if (!empty($loged)) { // ф-ия должна отрабатывать только для зарег-го пользователя
      // 1. Извлекаем записываемые после AJAX-редактирования пользователем в БД селекты
      $stmt = $pdo->prepare("SELECT select1, select2, select3, birthday FROM birthday_table WHERE login=?");
      $stmt->execute([$loged]);
      $res = $stmt->fetchAll();
     // echo "<pre>".print_r($res, true)."</pre>";
    
     // 2. Делаем вычисления дат уведомлений на основе этих измененных и записанных заново поверх старых селектов
     $index = 1;
     $dateArray = array();
    
     while (isset($res[0][$key = 'select'.$index])) {
       $dateArray[($index++)] = date('Y-m-d', strtotime($res[0]['birthday']) - ($res[0][$key] * 86400));
       // как сделать подсчет для 2 и 3 селектов? ответ в комменте к SO от Lajos Arpad
       // $dateArray[($index++)] = date('Y-m-d', strtotime($res[1]['birthday']) - ($res[1][$key] * 86400));
       // $dateArray[($index++)] = date('Y-m-d', strtotime($res[2]['birthday']) - ($res[2][$key] * 86400));
     }
    
    foreach ($dateArray as $index => $value) {  //$index is the number and $value is the date
  
      //var_dump($dateArray[$index]);     
      /* дает даты day_remind1, 2 ,3 в очищенном виде:
      string(10) "2018-08-02" 
      string(10) "2018-07-26" 
      string(10) "2018-08-03" 
      */
      
      // обязательно что-то должно выводиться на экран, иначе прсто удаляет все
      // это поотму, что АЯКС скрипт слушает файл show,в котром вызывается наша ф-ия countDaysNewData
      //остается вопрос, как в нужной ячейке показать нужное значение

   }
    echo "Обновите страницу для подтверждения";
  
   //echo $dateArray[1]."<br>"; // day_remind1
   //echo $dateArray[2]."<br>"; // day_remind2
   //echo $dateArray[3]."<br>"; // day_remind3
  
  // 3. Записываем вычисленные day_remind1,2,3 в БД, обновляя имеющееся
    
  // Соотносим индексы (в массиве $dateArray индексы идут с 1, а при записи в БД нужно с 0)
  $day[0] = $dateArray[1];
  $day[1] = $dateArray[2];
  $day[2] = $dateArray[3];
  
  //$_SESSION['day0'] = $day[0];$_SESSION['day1'] = $day[1];$_SESSION['day2'] = $day[2];

  //$day = array($dateArray[0], $dateArray[1], $dateArray[2]);
  //print_r($day);
  //print_r($dateArray[$value][$index]);
    
  // Принимаем AJAX-переменные для возможности по клику изменять ячейки таблицы
  $id = $_POST['id'];
  
  // Формируем запрос в БД на изменение хранящихся селектов на вновь введенные, а дат уведомлений на вновь пересчитанные
  $sql = "UPDATE birthday_table SET day_remind1=:day_remind1, day_remind2=:day_remind2, day_remind3=:day_remind3 WHERE id=:id";
  $stmt3 = $pdo->prepare($sql);
  
  $stmt3->bindParam(':day_remind1', $day[0]);
  $stmt3->bindParam(':day_remind2', $day[1]);
  $stmt3->bindParam(':day_remind3', $day[2]);
  $stmt3->bindParam(':id', $id);
  $stmt3->execute();
  
  $db_handle = new DBController();
  $result = $db_handle->executeUpdate("UPDATE birthday_table SET " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id=".$_POST["id"]);
  
  } // end if !empty loged
  
} // end function
?>