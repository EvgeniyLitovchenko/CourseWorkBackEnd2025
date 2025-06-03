<div class="container my-5">
    <h1 class="mb-4 text-center">Новини музею</h1>

    <div class="row">
        <?php foreach ($news as $item): ?>
            <div class="col-md-6 mb-4">
                <a href="/news/view?id=<?= $item['id'] ?>" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>" style="object-fit: cover; height: 200px;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                            <p class="card-text flex-grow-1"><?= nl2br(htmlspecialchars($item['excerpt'] ?? 'Опис відсутній')) ?></p>
                            <small class="text-muted mt-auto">
                                Опубліковано: <?= date('d.m.Y H:i', strtotime($item['published_at'])) ?>
                            </small>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>