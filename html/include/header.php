<?php session_start(); ?>
<html>  
 <header>
    
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Allura" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/www/css/style_header.css">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
   
    <nav class="container-fluid">
      <a class="logo" href="/">
        <span>Remindio</span>
      </a>

<?php
  if (($_SESSION['auth_name']) || ($_SESSION['msg'] == 'Учетная запись успешно активирована')) {
    echo '
    <p id="auth-user"><a href="/include/cabinet.php">Привет, '.$_SESSION['auth_name'].'!</a>
    <a href="/scripts/logout.php">Выйти</a></p>
    <p id="service-info"><a href="/include/about.php">О проекте</a></p>
    ';
  } else {
    echo '
    <p id="reg-auth-title"><a href="/include/reg-auth.php">Вход / Регистрация</a></p>
    <p id="service-info"><a href="/include/about.php">О проекте</a></p>';
  }
?>
    </nav>  
 </header>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter50418016 = new Ya.Metrika2({
                    id:50418016,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/50418016" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126090788-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-126090788-1');
</script>



</html>
