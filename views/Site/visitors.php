<section class="visitor-info my-5">
    <div class="container">
        <h2 class="mb-4">Відвідувачам</h2>
        <?php foreach ($visitorInfo as $info): ?>
            <div class="visitor-section mb-4 p-4 shadow-sm rounded bg-light">
                <h3 class="mb-3"><?= htmlspecialchars($info['category']) ?></h3>
                <div class="visitor-content">
                    <?= $info['content'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
