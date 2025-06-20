<?php include VIEW . '/components/header.php'; ?>

<div class="welcome-banner">
    <?php if (isset($_SESSION['username'])): ?>
        <h2>Bine ai venit, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <?php else: ?>
        <h2>Bine ai venit, oaspete!</h2>
    <?php endif; ?>
</div>


<?php include VIEW . '/components/footer.php'; ?>
