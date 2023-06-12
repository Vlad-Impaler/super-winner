<?php
require_once 'include/function.php';

// Сбросить переменные сеанса и уничтожить сеанс
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    session_destroy();
}

// Перенаправление на страницу входа
header("Location: login.php");
exit();