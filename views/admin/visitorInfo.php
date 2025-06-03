<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Інформація для відвідувачів</h1>
    <a href="/admin/createVisitorInfo" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Додати запис
    </a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Категорія</th>
                <th>Контент</th>
                <th>Останнє оновлення</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($visitorInfos)): ?>
                <?php foreach ($visitorInfos as $info): ?>
                    <tr>
                        <td><?= htmlspecialchars($info['id']) ?></td>
                        <td><?= htmlspecialchars($info['category']) ?></td>
                        <td><?= mb_strimwidth($info['content'], 0, 100, '...') ?></td>
                        <td><?= date('d.m.Y', strtotime($info['updated_at'])) ?></td>
                        <td class="">
                            <a href="/admin/editVisitorinfo?id=<?= $info['id'] ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square"></i> Редагувати
                            </a>
                            <form action="/admin/deleteVisitorInfo" method="POST" class="d-inline" onsubmit="return confirm('Ви впевнені, що хочете видалити цей запис?');">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Видалити
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">Немає записів</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>