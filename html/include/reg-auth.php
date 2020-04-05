<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход/Регистрация</title>    
    <link rel="stylesheet" type="text/css" href="/www/css/style_reg.css">
  </head>
  
<?php

  include 'header.php'; 

  require dirname(dirname(__FILE__)) . '/scripts/reg.php';
  require dirname(dirname(__FILE__)) . '/scripts/auth.php';

?>

<body>
  <div class="wrapper">
    <div class="container">
      <div class="child">
        <h2 class="h2-title">Регистрация на сайте</h2>
        
        <form id="form-reg" action="../scripts/reg.php" method="POST">
          <!--<p id="reg_message"></p>-->
          <div id="block-form-reg">
              <input type="text" name="login" id="login" placeholder="Логин" value="<?php echo @$data['login'];?>">
              
              <input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo @$data['email'];?>">
              
              <input type="password" name="password" id="password" placeholder="Пароль" value="<?php echo @$data['password'];?>">
              
              <p id="confident"> Соглашаюсь с <a href="../include/confidentiality.php">Политикой конфиденциальности</a></p>
                
              <img alt="Verification code"
                   width="<?= $captcha->width ?>"
                   height="<?= $captcha->height ?>"
                   src="<?= $captcha->generateImage($code) ?>"
               >
              <input type="text" size="5" name="code">
              <input type="submit" name="reg-submit" id="reg-submit" value="Зарегистрироваться">
          </div>
        </form>
        
        <div id="error_verify">
            <?php echo $_SESSION['err_verify']; ?><?php echo $_SESSION['err_verify']="";?>
          </div>
        
        <div id="error_reg_validate">
          <?php echo $_SESSION['err_reg_validate']; ?><?php echo $_SESSION['err_reg_validate']="";?>
        </div>
      </div>


      <div class="child">
        <form action="../scripts/auth.php" method="POST">
          <h2 class="h2-title-auth">Авторизация</h2>

              <center><input type="text" id="login_auth" name="login_auth" placeholder="Логин" value="<?php echo @$data['login_auth']; ?>"></center>

              <center><input type="password" id="password_auth" name="password_auth" placeholder="Пароль" value="<?php echo @$data['password_auth']; ?>"></center>

              <!--<center><input type="checkbox" name="rememberme" id="rememberme"><label for="rememberme">Запомнить меня</label></center>-->
          
              <center><input type="submit" name="enter-auth" id="enter-auth" value="Войти"></center>
          
          <div id="error_auth">
            <?php echo $_SESSION['err_auth']; ?><?php echo $_SESSION['err_auth']="";?>
          </div>
          
        </form>
          <div id="error_verify">
            <?php echo $_SESSION['err_verify']; ?><?php echo $_SESSION['err_verify']="";?>
          </div>
          
          <div id="error_auth_validate">
            <?php echo $_SESSION['err_auth_validate']; ?><?php echo $_SESSION['err_auth_validate']="";?>
          </div>

          <form action="../scripts/email_forgot.php" method="POST">
            <h3 class="h3-class-reset">Восстановление пароля</h3>
            <center><input type="text" id="email_remind" name="email_remind" placeholder="Ваш E-mail"></center>
            <center><input type="submit" name="button-remind" id="button-remind" value="Отправить"></center>
          </form>
          
          <div id="password_forgot_msg">
            <?php echo $_SESSION['password_forgot_msg']; ?><?php echo $_SESSION['password_forgot_msg']="";?>
          </div>
          
      </div>
    </div>
  </div>
 </body>
</html>
