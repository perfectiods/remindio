<?php
require_once '/home/optimus/vendor/autoload.php';
//require realpath( '/vendor/autoload.php');

/**
*  Функция, реализующая механизм e-mail оповещения о ДР
*  $found_user, $found_email, $text - определены в functions.php
*  в функции findBirth()
**/

function emailReminder() {

  global $found_user, $found_email, $text;

  /*
  Усли  RFC  2822 Error надо проверить, что эти переменные не пустые
  $found_user, $found_email . Тест - присвоить им значения здесь. 
  */

  // Create the Transport
  $transport = (new Swift_SmtpTransport('tls://smtp.yandex.com', 465))
    ->setUsername('bot@remindio.ru')
    ->setPassword('superstring242102')
  ;

  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);

  // Create a message
  $message = (new Swift_Message('Напоминание о дне рождения'))
    ->setFrom(['bot@remindio.ru' => 'Remindio'])
    ->setTo([$found_email => $found_user])
    ->setBody('<p>Привет, '.$found_user.'!</p> <p> '.$text.' </p>', 'text/html')
    ;

// Send message  /* вариант без подсчета сколько сообщений отправилось */
  $res = $mailer->send($message);
  
  // Send message /* вариант с подсчетом и выводом в консоль сколько сообщений отправилось */
  /*
  $failedRecipients = [];
  $numSent = 0;
  $to = [$found_email => $found_user];

  foreach ($to as $address => $name)
  {
    if (is_int($address)) {
      $message->setTo($name);
    } else {
      $message->setTo([$address => $name]);
    }

    $numSent += $mailer->send($message, $failedRecipients);
  }

  printf("Sent %d messages\n", $numSent);
*/


} // end of function

   
/** 
*  Вызов функции производится в functions.php
**/
