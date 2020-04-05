<?php
require_once 'dbconnect.php';
require_once 'filters.php';
require_once 'crypt.php';

$day_remind1; $day_remind2; $day_remind3;
$loged = $_SESSION['auth_name']; 

/******
*
* Класс из 5-ти методов: 
* 1) вычисления за сколько дней до ДР уведомить, 2) добавления именника в БД, 
* 3) удаления именинника из БД, 4) пересчета дат уведомлений, 5) показа таблицы именинников
*
******/

class DR_Class { 
 /**
 * Метод первичного вычисления дат напоминаний
 **/
 public function countDays() {

   global $day_remind1, $day_remind2, $day_remind3; // заданы ч/з Global, чтобы были доступны в другом методе AddImen

    if (isset($_POST['button_ok']) && ($_POST['select1'])) { // если кнопка Готово! нажата и выбрана опция из первого обязательного выпадающего списка
      
      $currenttime = time(); // текущее время на сервере (в формате timestamp) , елсли нужно своее, то укзать вначале date_default_timezone_set('Australia/Melbourne');

      // Д.р., выбранная пользователем (вероятно, введет настоящий год, напр. 1990)
      $birthday = $_POST["birthday"]; 
      
      // Заменяем год на 2018 для работы скрипта уведомления
      $birthday = substr_replace($birthday, "2018", 0, 4); // изменяемое, на что изменяем, с какой позиции, сколько символов
      
      // Число дней, за сколько до д.р. выслать напоминание №1,2,3
      $days_before1 = $_POST["select1"]; 
      $days_before2 = $_POST["select2"];
      $days_before3 = $_POST["select3"];
      
      // Конвертируем дату в формат timestamp
      $birthday = strtotime($birthday);
      
      // Проверка, на то, что выбрана дата в будущем, сравнивается заменная Д.Р. (2018) с текущим временем
      if ($birthday >= $currenttime) { 
      // $GLOBALS['day_remind1'] = $birthday - ($days_before1 * 86400); // напоминание варианта с GLOBALS
        $day_remind1 = $birthday - ($days_before1 * 86400); // дата, когда сработает напомниание (в формате timestamp)
        $day_remind2 = $birthday - ($days_before2 * 86400); 
        $day_remind3 = $birthday - ($days_before3 * 86400);

        // Конвертируем в формат даты для читаемого отображения пользователю
        $day_remind1 = date('Y-m-d', $day_remind1);
        $day_remind2 = date('Y-m-d', $day_remind2);
        $day_remind3 = date('Y-m-d', $day_remind3);
        
        $this->addImen();  //  внутри нашего метода countDays вызываем метод addImen - записываем именинника в БД
      
      } else {
        $_SESSION['msg'] = "День рождения должен быть в будущем!";
        header('Location: /index.php');
        //exit();
      }
      
    } // end if (isset($_POST['button_ok']) && ($_POST['select1'])) {
   
 } // end public function


    
 
