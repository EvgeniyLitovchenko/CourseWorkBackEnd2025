<?php
$isEdit = isset($exhibition);
$actionUrl = $isEdit ? "/admin/exhibitionEdit?id={$exhibition['id']}" : "/admin/exhibitionCreate";
?>

<h1 class="h3 mb-4"><?= $isEdit ? 'Редагувати виставку' : 'Додати виставку' ?></h1>

<form action="<?= $actionUrl ?>" method="POST" enctype="multipart/form-data" class="mb-5">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($exhibition['id']) ?>">
    <?php endif ?>
    <div class="mb-3">
        <label for="title" class="form-label">Назва</label>
        <input type="text" class="form-control" id="title" name="title"
            value="<?= htmlspecialchars($exhibition['title'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="type_id" class="form-label">Тип виставки</label>
        <select name="type_id" id="type_id" class="form-select" required>
            <option value="">— Оберіть тип —</option>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>"
                    <?= (isset($exhibition['type_id']) && $exhibition['type_id'] == $type['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['name']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="start_date" class="form-label">Дата початку</label>
        <input type="date" class="form-control" id="start_date" name="start_date"
            value="<?= htmlspecialchars($exhibition['start_date'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="end_date" class="form-label">Дата завершення</label>
        <input type="date" class="form-control" id="end_date" name="end_date"
            value="<?= htmlspecialchars($exhibition['end_date'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label for="description">Опис:</label>
        <textarea id="description" name="description"><?= $exhibition['description'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label for="images[]" class="form-label">Зображення</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple>

        <?php if (!empty($additionalImages)): ?>
            <div class="mt-3 d-flex flex-wrap gap-3">
                <?php foreach ($additionalImages as $img): ?>
                    <div class="position-relative border rounded p-1 image-box" id="image-<?= $img['id'] ?>" style="width: 100px;">
                        <img src="<?= htmlspecialchars($img['filename']) ?>"
                            alt="Додаткове зображення"
                            style="width: 100%; height: auto; display: block;">

                        <button
                            type="button"
                            class="btn btn-sm btn-danger p-0 m-1 delete-image-btn position-absolute top-0 end-0"
                            data-id="<?= $img['id'] ?>"
                            style="width: 20px; height: 20px; line-height: 1; font-size: 14px;"
                            title="Видалити">&times;</button>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>


    <button type="submit" class="btn btn-primary">
        <?= $isEdit ? 'Оновити' : 'Додати' ?>
    </button>
</form>


<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".delete-image-btn").forEach(button => {
            button.addEventListener("click", function() {
                if (!confirm("Ви впевнені, що хочете видалити це зображення?")) {
                    return;
                }

                const imageId = this.dataset.id;

                fetch("/admin/deleteImage", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: new URLSearchParams({
                            id: imageId
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            const imageBox = document.getElementById("image-" + imageId);
                            if (imageBox) imageBox.remove();
                        } else {
                            alert("Не вдалося видалити зображення");
                        }
                    })
                    .catch(error => {
                        console.error("Помилка:", error);
                        alert("Виникла помилка при видаленні зображення");
                    });
            });
        });
    });
</script>