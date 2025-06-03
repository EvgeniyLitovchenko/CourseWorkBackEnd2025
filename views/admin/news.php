<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Новини</h1>
    <a href="/admin/createNews" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Додати новину
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Зображення</th>
                <th>Заголовок</th>
                <th>Опис</th>
                <th>Дата</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['id']) ?></td>
                    <td>
                        <?php if (!empty($item['image'])): ?>
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="Зображення" style="width: 80px; height: auto;">
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth(strip_tags($item['excerpt']), 0, 100, '...')) ?></td>
                    <td><?= date('d.m.Y', strtotime($item['created_at'])) ?></td>
                    <td class="d-flex">
                        <a href="/admin/editNews?id=<?= $item['id'] ?>" class="btn btn-sm btn-primary mb-1">
                            <i class="bi bi-pencil-square"></i> Редагувати
                        </a>
                        <form action="/admin/deleteNews" method="POST" class="d-inline" onsubmit="return confirm('Ви впевнені, що хочете видалити цю новину?');">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Видалити
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        <?= $pagination ?>
    </div>
</div>