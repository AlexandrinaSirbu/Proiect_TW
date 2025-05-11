<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Înregistrare</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Creare cont</h1>

    <?php if(!empty($error)): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
      <p class="success"><?= htmlspecialchars($success) ?></p>
      <p><a href="login">Autentifică-te acum</a></p>
    <?php else: ?>
      <form method="post" action="register-post">
        <label>
          Nume utilizator:
          <input type="text" name="username" required>
        </label>
        <label>
          Email:
          <input type="email" name="email" required>
        </label>
        <label>
          Parolă:
          <input type="password" name="password" required>
        </label>
        <label>
          Confirmă parolă:
          <input type="password" name="password_confirm" required>
        </label>
        <button type="submit">Înregistrează-te</button>
      </form>
      <p>Ai deja cont? <a href="login">Autentifică-te aici</a>.</p>
    <?php endif; ?>
  </div>
</body>
</html>