  /**
  * Метод добавления именника в БД
  **/
  public function addImen() {
  
    global $pdo, $loged, $day_remind1, $day_remind2, $day_remind3; // заданы ч/з Global, чтобы были доступны в методе AddImen
    
    if (!empty($loged)) { // Ф-ия должна оотрабатывать только для зарег-го пользователя
      
      $name = $_POST["name"];
      $surname = $_POST["surname"];
      $date = $_POST["birthday"];
          
      // Заменяем год на 2018
      $date = substr_replace($date, "2018", 0, 4); // изменяемое, на что изменяем, с какой позиции, сколько символов

      // Записываем из формы $select1-3 для последующей их записи в БД и дальнейшего показа пользователю
      $select1 = $_POST['select1'];
      $select2 = $_POST['select2'];
      $select3 = $_POST['select3'];

      // Кроме них будем записывать в БД $day_remind1-3, вычисляемые ф-ей CountDays(), а потом будем выводить также и их
      // для более наглядной информации пользователю

      // Если кнопка Готово! нажата, то:
      if (isset($_POST['button_ok'])) {
      // Проверка данных именинника
        $errors = array();
          if (trim($name) == '') {
            $errors[] = 'Как зовут именинника?';
          }
          if (trim($surname) == '') {
            $errors[] = 'Фамилия именинника?';
          }
          if(strlen($date) != 10) {
            $errors[] = 'День рождения именинника?';
         }

        // Если ошибок при введении данных нет, можно вносить в БД имя, фамилию, ДР, а также Day_remind1-3, вычисленные ранее в ф-ии CuntDays()
          if (empty($errors)) {
           
            // Пропускаем введенное через фильтрующую функцию (имя, фамилия)
            $name = cleanTxt($name);
            $surname = cleanTxt($surname);
            
            // Шифруем записываемые данные (имя, фамилия)
            $name = encryptName($name);
            $surname = encryptName($surname);
            
            // Воспользуемся методом PDO::quote(), чтобы преобразовать введённый пользователем текст в форму, 
            // допустимую для помещения в SQL-запрос и тем самым предотвратить так называемую «SQL-инъекцию».
            $sql = "INSERT INTO birthday_table (name, surname, birthday, login, select1, select2, select3, 
            day_remind1, day_remind2, day_remind3) VALUES (" . $pdo->quote($name) . ", " . $pdo->quote($surname) . ", 
            " . $pdo->quote($date) . ", " . $pdo->quote($loged) . ", " . $pdo->quote($select1) . ", 
            " . $pdo->quote($select2) . ", " . $pdo->quote($select3) . "," . $pdo->quote($day_remind1) . ", 
            " . $pdo->quote($day_remind2) . ", " . $pdo->quote($day_remind3) . ")";
            // use exec() because no results are returned
            $pdo->exec($sql);
            
            // Создаем сессию с сообщением, в нее помешаем сообщение об успешной записи. Выводим ее на index.php
            $_SESSION['msg'] = 'Именинник записан!';
            // Делаем переадресацию на index.php
            header('Location: /index.php');
            exit;

          } else { // end if empty errors
            // В эту же ссеесию записываем массив с кодами ошибок
            $_SESSION['msg'] = array_shift($errors);
            header('Location: /index.php');
            exit;
          }
      } //end if iiset POST button_ok
   
    } else {  // end of if (!empty($_SESSION['auth_name'])) {
     $_SESSION['msg'] = "Пожалуйста, вначале войдите на сайт";
     header('Location: /index.php');
     exit;
    }
    
  } // end of function AddImen()

  
  /**
  * Метод удаления именника из БД
  **/
  /*
  public function deleteImen() {
    
    global $pdo;

    $id = $_POST['id'];

      $del = "DELETE FROM birthday_table WHERE id = :id";
      $stm = $pdo -> prepare($del);
      $stm->bindValue(':id', $id);
      $stm->execute(); 
        
  } // end of function DeleteImen()
 */
  
 
  
  
  
  
 /**
 * Метод вывода на экран таблицы именинников, введенных пользователем
 **/
 public function showImen() {
    
    global $pdo, $loged, $day_remind1_updated, $day_remind2_updated, $day_remind3_updated;
    global $show, $id, $value, $k;

     if (!empty($loged)) { // Ф-ия должна оотрабатывать только для зарег-го пользователя
        
        //  require_once '/home/cabox/workspace/download/a/birthdays.php';
        //  header('Location: /download/a/birthdays.php');
        //  exit;
        // Извлекаем из базы данные для показа в таблице
        $stmt2 = $pdo->prepare("SELECT * FROM birthday_table WHERE login=?");
        $stmt2->execute([$loged]);
        $show = $stmt2->fetchAll();

   }  // end of if (!empty($loged))

  } //end of function 
  
} // end calss DR_Class


require_once dirname(dirname(__FILE__)) . '/scripts/count.php';
 
   

// Создаем объект obj и вызываем методы CountDays и CountDaysNewData
$obj = new DR_Class();
$obj -> countDays();
$obj-> showImen();
//$obj -> deleteImen();