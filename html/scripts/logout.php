<?php
require "dbconnect.php";
unset($_SESSION['auth_name']);
header('Location: /index.php');
?>