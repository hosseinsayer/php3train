<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'init.php';
require_once 'functions.php';

if(!isRequestMethod('post') || !isRequestReferer(url()))
    redirectBackWith('مجاز به انجام این عملیات نمی باشد!');

// validate
if (empty(input('name')))
    redirectBackWith('نام و نام خانوادگی را وارد نمایید!');
if (empty(input('email')))
    redirectBackWith('ایمیل را وارد نمایید!');
if (empty(input('password')))
    redirectBackWith('رمز عبور را وارد نمایید!');
if (empty(input('rePassword')))
    redirectBackWith('تکرار رمز را وارد نمایید!');
if (input('password') != input('rePassword'))
    redirectBackWith('رمز عبور با تکرار آن همخوانی ندار!');

// check email exist
$user = getUser(input('email'));
if ($user)
    redirectBackWith('این ایمیل قبلا ثبت نام کرده است!');

// create user
$status = insertUser(setPropertyUser(input('name'), input('email'), input('password')));

// login or redirect
$status ? login(input('email')) : redirectBackWith('ثبت نام انجام نشد!');