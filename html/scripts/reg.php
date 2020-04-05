<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once 'dbconnect.php';
require_once 'filters.php';

/**
* REGISTRATION
**/

$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];

// Проверка нажата ли кнопка и заполненны ли поля
if (isset($_POST['reg-submit'])) {
  
  $errors = array();
//if(!empty($login) && !empty($email) && !empty($password)) {
  if (($login) == '' ) {
    $errors[] = 'Введите логин';
    array_shift($errors);
  }
  if (($email) == '' ) {
    $errors[] = 'Введите e-mail';
  }
  if (($password) == '' ) {
    $errors[] = 'Введите пароль';
  }

 // Пропуск введенных данных через фильтрующую функцию
 $login = cleanTxt($login);
 $email = cleanEmail($email);
 $password = cleanTxt($password);
 
 // Проверка на длину // Объединить с проверкой на пустоту, иначе ошибки пустой логин не высвечиваются
 //if (checkLength($login, 3, 10) && checkLength($password, 3, 10) && $email) {

 // Хэширование пароля  
 $pass = password_hash($password, PASSWORD_DEFAULT);
 
 try { 
  // Проверка заполненности полей
      if (empty($errors)) {
        
        // Проверка правильности Капчи
      //   if ($x) { 
            
            // Проверка наличия пользователя с такими же данными
            $stmt = $pdo->prepare("SELECT count(*) FROM users WHERE login=? OR email=?");
            $stmt->execute([$login, $email]);
            $count = $stmt->fetchColumn();
            
               // Если нашли в БД такой логин или эмейл, выходим и выводим ошибку
              if ($count > 0) {
                  $_SESSION['err_reg_validate'] = "Ошибка! E-mail или логин занят!";
                  header('Location: /include/reg-auth.php');
                  exit();
              } else {
                
                // Создаем код верификации по E-mail
                $user_activation_code = md5(rand());
                
                // Фиксируем время и дату регистрации
                $date_reg = date("Y-m-d H:i:s"); // (формат MySQL DATETIME)

                $query = ("INSERT INTO users (login, email, password, activation_code, reg_date) VALUES(?, ?, ?, ?, ?)");
                
                $pdo->prepare($query)->execute([$login, $email, $pass, $user_activation_code, $date_reg]); 
                
               // Создаем ссылку для верификации. Переменные base_url, user_activation_code указываем в почтовой функции
                $base_url = "https://remindio.ru";

                // Создаем сессию, информирующую о необходиомсти активации аккаунта
                $_SESSION['err_verify'] = "На Ваш e-mail выслано письмо для активации аккаунта!";

                // Перенаправляем на страницу reg_ath после регистрации
                header('Location: /include/reg-auth.php'); 

                // После регистрации вызываем ф-ию, отправляющую приветсвенное письмо
                require_once 'functions.php';
                emailGreeting();

                // Если учетная запись активирована порльзователем, то создаем сессию для приветсвия в шапке в левом верхнем углу
                //if ($_SESSION['activation_message'] = 'Учетная запись успешно активирована') {
                 // $_SESSION['auth_name'] = $data['login'];
                //}

              } // end else if count >0
 /*
         } else {
             $_SESSION['err_reg_validate'] = "Вы ввели неверные символы с картинки";
             header('Location: /download/a/reg_auth.php');
             exit();
        }   
  */          
            
     } else { // end if empty errors 
         $_SESSION['err_reg_validate'] = array_shift($errors);
         header('Location: /include/reg-auth.php');
         exit();
     }

} catch(PDOException $e) {
  echo $e->getMessage();
}
 
   
  // } else {
   //   $_SESSION['err_reg_validate'] = "Вы ввели некорретные значения. Длина логина не меньше 3 и не больше 10 символов";
    //  header('Location: /download/a/reg_auth.php');
   //  exit;
  //}
  
} // end if (isset($_POST['reg-submit'])) {
?>
