<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>PIG – Programs Input Generator</title>
  <link rel="stylesheet" href="/pig_proj/public/assets/css/style2.css">
</head>
<body>
  <div id="userInfo">Se verifică sesiunea...</div>
  <button id="logoutBtn" onclick="logout()">Deconectare</button>

  <h1>Programs Input Generator (PIG)</h1>

  <div class="tabs">
    <button class="tab" onclick="openTab('numbers')">Șiruri de Numere</button>
    <button class="tab" onclick="openTab('matrix')">Matrice</button>
    <button class="tab" onclick="openTab('string')">Șiruri de Caractere</button>
    <button class="tab" onclick="openTab('graph')">Grafuri / Arbori</button>
    <button class="tab" onclick="openTab('export')">Export</button>
  </div>

  <div id="numbers" class="tab-content">
    <label for="numLength">Lungime:</label>
    <input type="number" id="numLength" value="5">
    <label for="numMin">Min:</label>
    <input type="number" id="numMin" value="1">
    <label for="numMax">Max:</label>
    <input type="number" id="numMax" value="100">
    <button onclick="generateNumbers()">Generează</button>
    <pre id="numbersOutput"></pre>
  </div>

  <div id="matrix" class="tab-content">
    <label for="rows">Rânduri:</label>
    <input type="number" id="rows" value="3">
    <label for="cols">Coloane:</label>
    <input type="number" id="cols" value="3">
    <label for="minVal">Min:</label>
    <input type="number" id="minVal" value="0">
    <label for="maxVal">Max:</label>
    <input type="number" id="maxVal" value="9">
    <button onclick="generateMatrix()">Generează</button>
    <pre id="matrixOutput"></pre>
  </div>

  <div id="string" class="tab-content">
    <label for="strLength">Lungime:</label>
    <input type="number" id="strLength" value="8">
    <button onclick="generateString()">Generează</button>
    <pre id="stringOutput"></pre>
  </div>

  <div id="graph" class="tab-content">
    <label for="graphNodes">Număr noduri:</label>
    <input type="number" id="graphNodes" value="5">
    <label><input type="checkbox" id="graphDirected"> Este orientat?</label>
    <label><input type="checkbox" id="graphComplete" onchange="toggleEdgeInput()"> Este graf complet?</label>
    <div id="edgeCountContainer">
      <label for="graphEdges">Număr de muchii:</label>
      <input type="number" id="graphEdges" value="6">
    </div>
    <button onclick="generateGraph()">Generează</button>
    <pre id="graphOutput"></pre>
    <svg id="graphSVG" width="400" height="400"></svg>
  </div>

  <div id="export" class="tab-content">
    <label>Format:
      <select id="exportFormat">
        <option value="json">JSON</option>
        <option value="csv">CSV</option>
      </select>
    </label>
    <label>Sursă:
      <select id="exportSource">
        <option value="numbers">Șiruri de Numere</option>
        <option value="matrix">Matrice</option>
        <option value="string">Șiruri de Caractere</option>
        <option value="graph">Grafuri / Arbori</option>
      </select>
    </label>
    <button onclick="exportData()">Exportă</button>
    <h3>Istoric generări</h3>
    <button onclick="showHistory()">Afișează istoric</button>
    <div id="historyList"></div>
  </div>

  <script src="/pig_proj/public/assets/js/pig.js" defer></script>
  <script>
    openTab('numbers');
  </script>
</body>
</html>
