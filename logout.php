<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'init.php';
require_once 'functions.php';

if(!isRequestMethod('get') || !isRequestReferer(url()))
    redirectBackWith('مجاز به انجام این عملیات نمی باشد!');

updateUser($_SESSION['auth']['email'], ['login'=>false]);
unset($_SESSION['auth']['email']);
setcookie('auth', '', date() - 3600, '/');

redirectBack();