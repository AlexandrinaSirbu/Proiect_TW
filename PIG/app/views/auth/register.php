<?php include VIEW . '/components/header.php'; ?>

<h2>Înregistrare</h2>

<form method="POST">
  <label>Username:</label>
  <input type="text" name="username" required><br>

  <label>Parolă:</label>
  <input type="password" name="password" required><br>

  <button type="submit">Creează cont</button>
</form>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<?php include VIEW . '/components/footer.php'; ?>
