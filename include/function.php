<?php
session_start();
require_once 'config.php';

function register_user($username, $email, $password) {
    global $pdo;

    // Проверка, существует ли имя пользователя или адрес электронной почты
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['username'] === $username) {
            return "Имя пользователя уже занято.";
        }
        if ($user['email'] === $email) {
            return "Адрес электронной почты уже существует.";
        }
    }

    // Хэш пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Внести пользователя в базу
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $result = $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password,
    ]);

    if ($result) {
        // Войти в систему, установив переменные сеанса
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        return true;
    }

    return "Регистрация не удалась. Пожалуйста, попробуйте еще раз.";
}

function authenticate_user($username, $password) {
    global $pdo;

    // Получить пользователя из базы данных
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Подтверждение пароля
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }

    return false;
}

function submit_ad($title, $description, $user_id) {
    global $pdo;

    // Внести объявление в базу
    $stmt = $pdo->prepare("INSERT INTO ads (title, description, user_id) VALUES (:title, :description, :user_id)");
    $result = $stmt->execute([
        'title' => $title,
        'description' => $description,
        'user_id' => $user_id,
    ]);

    return $result;
}

function fetch_ads() {
    global $pdo;

    // Получить объявления и имена пользователей из базы данных
    $stmt = $pdo->query("SELECT ads.*, users.username FROM ads JOIN users ON ads.user_id = users.id ORDER BY created_at DESC");
    $ads = $stmt->fetchAll();

    return $ads;
}
