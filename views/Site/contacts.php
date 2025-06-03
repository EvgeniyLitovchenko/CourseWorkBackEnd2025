<div class="container my-5">
    <h1 class="mb-4 text-center">Контактна інформація</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <?php foreach ($contacts as $key => $value): ?>
                        <?php
                        $label = htmlspecialchars($key);
                        $content = $value;

                        if (stripos($key, 'email') !== false) {
                            $content = "<a href=\"mailto:$content\">$content</a>";
                        } elseif (stripos($key, 'Map') !== false) {
                            continue;
                        }
                        ?>

                        <h5 class="card-title mb-2"><?= $label ?></h5>
                        <p class="card-text mb-3"><?= $content ?></p>
                    <?php endforeach; ?>

                </div>
            </div>

            <?php if (!empty($contacts['Map'])): ?>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <iframe
                            src="<?= htmlspecialchars($contacts['Map']) ?>"
                            width="100%"
                            height="450"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>