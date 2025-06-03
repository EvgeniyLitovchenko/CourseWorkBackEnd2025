<div>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($news['id'] ?? '') ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title"
                value="<?= htmlspecialchars($news['title'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="excerpt" class="form-label">Короткий опис</label>
            <textarea class="form-control" id="excerpt" name="excerpt"><?= htmlspecialchars($news['excerpt'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Повний опис</label>
            <textarea class="form-control" id="content" name="content"><?= htmlspecialchars($news['content'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Зображення (опціонально)</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if (!empty($news['image'])): ?>
                <div class="mt-2">
                    <img src="<?= htmlspecialchars($news['image']) ?>" alt="Зображення" style="max-height: 200px;">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-success">Зберегти</button>
    </form>

    <script>
        ClassicEditor.create(document.querySelector('#content')).catch(error => console.error(error));
    </script>

</div>