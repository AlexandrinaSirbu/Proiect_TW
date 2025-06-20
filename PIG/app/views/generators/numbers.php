<?php include VIEW . '/components/header.php'; ?>

<div class="generator-container">
    <h2>Generator de Șiruri</h2>

    <form id="generateForm" class="number-generator-form">
        <!-- RÂNDUL DE SUS: 3 câmpuri egale -->
        <div class="top-row">
            <div class="form-group">
                <label for="length">Lungime</label>
                <input
                        type="number"
                        id="length"
                        name="length"
                        class="form-control"
                        value="10"
                        required
                >
            </div>
            <div class="form-group">
                <label for="min">Valoare minimă</label>
                <input
                        type="number"
                        id="min"
                        name="min"
                        class="form-control"
                        value="0"
                        required
                >
            </div>
            <div class="form-group">
                <label for="max">Valoare maximă</label>
                <input
                        type="number"
                        id="max"
                        name="max"
                        class="form-control"
                        value="100"
                        required
                >
            </div>
        </div>

        <!-- RÂNDUL DE JOS: select + buton -->
        <div class="bottom-row">
            <div class="form-group">
                <label for="sort">Sortare</label>
                <select id="sort" name="sort" class="form-control">
                    <option value="none">Nesortat</option>
                    <option value="asc">Crescător</option>
                    <option value="desc">Descrescător</option>
                </select>
            </div>
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
    <div id="result" class="result-pre"></div>
</div>

<script src="/PIG/public/js/numbers.js"></script>
<?php include VIEW . '/components/footer.php'; ?>
