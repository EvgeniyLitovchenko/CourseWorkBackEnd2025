<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Контакти</h1>
    <a href="/admin/createContact" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Додати контакт
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Значення</th>
                <th>Оновлено</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['id']) ?></td>
                    <td><?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= mb_strimwidth($contact['value'], 0, 50, '...') ?></td>
                    <td><?= date('d.m.Y H:i', strtotime($contact['updated_at'])) ?></td>
                    <td class="d-flex">
                        <a href="/admin/editContact?id=<?= $contact['id'] ?>" class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-pencil-square"></i> Редагувати
                        </a>
                        <form action="/admin/deleteContact" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей контакт?');">
                            <input type="hidden" name="id" value="<?= $contact['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Видалити
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>