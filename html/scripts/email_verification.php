<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход/Регистрация</title>    
    <link rel="stylesheet" type="text/css" href="/www/css/style_verify.css">
  </head>

<?php include require dirname(dirname(__FILE__)) . '/include/header.php'; ?>

 
<?php require_once 'dbconnect.php';

function emailValidate() {
  
  global $pdo;
  
  if(isset($_GET['activation_code'])) {

  // Сравниваем код активации, который получаем из адресной строки методом GET (пользователь нажал на ссылку в письме), с хранящимся в базе

    $query = "SELECT * FROM users WHERE activation_code = :activation_code";
    $statement = $pdo->prepare($query);
    $statement->execute(
      array(
        ':activation_code' => $_GET['activation_code']
      )
    );
    $no_of_row = $statement->rowCount();

    // Если код активации найден в базе, то обновляем email_status со значения 0 на 1, то есть пользователь становится подтвержденным:
    if ($no_of_row > 0) {

      $result = $statement->fetchAll();

      foreach($result as $row) {

        $id = $row['id'];
        $one = 1;

        if ($row['email_status'] == '0') {

          $update_query = "UPDATE users SET email_status = ? WHERE id = ?";  // WHERE id = '".$row['id']."'
          $statement = $pdo->prepare($update_query);  
          $statement->execute([$one,$id]);

          $_SESSION['msg'] = 'Учетная запись успешно активирована. Пожалуйста, <a href = "/include/reg-auth.php">войдите</a> на сайт, чтобы начать с ним работать';

          // Сразу после активации учетной записи, создаем сессию для привествия нового пользователя в левом верх
          $_SESSION['auth_name'] = $data['login'];

        } else {
            $_SESSION['msg'] = 'Ваша учетная запись уже была активирована. Вы уже можете приступать к работе с сайтом! <a href = "/include/reg-auth.php">Войти</a>';
            //header('Location: /download/a/reg-auth.php');

        }
      }
    // Если код не найден в базе: 
    } else {
        $_SESSION['msg'] = 'Неверный код активации. Пожалуйста, попробуйте еще раз или обратитесь в поддержку: bot@remindio.ru';
      //header('Location: /download/a/reg-auth.php');

    }
  }
  
}
  
emailValidate();

?>
  
    <body>
    <div id="message_verify">
      <p><?php echo $_SESSION['msg']; ?><?php echo $_SESSION['msg']=''; ?></p>
    </div>
  </body>
