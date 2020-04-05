<?php
//require_once '/home/cabox/workspace/download/a/dbconnect.php';
require_once dirname(__FILE__) . '/scripts/count.php';

//$loged = $_SESSION['auth_name']; 


countDaysNewData();

      
      /*
      
        foreach ($res as $key=>$row) {
           $days_before1_updated = $res[0]['select1'];  //0й элемент столбца select1
           $days_before2_updated = $res[1]['select1']; // 1ый элемент столбца select1
           $days_before3_updated = $res[2]['select1'];  // 2ый элемент столбца select1
           //$birthday_from_db = $res[0]['select1']; //так он выводит последний ДР столбца Birthday
        }
         
       // $res[0]['select1']; - это 0ой элемент колонки birthday
       $birthday_from_db = $res[0]['birthday']; // 0о1 элемент столбца birthday - то есть первая строка, первый человек
       //$birthday_from_db = $res[1]['birthday'];
       //$birthday_from_db = $res[2]['birthday'];
       
 echo "days_before1_updated: " . $days_before1_updated;
 echo "<br>";
 echo "birthday of first man: " . $res[0]['birthday'];
 echo "days_before2_updated: " . $days_before2_updated;
 echo "<br>";
 echo "birthday of second man: " . $res[1]['birthday'];
      
      
       // Расчеты дат оповещения происходят только для первоого человека
      
       // конвертируем день рождени в формат timestamp
       $birthday_from_db = strtotime($birthday_from_db);
    
      
       // рассчитываем дни уведомлени в timestamp
       $day_remind1_updated = $birthday_from_db - ($days_before1_updated * 86400);
       $day_remind2_updated = $birthday_from_db - ($days_before2_updated * 86400); 
       $day_remind3_updated = $birthday_from_db - ($days_before3_updated * 86400);
      

       // конвертируем дни уведомления из timestamp в даты
       $day_remind1_updated = date('Y-m-d', $day_remind1_updated);
       $day_remind2_updated = date('Y-m-d', $day_remind2_updated);
       $day_remind3_updated = date('Y-m-d', $day_remind3_updated);
     // var_dump($day_remind1_updated); // после F5 расчитывает и показывает верно
      
  echo "day_remind1_updated after calculus: " . $day_remind1_updated; echo "<br>";
  echo "day_remind2_updated after calculus: " . $day_remind2_updated;
     // echo "Сейчас он вычисляе день упоминания от крайнего нижнего члена столбца дней рождения";
*/
      
        // Принимаем AJAX-переменные для возможности по клику изменять ячейки таблицы
/*        
$id = $_POST['id'];

        // Формируем запрос в БД на изменение хранящихся "дней до" на вновь введенные, а дат уведомлений на вновь пересчитанные
        $sql = "UPDATE birthday_table SET day_remind1=?, day_remind2=?, day_remind3=? WHERE id=?";
        $stmt3 = $pdo->prepare($sql);
        $stmt3->execute([$day_remind1_updated, $day_remind2_updated, $day_remind3_updated, $id]);

        $db_handle = new DBController();
        $result = $db_handle->executeUpdate("UPDATE birthday_table SET " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id=".$_POST["id"]);;
   */   
   // } // end if (!empty($loged))
    
  //} // end of function
      


  

//countDaysNewData();


?>