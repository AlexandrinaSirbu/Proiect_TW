<?php include VIEW . '/components/header.php'; ?>

<h2>Generator AJAX de Matrici</h2>

<form id="generateForm">
  <label>Rânduri:</label>
  <input type="number" name="rows" value="5" min="1" required><br>

  <label>Coloane:</label>
  <input type="number" name="cols" value="5" min="1" required><br>

  <label>Valoare minimă:</label>
  <input type="number" name="min" value="0" required><br>

  <label>Valoare maximă:</label>
  <input type="number" name="max" value="9" required><br>

  <label>Tip:</label>
  <select name="type">
    <option value="random">Aleator</option>
    <option value="binary">Hartă binară (0/1)</option>
    <option value="uniform">Toate valorile egale</option>
  </select><br>

  <button type="submit">Generează</button>
</form>

<div id="resultBox" style="margin-top: 20px;">
  <h3>Rezultat:</h3>
  <pre id="result" style="font-family: monospace;"></pre>
</div>

<script src="/PIG/public/js/matrices.js"></script>

<?php include VIEW . '/components/footer.php'; ?>
