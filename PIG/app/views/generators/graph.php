<?php include VIEW . '/components/header.php'; ?>

<div class="generator-container">
    <h2>Generator de Grafuri</h2>

    <form id="generateGraphForm" class="graph-generator-form">
        <!-- TOP ROW: 3 câmpuri pe un rând -->
        <div class="top-row">
            <div class="form-group">
                <label for="nodes">Număr de noduri</label>
                <input
                        type="number"
                        id="nodes"
                        name="nodes"
                        class="form-control"
                        value="5"
                        min="2"
                        required
                >
            </div>

            <div class="form-group">
                <label for="edges">Număr de muchii</label>
                <input
                        type="number"
                        id="edges"
                        name="edges"
                        class="form-control"
                        value="6"
                        min="1"
                        required
                >
            </div>

            <div class="form-group">
                <label for="type">Tip graf</label>
                <select id="type" name="type" class="form-control">
                    <option value="undirected">Neorientat</option>
                    <option value="directed">Orientat</option>
                    <option value="weighted">Ponderat</option>
                </select>
            </div>
        </div>

        <!-- BOTTOM ROW: 3 checkbox + buton egal spațiu -->
        <div class="bottom-row">
            <label class="checkbox-option">
                <input type="checkbox" name="conex" value="1">
                Conex
            </label>
            <label class="checkbox-option">
                <input type="checkbox" name="bipartit" value="1">
                Bipartit
            </label>
            <label class="checkbox-option">
                <input type="checkbox" name="arbore" value="1">
                Arbore
            </label>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Generează
                </button>
            </div>
        </div>
    </form>
</div>

<div class="results-container">
    <div class="result-container">
        <h3 class="result-title">Rezultat</h3>
        <pre id="graphResult" class="result-pre"></pre>
    </div>
    <div class="svg-container">
        <h3 class="result-title">Reprezentare grafică</h3>
        <div id="graphMessage" class="alert alert-info" style="display: none;">
            Reprezentarea grafică nu este afișată pentru grafurile cu mai mult de 10 noduri.
        </div>
        <svg
                id="graphSvg"
                width="500"
                height="500"
                viewBox="0 0 500 500"
                style="background-color: white; border-radius: var(--border-radius);"
        ></svg>
    </div>
</div>

<script src="/PIG/public/js/graphs.js"></script>
<?php include VIEW . '/components/footer.php'; ?>
