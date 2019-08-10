<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="<?= asset('css/semantic.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset('css/style.css') ?>">
</head>
<body>

<!-- menu -->
<div class="ui menu fixed">
    <div class="ui container">
        <a href="#" class="header item">
            <img class="logo" src="<?= asset('img/logo.png') ?>">
            7لرن
        </a>
        <a class="item left">
            <div class="ui buttons">
                <?php if (isLogin()): ?>
                    <button class="ui red button logout">خروج</button>
                <?php else: ?>
                    <button class="ui blue button register">ثبت نام</button>
                    <div class="or" data-text="|"></div>
                    <button class="ui green button login">ورود</button>
                <?php endif; ?>
            </div>
        </a>
    </div>
</div>

<!-- message -->
<?php if (!empty($_SESSION['msg'])): ?>
    <div class="ui main">
        <div class="ui message transition container warning">
            <p><?= $_SESSION['msg'] ?? null ?></p>
        </div>
    </div>
<?php unset($_SESSION['msg']); endif; ?>

<!-- modal -->
<div class="ui mini modal register">
    <div class="header">ثبت نام</div>
    <div class="content">
        <form method="post" action="register.php">
            <label>نام و نام خانوادگی</label>
            <input type="text" name="name">
            <label>ایمیل</label>
            <input type="email" name="email">
            <label>رمز عبور</label>
            <input type="password" name="password">
            <label>تکرار رمز</label>
            <input type="password" name="rePassword">
            <button type="submit" class="ui blue button">ثبت نام</button>
        </form>
    </div>
</div>

<div class="ui mini modal login">
    <div class="header">ورود</div>
    <div class="content">
        <form method="post" action="login.php">
            <label>ایمیل</label>
            <input type="email" name="email">
            <label>رمز عبور</label>
            <input type="password" name="password">
            <button type="submit" class="ui green button">ورود</button>
        </form>
    </div>
</div>

<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/semantic.min.js') ?>"></script>
<script src="<?= asset('js/app.js') ?>"></script>

</body>
</html>