<?php

use models\Users;

?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Адмін-панель' ?></title>
    <link href="/public/css/admin.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>

<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <h2>Адмін</h2>
            <ul>
                <li><a href="/admin/dashboard">Головна</a></li>
                <li><a href="/admin/exhibitions">Виставки</a></li>
                <li><a href="/admin/news">Новини</a></li>
                <li><a href="/admin/visitorInfo">Інформація для відвідувачів</a></li>
                <li><a href="/admin/contacts">Контакти</a></li>
                <?php
                if (Users::isSuperAdmin()): ?>
                    <li><a href="/admin/users">Адміністратори</a></li>
                <?php endif; ?>
            </ul>
            <div class="logout d-flex justify-content-center">
                <a href="/admin/logout" class="btn btn-danger">Вийти</a>
            </div>
        </aside>
        <main class="content">
            <?= $content ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>