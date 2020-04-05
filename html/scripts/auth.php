<?php

require_once 'dbconnect.php';

/**
* AUTORIZATION
**/

// Проверка данных пользователя при его авторизации на сайте
$data = $_POST;
if (isset($data['enter-auth'])) {
  $errors = array();
  if (trim($data['login_auth']) == '' ) {
    $errors[] = 'Введите логин';
    //echo 'Введите логин';
  }
    if (($data['password_auth']) == '' ) {
    $errors[] = 'Введите пароль';
    //echo 'Введите пароль';
  }
  
 // Если поля заполнены, в переменные записываем введенное 
 $login = $data['login_auth'];

 try {
    if (empty($errors)) {
    // Извлекаем из базы логин и пароль, соотвие введенному в форму логину
    // $stmt = $pdo->prepare("SELECT login, password, email_status FROM users WHERE login=?");
    // $stmt->execute([$login]);
    // $user = $stmt->fetch();

    //print_r($user);
      
      $statement=$pdo->prepare("SELECT email_status, password FROM users WHERE login=?");
      $statement->execute([$login]);
      $user=$statement->fetchAll();

       // Если пользователь не найден, то выдаем ошибку и редиректим на ту же страницу входа
       if (empty($user)) {
          $errors[] = 'Логин или пароль введен неверно';
          $_SESSION['err_auth'] = array_shift($errors);
          header('Location: /include/reg-auth.php');
          exit();
       }

          // Извлекаем статус верификации
          foreach($user as $row) {
            $status = $row['email_status'];
            
            // Если статус = 1, то авторизуем, назначаем сессионную переменную с логином, редиректим на главную
            if ($status == '1') {
              
                $_SESSION['err_verify'] = '';

                // password_verify. Первый аргумент - введенный пароль, второй - пароль в базе (хранится его hash, полученная ф-ей password_hash(). 
                // Функция вычисляет хэш введенного пароля (1 аргумент) и сравнивает с хэшем из базы (2 аргумент)

                // Если логин совпал && и пароли сравнены и совпали...
                if ($user && password_verify($data['password_auth'], $row['password'])) {

                 // ...то, логиним пользователя, создаем запись в массиве SESSION, хранящую логин пользователя
                 $_SESSION['auth_name'] = $data['login_auth'];

                 // Перенаправляем на главную после авторизации и проверки статуса верификации
                 header('Location: /index.php');

                } else {
                  $errors[] = 'Логин или пароль введен неверно';
                  $_SESSION['err_auth'] = array_shift($errors);
                  header('Location: /include/reg-auth.php');
                }
                    
            } else { // if status != 1
                $_SESSION['err_verify'] = "Активируйте Ваш аккаунт, перейдя по ссылке из письма";
                header('Location: /include/reg-auth.php');
            }
         
         } //end of foreach
      
          
   } else { // end if empty errors
      // Создаем запись в массиве SESSION, хранящую текст ошибки заполнения полей формы авторизации
      $_SESSION['err_auth_validate'] = array_shift($errors);
      header('Location: /include/reg-auth.php');
      
   }
  
 } catch(PDOException $e) {
    echo $e->getMessage();
 }
} 
?>
