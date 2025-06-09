<?php include VIEW . '/components/header.php'; ?>
<h1>Bine ai venit!</h1>
    <p>ID-ul tău este: 
        <?php
        if (isset($_SESSION['user_id'])) {
            echo htmlspecialchars($_SESSION['user_id']);
        } else {
            echo "Neautentificat";
        }
        ?>
    </p>
<?php include VIEW . '/components/footer.php'; ?>
