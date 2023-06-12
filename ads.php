<?php
require_once 'include/function.php';

// Проверить, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получить объявления из базы данных
$ads = fetch_ads();

require_once 'template/header.php';
?>

    <main>
        <div class="container">
            <h1>Объявления</h1>
            <table class="ads-table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Автор</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ad['title']); ?></td>
                        <td><?php echo htmlspecialchars($ad['description']); ?></td>
                        <td><?php echo htmlspecialchars($ad['username']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

<?php require_once 'template/footer.php'; ?>