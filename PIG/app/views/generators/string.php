<?php include VIEW . '/components/header.php'; ?>

<h2>Generator AJAX de Șiruri de caractere</h2>

<form id="generateForm">
  <label>Lungime:</label>
  <input type="number" name="length" value="10" min="1" required><br>

  <label>Include litere mici:</label>
  <input type="checkbox" name="lowercase" checked><br>

  <label>Include litere mari:</label>
  <input type="checkbox" name="uppercase"><br>

  <label>Include cifre:</label>
  <input type="checkbox" name="digits"><br>

  <label>Include simboluri (!@#$%...):</label>
  <input type="checkbox" name="symbols"><br>

  <label>Prefix (opțional):</label>
  <input type="text" name="prefix"><br>

  <label>Sufix (opțional):</label>
  <input type="text" name="suffix"><br>

  <button type="submit">Generează</button>
</form>

<div id="resultBox" style="margin-top: 20px;">
  <h3>Rezultat:</h3>
  <div id="result" style="font-family: monospace;"></div>
</div>

<script src="/PIG/public/js/strings.js"></script>

<?php include VIEW . '/components/footer.php'; ?>
