<?php
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIG - Programs Input Generator</title>
    <link rel="stylesheet" href="<?= $basePath ?>/css/styles.css">
    <script src="<?= $basePath ?>/js/pig-guide.js" defer></script>
</head>
<body>
<header>
    <div class="header-container">
        <h1>PIG - Programs Input Generator</h1>
        <button class="menu-toggle" aria-label="Toggle menu">☰</button>
        <nav>
            <ul>
                <li>
                    <a href="<?= $basePath ?>/" class="<?= $currentPath === '/' ? 'active' : '' ?>">Acasă</a>
                </li>
                <li>
                    <a href="<?= $basePath ?>/generate/numbers" class="<?= strpos($currentPath, '/numbers') !== false ? 'active' : '' ?>">Șiruri</a>
                </li>
                <li>
                    <a href="<?= $basePath ?>/generate/matrix" class="<?= strpos($currentPath, '/matrix') !== false ? 'active' : '' ?>">Matrici</a>
                </li>
                <li>
                    <a href="<?= $basePath ?>/generate/graph" class="<?= strpos($currentPath, '/graph') !== false ? 'active' : '' ?>">Grafuri</a>
                </li>
                <li>
                    <a href="<?= $basePath ?>/generate/string" class="<?= strpos($currentPath, '/string') !== false ? 'active' : '' ?>">Șiruri de caractere</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href="<?= $basePath ?>/history" class="<?= strpos($currentPath, '/history') !== false ? 'active' : '' ?>">Istoric</a>
                    </li>
                    <li>
                        <a href="<?= $basePath ?>/logout">Deconectare</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= $basePath ?>/login" class="<?= strpos($currentPath, '/login') !== false ? 'active' : '' ?>">Autentificare</a>
                    </li>
                    <li>
                        <a href="<?= $basePath ?>/register" class="<?= strpos($currentPath, '/register') !== false ? 'active' : '' ?>">Înregistrare</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main>