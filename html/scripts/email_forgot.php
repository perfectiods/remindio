<?php
require_once 'dbconnect.php';
require_once 'functions.php'; // подключен для доступа к функуии генератора паролей
require_once 'filters.php'; // подключен для доступа к функуии фильтрации e-mail
require_once '/home/optimus/vendor/autoload.php';

function emailRestore() {
  
 global $pdo;
 $data = $_POST;

  // Все действия выполняем только при условии нажатия кнопки "Восстановить"
    if (isset($data['button-remind'])) {
     // Записываем в переменную введенный e-mail и пропускаем через фильтр
     $email_remind_raw = $data["email_remind"];

         if ($email_remind_raw == cleanEmail($email_remind_raw)) { // Если очищенный email равен неочищенному,
         // значит перемнной $email_remind присваиваем его значение
         $email_remind = $email_remind_raw;

         // Сравниваем введенный e-mail с хранящимся в базе
         $query = "SELECT login, email FROM users WHERE email = ?";
         $stmt = $pdo -> prepare($query);
         $stmt -> execute([$email_remind]);
         $user = $stmt -> fetchAll();

         // Извлекаем e-mail, login из базы
         foreach ($user as $row) {
         $found_email = $row['email'];
         $found_login = $row['login'];
         }

             // Если найденный в базе и введенный пользователем адреса совпадали, то:
             if ($found_email = $email_remind) {

             // 1. Создаем код восстановления пароля по E-mail
             $forgot_pass = randomCode(8);
             // Для записи в БД создаем хэш нового пароля
             $forgot_pass_hash = password_hash($forgot_pass, PASSWORD_DEFAULT);

             // 2. Записываем хэш нового пароля в базу
             $query = "UPDATE users SET password = ? WHERE login = ?";
             $stmt = $pdo -> prepare($query);
             $stmt -> execute([$forgot_pass_hash, $found_login]);  

             // 3. Готовим и высылаем письмо
             $message_remind_subject = 'Восстановление пароля';
             $message_remind_body = '
                 Привет, '.$found_login.'! Вы запросили восстановление пароля на сайте ДР проджект.
             Ваш новый пароль: '.$forgot_pass.'

             Если запрос отправлен не Вами, напишите, пожалуйста, нам: bot@remindio.ru
             ';

             // Create the Transport. This site's email
             $transport = (new Swift_SmtpTransport('tls://smtp.yandex.com', 465))
             ->setUsername('bot@remindio.ru') // почта проекта
             ->setPassword('superstring242102')
             ;

             // Create the Mailer using your created Transport
             $mailer = new Swift_Mailer($transport);

             // Create a message
             $message = (new Swift_Message($message_remind_subject))
             ->setFrom(['bot@remindio.ru' => 'Remindio']) // почта и имя проекта
             ->setTo([$found_email => $found_login])
             ->setBody($message_remind_body)
             ;

             // Send the message
             $result = $mailer->send($message);
      
             // Перенаправлем на страницу reg_auth
             $_SESSION['password_forgot_msg'] = 'Письмо с инструкцией по восстановлению пароля отправлено. Пожалуйста, проверьте Вашу почту.';
              header('Location: /include/reg-auth.php');

             } else {
             $_SESSION['password_forgot_msg'] = 'E-mail не найден. Пожалуйста, попробуйте еще раз или обратитесь в поддержку: bot@remindio.ru';
             header('Location: /include/reg-auth.php');
             exit();
             }
  
         } else { // в противном случае, если введен email с запрещенными символами выходим с ошибкой
         $_SESSION['password_forgot_msg'] = 'Ошибка! Введите корректный e-mail.';
         header('Location: /include/reg-auth.php');
         exit();
         }
     
     } // end of if iiset button_remind
  
} // end of function

/** 
*  Вызов функции
**/
emailRestore();
