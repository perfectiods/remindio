<?php session_start();

require_once '/home/optimus/vendor/mobicms/captcha/src/Captcha.php';

/** 
*  Функции очистки польз. ввода
**/

function cleanTxt($value = "") {
  $value = trim($value); // Удаляет пробелы в начале и конец строки
  $value = preg_replace('/\s{1,}/','',$value); // Удаляет пробелы, табы и прочие символы, встерчающиеся 1 и более раз с заменой на пустой символ
  $value = implode("",explode("\\",$value)); // Удаляет все \\\, а не только несколько, как stripslashes($value)
  $value = stripslashes(trim($value));
  $value = filter_var($value, FILTER_SANITIZE_STRING);  // Удаляет теги, при необходимости удаляет или кодирует специальные символы
  return $value;
}

function cleanEmail($value = "") {
  $value = filter_var($value, FILTER_SANITIZE_EMAIL); // Удаляет все символы, кроме букв, цифр и !#$%&'*+-=?^_`{|}~@.[].
  $value = filter_var($value, FILTER_VALIDATE_EMAIL); // Проверяет, что значение является корректным e-mail. В целом, происходит проверка синтаксиса адреса в соответствии с RFC 822
  return $value;
}

function checkLength($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}

/** 
*  Функция капчи
**/

function captchaCalc() {
  global $x, $y, $captcha, $code;
  
  $captcha = new Mobicms\Captcha\Captcha;
  $code = $captcha->generateCode();
  $_SESSION['code'] = $code;
  
  //$result = filter_input(INPUT_POST, 'code');
 // $session = filter_input(INPUT_SESSION, 'code');
  $result = $_POST['code'];
  $session = $code;

  if ($result !== null && $session !== null) {
     if (strtolower($result) == strtolower($session)) {
        $x = "solved";
      } else {
        $y = "wrong";
      }
  }
}
captchaCalc();

?>
