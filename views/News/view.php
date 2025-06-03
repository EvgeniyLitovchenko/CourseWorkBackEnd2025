<div class="container my-5">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($newsItem['title']) ?></h1>

    <?php if (!empty($newsItem['image'])): ?>
        <div class="mb-4 text-center">
            <img src="<?= htmlspecialchars($newsItem['image']) ?>" alt="<?= htmlspecialchars($newsItem['title']) ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
        </div>
    <?php endif; ?>

    <p class="text-muted text-center mb-4">
        Опубліковано: <?= date('d.m.Y H:i', strtotime($newsItem['published_at'])) ?>
    </p>

    <div class="mb-5">
        <p><?= $newsItem['content'] ?></p>
    </div>

    <div class="text-center">
        <a href="/news/show" class="btn btn-secondary">Повернутися до новин</a>
    </div>
</div>