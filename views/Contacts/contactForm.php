<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><?= isset($contact) ? 'Редагувати контакт' : 'Додати контакт' ?></h1>
    <a href="/admin/contacts" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Назад до списку
    </a>
</div>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
<?php endif; ?>

<form action="<?= isset($contact) ? '/admin/editContact?id=' . $contact['id'] : '/admin/createContact' ?>" method="POST">
    <?php if (isset($contact)): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($contact['id']) ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="name" class="form-label">Назва контакту</label>
        <input type="text" class="form-control" id="name" name="name"
            value="<?= isset($contact) ? htmlspecialchars($contact['name']) : '' ?>" required>
    </div>

    <div class="mb-3">
        <label for="value" class="form-label">Значення</label>
        <textarea
            class="form-control"
            id="value"
            required
            name="value"><?= $contact['value'] ?? '' ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Зберегти
    </button>
</form>

<script>
    ClassicEditor.create(document.querySelector('#value')).catch(error => console.error(error));
</script>