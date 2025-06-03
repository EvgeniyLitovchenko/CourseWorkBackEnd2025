<?php

use classes\Core;
use models\Users;

function navActive(string $prefix): string
{
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return str_starts_with($currentPath, $prefix) ? 'active' : '';
}

?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Музей' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>
    <header class="bg-primary text-dark sticky-top shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <a class="navbar-brand fw-bold fs-4" href="/">Музей</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Перемкнути навігацію">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item text-dark">
                        <a class="nav-link <?= navActive('/') ?>" href="/">Головна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= navActive('/site/about') ?>" href="/site/about">Про музей</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= navActive('/exhibitions/show') ?>" href="/exhibitions/show">Виставки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= navActive('/site/visitors') ?>" href="/site/visitors">Відвідувачам</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= navActive('/news/show') ?>" href="/news/show">Новини</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= navActive('/site/contacts') ?>" href="/site/contacts">Контакти</a>
                    </li>
                </ul>

            </div>
        </nav>
    </header>