<?php
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programs Input Generator</title>
  <link rel="stylesheet" href="<?= $basePath ?>/css/styles.css">
</head>
<body>
  <header>
    <h1>PIG - Programs Input Generator</h1>
    <nav>
      <ul>
        <li><a href="<?= $basePath ?>/">Acasă</a></li>
        <li><a href="<?= $basePath ?>/generate/numbers">Șiruri</a></li>
        <li><a href="<?= $basePath ?>/generate/matrix">Matrici</a></li>
        <li><a href="<?= $basePath ?>/generate/graph">Grafuri</a></li>
        <li><a href="<?= $basePath ?>/generate/string">Șiruri de caractere</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="<?= $basePath ?>/logout">Logout</a></li>
          <li><a href="<?= $basePath ?>/history">History</a></li>

        <?php else: ?>
          <li><a href="<?= $basePath ?>/login">Login</a></li>
          <li><a href="<?= $basePath ?>/register">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <hr>
  </header>
  <main>
