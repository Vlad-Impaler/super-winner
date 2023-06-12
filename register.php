<?php
require_once 'include/function.php';

// Проверить, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    $errors = [];

    // Проверка ввода формы
    if (empty($username)) {
        $errors[] = "Требуется имя пользователя";
    }
    if (empty($email)) {
        $errors[] = "Требуется электронная почта";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Не правильный формат электронной почты";
    }
    if (empty($password)) {
        $errors[] = "Требуется пароль";
    } elseif (strlen($password) < 6) {
        $errors[] = "Пароль должен быть не менее 6 символов";
    }
    if ($password != $password_confirm) {
        $errors[] = "Пароли не совпадают";
    }

    // Если ошибок нет, продолжить регистрацию
    if (empty($errors)) {
        $result = register_user($username, $email, $password);
        if ($result === true) {
            header("Location: ads.php");
            exit();
        } else {
            $errors[] = $result;
        }

    }
}

require_once 'template/header.php';
?>

    <main>
        <div class="container">
            <h1>Регистрация</h1>
            <form action="register.php" method="post">
                <label for="username">Логин</label>
                <input type="text" name="username" id="username" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" minlength="6" required>

                <label for="password_confirm">Повторите пароль</label>
                <input type="password" name="password_confirm" id="password_confirm" minlength="6" required>

                <input type="submit" value="Register">
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