<?php

function dd()
{
    echo "<pre>";
    var_dump(...func_get_args());
    echo "</pre>";
    exit;
}

function input(string $key): string
{
    return empty($_REQUEST[$key]) ?: trim($_REQUEST[$key]);
}

function isReadyFile(string $path): bool
{
    return file_exists($path) && is_readable($path);
}

function isRequestMethod(string $method):bool
{
    return strtolower($_SERVER['REQUEST_METHOD']) == strtolower($method);
}

function isRequestReferer(string $url):bool
{
    return trim($_SERVER['HTTP_REFERER'] ?? null) == trim($url);
}

function root(string $path = null): string
{
    return trim(ROOT_DIR . DIRECTORY_SEPARATOR . $path);
}

function url(string $path = null):string
{
    return trim(BASE_URL . '/' . $path);
}

function asset(string $path): string
{
    return "assets/$path";
}

function message(string $target): string
{
    $messages = include getMessagePath();
    $targetKeys = explode('.', $target);
    foreach ($targetKeys as $key)
        if (array_key_exists($key, $messages))
            $messages = $messages[$key];
    return $messages;
}

function getMessagePath(): string
{
    return root('messages.php');
}

function redirect(string $url)
{
    header("Location: $url");
    exit;
}

function redirectBack()
{
    redirect($_SERVER['HTTP_REFERER']);
}

function redirectBackWith(string $message)
{
    $_SESSION['msg'] = $message;
    redirectBack();
}

function decodeAuth(string $key): string
{
    return $key;
}

function encodeAuth(string $email): string
{
    return $email;
}

function getDatabasePath(string $entity): string
{
    return root("$entity.json");
}

function getDatabase(string $entity): object
{
    $path = getDatabasePath($entity);
    return isReadyFile($path) ? (object)json_decode(file_get_contents($path)) : new stdClass();
}

function setDatabase(string $entity, string $content): bool
{
    return file_put_contents(getDatabasePath($entity), $content);
}

function getUser(string $email)
{
    $users = getDatabase('users');
    foreach ($users as $user)
        if ($user->email == $email)
            return $user;
    return null;
}

function insertUser(array $user): bool
{
    $users = (array)getDatabase('users');
    $users[] = $user;
    return setDatabase('users', json_encode($users));
}

function updateUser(string $email, array $updates): bool
{
    $users = (array)getDatabase('users');
    for ($i = 0; $i < sizeof($users); $i++)
        if ($users[$i]->email == $email)
            foreach ($updates as $key => $val)
                $users[$i]->$key = $val;
    return setDatabase('users', json_encode($users));
}

function setPropertyUser(string $name, string $email, string $password): array
{
    return [
        'name' => $name,
        'email' => $email,
        'password' => md5($password),
        'login' => false
    ];
}

function isLogin(): bool
{
    if (empty($_SESSION['auth']['email']))
        if (empty($_COOKIE['auth']))
            return false;
        else
            $_SESSION['auth']['email'] = decodeAuth($_COOKIE['auth']);
    $user = getUser($_SESSION['auth']['email']);
    return $user ? (bool)$user->login : false;
}

function login(string $email): bool
{
    updateUser($email, ['login' => true]);
    $_SESSION['auth']['email'] = $email;
    setcookie('auth', encodeAuth($email), date() + 86400, '/');
    redirectBack();
}
