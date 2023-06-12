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

            <!-- форма добавления -->
            <form id="ad-form">
                <label for="title">Название:</label>
                <input type="text" id="title" name="title" required>
                <label for="description">Описание:</label>
                <textarea id="description" name="description" required></textarea>
                <input type="submit" value="Отправить">
            </form>

        </div>
    </main>

    <script>
        // Добавьте прослушиватель событий к событию отправки формы
        document.getElementById("ad-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Запретить отправку формы и перезагрузку страницы

            // Создаёт объект FormData для сбора данных формы
            const formData = new FormData(event.target);

            // Отправляет данные формы в файл create_ad.php с помощью AJAX
            fetch("create_ad.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Если объявление было создано успешно, обновить таблицу новым объявлением
                        const adRow = `
                    <tr>
                        <td>${data.ad.title}</td>
                        <td>${data.ad.description}</td>
                        <td>${data.ad.username}</td>
                    </tr>
                `;
                        document.querySelector(".ads-table tbody").insertAdjacentHTML("afterbegin", adRow);
                    } else {
                        // Если произошла ошибка, отобразить сообщение об ошибке
                        alert(data.error);
                    }
                });
        });
    </script>

<?php require_once 'template/footer.php'; ?>