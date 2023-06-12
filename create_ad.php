<?php
require_once 'include/function.php';

header("Content-Type: application/json");

// Проверить, вошёл ли пользователь в систему и является ли метод POST
if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Неверный запрос."]);
    exit();
}

// Собрать данные объявленияиз отправленной формы
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$user_id = $_SESSION['user_id'];

// Создать объявление в базе
$ad_id = create_ad($title, $description, $user_id);

// Если объявление было создано успешно, вернуть данные объявления в формате JSON
if ($ad_id) {
    echo json_encode([
        "success" => true,
        "ad" => [
            "title" => $title,
            "description" => $description,
            "username" => $_SESSION['username']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Ошибка прти создания объявления. Пожалуйста, повторите попытку позже."
    ]);
}