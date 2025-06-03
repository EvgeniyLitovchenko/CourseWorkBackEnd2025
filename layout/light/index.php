

    <?php require 'header.php'; ?>

    <div class="d-flex flex-column min-vh-100">
        <main class="flex-grow-1">
            <div class="container">
                <?= $content ?? '' ?>
            </div>
        </main>

    <?php require 'footer.php'; ?>