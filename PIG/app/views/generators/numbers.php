<?php include VIEW . '/components/header.php'; ?>

<h2>Generator de Șiruri</h2>

<form id="generateForm">
  <label>Lungime:</label>
  <input type="number" name="length" value="10" required><br>

  <label>Min:</label>
  <input type="number" name="min" value="0" required><br>

  <label>Max:</label>
  <input type="number" name="max" value="100" required><br>

  <label>Sortare:</label>
  <select name="sort">
    <option value="none">Nesortat</option>
    <option value="asc">Crescător</option>
    <option value="desc">Descrescător</option>
  </select><br>

  <button type="submit">Generează</button>
</form>

<div id="resultBox" style="margin-top: 20px;">
  <h3>Rezultat:</h3>
  <div id="result"></div>
</div>

<script src="/PIG/public/js/numbers.js"></script>


<?php include VIEW . '/components/footer.php'; ?>
