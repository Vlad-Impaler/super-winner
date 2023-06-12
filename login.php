<?php
require_once 'include/function.php';

// Проверка, авторизовался ли пользователь
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $errors = [];

    // Проверка ввода формы
    if (empty($username)) {
        $errors[] = "Требуется имя пользователя";
    }
    if (empty($password)) {
        $errors[] = "Требуется пароль";
    }

    // Если ошибок нет, продолжить авторизацию
    if (empty($errors)) {
        if ($user = authenticate_user($username, $password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION[' '] = $user['username'];
            header("Location: ads.php");
            exit();
        } else {
            $errors[] = "Неправильное имя пользователя или пароль";
        }
    }
}

require_once 'template/header.php';
?>

    <main>
        <div class="container">
            <h1>Авторизация</h1>
            <form action="login.php" method="post">
                <label for="username">Логин</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>

                <input type="submit" value="Login">
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