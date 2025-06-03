<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Виставки</h1>
    <a href="/admin/exhibitionCreate" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Додати нову виставку
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Тип</th>
                <th>Період</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exhibitions as $exhibition): ?>
                <tr>
                    <td><?= htmlspecialchars($exhibition['id']) ?></td>
                    <td><?= htmlspecialchars($exhibition['title']) ?></td>
                    <td><?= htmlspecialchars($exhibition['type']) ?></td>
                    <td>
                        <?= $exhibition['start_date'] ? htmlspecialchars($exhibition['start_date']) : '—' ?>
                        —
                        <?= $exhibition['end_date'] ? htmlspecialchars($exhibition['end_date']) : '—' ?>
                    </td>
                    <td>
                        <a href="/admin/exhibitionEdit?id=<?= $exhibition['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i> Редагувати
                        </a>
                        <form action="/admin/deleteExhibition?id=<?= $exhibition['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Ви впевнені, що хочете видалити цю виставку?');">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Видалити
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="mt-3">
        <?= $pagination ?>
    </div>
</div>