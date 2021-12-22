<?php
unset($_SESSION['id']);
setcookie ("PHPSESSID", $_COOKIE['PHPSESSID'], time() - 864000, '/');
session_destroy();
 ?>
