<?php
require_once 'dbconnect.php';

$pass_old = $_POST['password_old']; 
$pass_new = $_POST['password_new'];
$loged = $_SESSION['auth_name'];

if (isset($_POST['change'])) {
  
$errors = array();
  if ($_POST['password_old'] == '' ) {
    $errors[] = 'Введите текущий пароль';
  }
  if ($_POST['password_new'] == '' ) {
    $errors[] = 'Введите новый пароль';
  }
  // Проверка на то, чтоб старый был не равен новому
  if ($_POST['password_new'] == $_POST['password_old']) {
    $errors[] = 'Новый и старый пароли не должны совпадать!';
  }
  

 if (empty($errors)) {
  $sql = "SELECT password FROM users WHERE login=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$loged]);
  $pwd = $stmt->fetch();
   
  // Для записи в БД создаем хэш нового пароля
  $pass_new_hash = password_hash($pass_new, PASSWORD_DEFAULT);
   
   // Если в базе пароль существует и введенный текущий пароль равен извлеченному из базы (хэш котрого расшифровывается тут)
    if ($pwd && password_verify($_POST['password_old'], $pwd['password'])) {    
         
       $query = "UPDATE users SET password=? WHERE login=?";
       $stmt2 = $pdo->prepare($query);
       $stmt2->execute([$pass_new_hash, $loged]);
      
       $_SESSION['password_changed'] = 'Ваш пароль успешно изменен!';
       header('Location: /include/cabinet.php');
       exit();
        
    } else {
       $_SESSION['password_not_changed'] = 'Ошибка при смене пароля!';
       header('Location: /include/cabinet.php');
       exit();
    }
   
  } else {
    $_SESSION['password_not_changed'] = array_shift($errors);
    header('Location: /include/cabinet.php');
    exit();
  }
 
}

?>
