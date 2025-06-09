<?php include VIEW . '/components/header.php'; ?>

<h2>Generator de Grafuri</h2>

<form id="generateGraphForm">
  <label>Număr de noduri:</label>
  <input type="number" name="nodes" value="5" min="2" required><br>

  <label>Număr de muchii:</label>
  <input type="number" name="edges" value="6" min="1" required><br>

  <label>Tip graf:</label>
  <select name="type">
    <option value="undirected">Neorientat</option>
    <option value="directed">Orientat</option>
    <option value="weighted">Ponderat</option>
  </select><br>

  <label>Proprietăți graf:</label>
<div>
  <label><input type="checkbox" name="properties[]" value="conex"> Conex</label>
  <label><input type="checkbox" name="properties[]" value="bipartit"> Bipartit</label>
  <label><input type="checkbox" name="properties[]" value="arbore"> Arbore</label>
</div>

<label>Format rezultat:</label>
<select name="output_format">
  <option value="list">Listă de muchii</option>
  <option value="matrix">Matrice de adiacență</option>
  <option value="parents">Vectori de tați</option>
</select>


  <button type="submit">Generează</button>
</form>

<div id="resultBox" style="margin-top: 20px;">
  <h3>Rezultat:</h3>
  <pre id="graphResult" style="font-family: monospace;"></pre>
</div>

<div id="graphSvgBox" style="margin-top: 20px;">
  <h3>Reprezentare grafică:</h3>
  <svg id="graphSvg" width="500" height="500"></svg>
</div>


<script src="/PIG/public/js/graphs.js"></script>

<?php include VIEW . '/components/footer.php'; ?>
