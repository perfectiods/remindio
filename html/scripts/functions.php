<?php
require_once 'dbconnect.php';
require_once '/home/optimus/vendor/autoload.php';
//require_once 'crypt.php';

/** 
*  Функция e-mail привествия зарегистрировавшихся пользователей. 
*  Вызывается в reg_auth.php после рег-ии. Использует переменные $email, $login, в которых введенные пользователем контакты
**/

function emailGreeting() {
  global $email, $login, $address, $name, $message, $base_url, $user_activation_code;
  
  $message_subject = 'Приветственное письмо';
  $message_body = '
        Привет, '.$login.'! Поздравлять друзей с днём рождения - это здорово!
    Приветсвуем Вас на нашем сайте и желаем счастливых праздников!
    Для завершения регистрации перейдите, пожалуйста, по этой ссылке - '.$base_url.'/scripts/email_verification.php?activation_code='.$user_activation_code.'
    
    Если запрос на регистрацию отправлен не Вами, просто проигнорируйте это письмо или напишите нам: bot@remindio.ru
    ';
  
  
  // Create the Transport. This site's email
  $transport = (new Swift_SmtpTransport('tls://smtp.yandex.com', 465))
    ->setUsername('bot@remindio.ru') // почта проекта
    ->setPassword('superstring242102')
  ;

  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);
  
  // Create a message
  $message = (new Swift_Message($message_subject))
    ->setFrom(['bot@remindio.ru' => 'Remindio']) // почта и имя проекта
    ->setTo([$email => $login])
    ->setBody($message_body)
  ;

  // Send the message
  $result = $mailer->send($message);
}



/**
 *  Функция сравнения введенной ДР с харнящийся в базе
 **/
function findBirth() {
    // Подключаем почтовую функцию (Отделено от вышезаданной ф-ии)
    require_once 'mail.php';

    global $pdo, $found_user, $found_email, $text;

    $birthday = $_POST['birthday'];
    $currenttime = time(); // текущее время/дата на сервере (timestamp)
    $currenttime = date('Y-m-d', $currenttime); // date format

    $stmt = $pdo -> prepare("SELECT * FROM birthday_table WHERE day_remind1=? OR day_remind2=? OR day_remind3=? OR birthday=?");
    $stmt->execute([$currenttime, $currenttime, $currenttime, $currenttime]); // проверяем, совпадает ли текущая дата с одним из селектов, хр-ся в базе
    $res = $stmt->fetchAll();

    if ($res > 0) {  // если совпадает, то делаем 2 действия:

        foreach ($res as $key => $value) {
            $found_user = $value['login']; // 1. Записываем логин юзера, записавшего этого именника
            $found_record_id = $value['id']; // Записываем id найденных именинников (у которых одна из хранящихся дат сегодня)

            // Подключаем функцию дешифровки
            require_once 'crypt.php';

            // это имя сопоставляем с именем из таблицы users, в которой содержится его e-mail
            $stmt2 = $pdo -> prepare("SELECT * FROM users WHERE login=?");
            $stmt2->execute([$found_user]);
            $res2 = $stmt2->fetchAll();

            if ($res2 > 0) {  // если нашел совпадение логинов в 2 таблицах (что ествественно)
                foreach ($res2 as $key2 => $value2) {
                    $found_email = $value2['email']; // 2. Записываем в перем. email пользователя, записавшего этого именника

                    if ($currenttime == $value['birthday']) {
                        $text = "Сегодня день рождения ".decryptName($res[$key]["name"])." ".decryptName($res[$key]["surname"])."! ";
                        emailReminder();
                    } elseif ($currenttime == $value['day_remind1']) {
                        // СМ В БД, если day_remind 1 указывает на сегодня, тестим эту строку
                        $text = "Через ".$value['select1']." дней будет день рождения ".decryptName($res[$key]["name"])." ".decryptName($res[$key]["surname"])."! "; //decryptName($value['name'])." ".decryptName($value['surname'])
                        emailReminder();
                    }
                    elseif ($currenttime == $value['day_remind2']) {
                        $text = "Через ".$value['select2']." дней будет день рождения ".decryptName($res[$key]["name"])." ".decryptName($res[$key]["surname"])."! ";
                        emailReminder();
                    }
                    elseif ($currenttime == $value['day_remind3']) {
                        $text = "Через ".$value['select3']." дней будет день рождения ".decryptName($res[$key]["name"])." ".decryptName($res[$key]["surname"])."! ";
                        emailReminder();
                    }

                } // end of foreach ($res2 as $key2 => $value2)

            } // end  if ($res2 > 0)

        } //  end of foreach ($res as $key => $value) {

    } // end  if ($res > 0)

} // end of function

/** 
*  Вызов функции происходит в cron.php, который запускается планировщиком Cron
**/


/** 
*  Функция генерации пароля при восст. доступа
**/
function randomCode($limit) {
  return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
}
?>
