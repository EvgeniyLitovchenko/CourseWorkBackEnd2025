<div class="container my-2">
    <h1 class="mb-4 text-center">Виставки</h1>

    <div class="mb-4 text-center">
        <form method="get" action="" class="d-flex flex-wrap justify-content-center align-items-center gap-3">
            <select name="type_id" class="form-select w-auto">
                <option value="">Всі типи</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['id'] ?>" <?= $currentType == $type['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Пошук за назвою..." class="form-control w-auto" />

            <input type="date" name="from_date" value="<?= isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : '' ?>" class="form-control w-auto" placeholder="Від дати" />
            <input type="date" name="to_date" value="<?= isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : '' ?>" class="form-control w-auto" placeholder="До дати" />

            <button type="submit" class="btn btn-primary">Пошук</button>
        </form>
    </div>

    <div class="row">
        <?php foreach ($exhibitions as $exhibition): ?>
            <div class="col-md-6 mb-4">
                <a href="/exhibitions/view?id=<?= $exhibition['id'] ?>" class="text-decoration-none text-dark">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($exhibition['title']) ?></h5>
                            <?php if ($exhibition['start_date']): ?>
                                <p class="card-text text-muted">З <?= $exhibition['start_date'] ?> по <?= $exhibition['end_date'] ?></p>
                            <?php else: ?>
                                <p class="card-text text-muted">Постійна</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mb-4">
        <?= $pagination ?>
    </div>
</div>