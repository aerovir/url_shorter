<?php 
include_once "config.php";

function get_URL($page = '') {
    return HOST . "/$page";
}
function db() {
    try {
        return new PDO("pgsql:host=" . DB_HOST. "; dbname=" . DB_NAME . ";", DB_USER, DB_PASS, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	    ]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function get_user_info($login) {
    if (empty($login)) return 'error';
    return db_query("SELECT * FROM users_table WHERE login = '$login'")->fetch();
}

function db_query($sql = '', $exec = false) {
    if (empty($sql)) return false;
    if ($exec) {
        return db()->exec($sql);

    }
    return db()->query($sql);
}

function get_link_info($url) {
    if (empty($url)) return [];
    return db_query("SELECT * FROM main_table WHERE short_link = '$url';")->fetch();
}

function update_views($url) {
    if (empty($url)) return false;
    return db_query("UPDATE main_table SET views = views + 1 WHERE short_link = '$url';", true);
}

function add_user($login, $pass) {
    $password = password_hash($pass, PASSWORD_DEFAULT);
    return db_query("INSERT INTO users_table (login, pass) VALUES ('$login', '$password');", true);
}

function register_user($auth_data) {
    if (empty($auth_data['login']) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || !isset($auth_data['pass2'])) {
        return false;
    }
    
    $user = get_user_info($auth_data['login']);  
    if (!empty($user)) {
        $_SESSION['error'] = "Пользователь '" . $auth_data['login'] . "' уже существует";
        header('Location: register.php');
        die;
    }

    if ($auth_data['pass'] !== $auth_data['pass2']) {
        $_SESSION['error'] = "Пароли не совпадают";
        header('Location: register.php');
        die;
    }

    if (add_user($auth_data['login'], $auth_data['pass'])) {
        $_SESSION['success'] = "Регистрация прошла успешно";
        header('Location: login.php');
        die;
    }

    return true;
}

function login_user($auth_data) {
    if (empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || empty($auth_data['pass'])) {
        $_SESSION['error'] = "Логин или пароль не может быть пустым";
        header('Location: login.php');
        die;
    }

    $user = get_user_info($auth_data['login']);
    if (empty($user)) {
        $_SESSION['error'] = "Логин или пароль не верен";
        header('Location: login.php');
        die;
    }
    
    if (password_verify($auth_data['pass'], $user['pass'])) {
        $_SESSION['user'] = $user;
        header('Location: profile.php');
        die;
    } else {
        $_SESSION['error'] = "Пароль неверен!";
        header('Location: login.php');
        die;
    }
}

function get_user_links($user_id) {
    if (empty($user_id)) return [];

    return db_query("SELECT * FROM main_table WHERE user_id = $user_id")->fetchAll();
}

function delete_link($id) {
    if (empty($id)) return false;

    return db_query("DELETE FROM main_table WHERE id = $id;", true);
}

function add_link($user_id, $link) {
    $short_link = generate_string();
    return db_query("INSERT INTO main_table (long_link, short_link, views, user_id) VALUES ('$link', '$short_link', '0', '$user_id')", true);
}

function generate_string($size = 6) {
    $string = str_shuffle((URL_CHARS));
    return substr($string, 0, $size);
}
