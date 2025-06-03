<div class="container my-2">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($exhibition['title']) ?></h1>

    <div class="mb-4">
        <p><?= $exhibition['description'] ?></p>

        <?php if ($exhibition['start_date']): ?>
            <p><strong>Період експозиції:</strong> з <?= htmlspecialchars($exhibition['start_date']) ?>
                <?php if ($exhibition['end_date']): ?>
                    по <?= htmlspecialchars($exhibition['end_date']) ?>
                <?php else: ?>
                    і далі
                <?php endif; ?>
            </p>
        <?php else: ?>
            <p><strong>Період експозиції:</strong> постійна</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($images)): ?>
        <div id="exhibitionCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($images as $index => $image): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($image['image_path']) ?>" class="d-block w-100 rounded" alt="<?= htmlspecialchars($exhibition['title']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#exhibitionCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Попереднє</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#exhibitionCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Наступне</span>
            </button>
            <div class="carousel-indicators mt-2">
                <?php foreach ($images as $index => $image): ?>
                    <button type="button" data-bs-target="#exhibitionCarousel" data-bs-slide-to="<?= $index ?>"
                        class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>"
                        aria-label="Слайд <?= $index + 1 ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/exhibitions/show" class="btn btn-secondary">Повернутися до списку виставок</a>
    </div>
</div>