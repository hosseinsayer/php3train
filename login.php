<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'init.php';
require_once 'functions.php';

if(!isRequestMethod('post') || !isRequestReferer(url()))
    redirectBackWith('مجاز به انجام این عملیات نمی باشد!');

// validate
if (empty(input('email')))
    redirectBackWith('ایمیل را وارد نمایید!');
if (empty(input('password')))
    redirectBackWith('رمز عبور را وارد نمایید!');

// check email exist
$user = getUser(input('email'));
if(!$user)
    redirectBackWith('اطلاعات ورود اشتباه می باشد!');

// check password
if($user->password != md5(input('password')))
    redirectBackWith('اطلاعات ورود اشتباه می باشد!');

login(input('email'));
