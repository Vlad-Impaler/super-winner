<?php
require_once 'include/function.php';

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $errors = [];

    // Проверка ввода формы
    if (empty($title)) {
        $errors[] = "Требуется заголовок";
    }
    if (empty($description)) {
        $errors[] = "Требуется описание";
    }

    // Если ошибок нет, продолжить подачу объявления
    if (empty($errors)) {
        if (submit_ad($title, $description, $_SESSION['user_id'])) {
            header("Location: ads.php");
            exit();
        } else {
            $errors[] = "Не удалось отправить объявление. Пожалуйста, попробуйте еще раз.";
        }
    }
}

require_once 'template/header.php';
?>

    <main>
        <div class="container">
            <h1>Добавить объявление</h1>
            <form action="post_ad.php" method="post">
                <label for="title">Название</label>
                <input type="text" name="title" id="title" required>

                <label for="description">Описание</label>
                <textarea name="description" id="description" rows="5" required></textarea>

                <input type="submit" value="Отправить">
            </form>

            <?php
            // Показать ошибки, если они есть
            if (!empty($errors)) {
                echo "<ul class='errors'>";
                foreach ($errors as $error) {
                    echo "<li>" . htmlspecialchars($error) . "</li>";
                }
                echo "</ul>";
            }
            ?>
        </div>
    </main>

<?php require_once 'template/footer.php'; ?>