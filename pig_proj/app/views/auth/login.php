<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Autentificare</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Autentificare</h1>

    <?php if(!empty($error)): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="login-post">
      <label>
        Email:
        <input type="email" name="email" required>
      </label>
      <label>
        Parolă:
        <input type="password" name="password" required>
      </label>
      <button type="submit">Autentifică-te</button>
    </form>

    <p>Nu ai cont? <a href="register">Înregistrează-te aici</a>.</p>
  </div>
</body>
</html>
