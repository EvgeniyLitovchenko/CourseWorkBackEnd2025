<?php
$isEdit = isset($visitorInfo);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><?= $isEdit ? 'Редагувати запис' : 'Створити запис' ?></h1>
    <a href="/admin/visitorinfo" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Назад
    </a>
</div>

<form action="" method="POST">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($visitorInfo['id']) ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="category" class="form-label">Категорія</label>
        <input
            type="text"
            class="form-control"
            id="category"
            name="category"
            value="<?= htmlspecialchars($visitorInfo['category'] ?? '') ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Контент</label>
        <textarea
            class="form-control"
            id="content"
            name="content"><?= $visitorInfo['content'] ?? '' ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> <?= $isEdit ? 'Зберегти зміни' : 'Створити' ?>
    </button>
</form>


<script>
    ClassicEditor.create(document.querySelector('#content')).catch(error => console.error(error));
</script>