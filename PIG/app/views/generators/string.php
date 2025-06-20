<?php include VIEW . '/components/header.php'; ?>

<div class="generator-container">
    <h2>Generator de Șiruri de caractere</h2>

    <form id="generateForm" class="string-generator-form">
        <!-- Rândul de sus: 3 inputuri egale -->
        <div class="top-row">
            <div class="form-group">
                <label for="length">Lungime</label>
                <input
                        type="number"
                        id="length"
                        name="length"
                        class="form-control"
                        value="10"
                        min="1"
                        required
                >
            </div>

            <div class="form-group">
                <label for="prefix">Prefix (opțional)</label>
                <input
                        type="text"
                        id="prefix"
                        name="prefix"
                        class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="suffix">Sufix (opțional)</label>
                <input
                        type="text"
                        id="suffix"
                        name="suffix"
                        class="form-control"
                >
            </div>
        </div>

        <!-- Rândul de jos: 4 checkbox + buton, toate cu aceeaşi lăţime -->
        <div class="bottom-row">
            <label class="checkbox-option">
                <input type="checkbox" name="lowercase" checked>
                Litere mici
            </label>
            <label class="checkbox-option">
                <input type="checkbox" name="uppercase">
                Litere mari
            </label>
            <label class="checkbox-option">
                <input type="checkbox" name="digits">
                Cifre
            </label>
            <label class="checkbox-option">
                <input type="checkbox" name="symbols">
                Simboluri (!@#$%…)
            </label>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Generează
                </button>
            </div>
        </div>
    </form>
</div>

<div class="result-container">
    <h3 class="result-title">Rezultat</h3>
    <div id="result"
         class="result-pre"
         style="font-family: monospace;"></div>
</div>

<script src="/PIG/public/js/strings.js"></script>
<?php include VIEW . '/components/footer.php'; ?>
