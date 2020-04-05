<?php
require_once 'functions.php';
 
findBirth();
//date_default_timezone_set("Europe/Kaliningrad");

$date = date('l jS \of F Y h:i:s A');

$myfile = fopen("/var/www/remindio.ru/html/newfile.txt", "w") or die("Unable to open file!");
$txt = "Cron worked. Script started.".$date;
fwrite($myfile, $txt);

?>
