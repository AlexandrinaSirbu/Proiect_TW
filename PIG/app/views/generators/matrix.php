<?php include VIEW . '/components/header.php'; ?>

<div class="generator-container">
    <h2>Generator de Matrici</h2>

    <form id="generateForm" class="matrix-generator-form">
        <!-- Rândul de sus: 3 câmpuri pe un rând -->
        <div class="top-row">
            <div class="form-group">
                <label for="rows">Rânduri</label>
                <input
                        type="number"
                        id="rows"
                        name="rows"
                        class="form-control"
                        value="5"
                        min="1"
                        required
                >
            </div>
            <div class="form-group">
                <label for="cols">Coloane</label>
                <input
                        type="number"
                        id="cols"
                        name="cols"
                        class="form-control"
                        value="5"
                        min="1"
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
        </div>

        <!-- Rândul de jos: 2 câmpuri + buton -->
        <div class="bottom-row">
            <div class="form-group">
                <label for="max">Valoare maximă</label>
                <input
                        type="number"
                        id="max"
                        name="max"
                        class="form-control"
                        value="9"
                        required
                >
            </div>
            <div class="form-group">
                <label for="type">Tip</label>
                <select id="type" name="type" class="form-control">
                    <option value="random">Aleator</option>
                    <option value="binary">Hartă binară (0/1)</option>
                    <option value="uniform">Toate valorile egale</option>
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
    <pre id="result" class="result-pre"></pre>
</div>

<script src="/PIG/public/js/matrices.js"></script>
<?php include VIEW . '/components/footer.php'; ?>
