<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Acasă</title>

</head>
<body>
  <div class="container">
    <?php if(!empty($_SESSION['user'])): ?>
      <h1>Bine ai venit, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
      <p><a href="logout">Deconectare</a></p>
    <?php else: ?>
      <h1>Bine ai venit pe site!</h1>
      <p>
        <a href="login">Autentifică-te</a> |
        <a href="register">Înregistrează-te</a>
      </p>
    <?php endif; ?>
  </div>
</body>
</html>
