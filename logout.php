<?php
session_start();

unset($_SESSION['login']);

echo "<script type='text/javascript'> document.location = 'index.php'; </script>";