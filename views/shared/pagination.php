<nav>
    <ul class="pagination justify-content-center">
        <?php if ($totalPages <= 1) return; ?>

        <li class="page-item <?= $currentPage == 0 ? 'active' : '' ?>">
            <a class="page-link" href="<?= htmlspecialchars($baseUrl . '0') ?>">1</a>
        </li>

        <?php
        $visiblePages = 5;

        if ($currentPage > floor($visiblePages / 2) + 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        $start = max(1, $currentPage - floor($visiblePages / 2));
        $end = min($totalPages - 2, $start + $visiblePages - 1);
        $start = max(1, $end - $visiblePages + 1);

        for ($i = $start; $i <= $end; $i++):
        ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="<?= htmlspecialchars($baseUrl . $i) ?>"><?= $i + 1 ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages - floor($visiblePages / 2) - 2): ?>
            <li class="page-item disabled"><span class="page-link">...</span></li>
        <?php endif; ?>

        <li class="page-item <?= ($totalPages - 1) == $currentPage ? 'active' : '' ?>">
            <a class="page-link" href="<?= htmlspecialchars($baseUrl . ($totalPages - 1)) ?>"><?= $totalPages ?></a>
        </li>
    </ul>
</nav>