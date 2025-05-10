function openTab(tabId) {
  const tabs = document.querySelectorAll('.tab-content');
  tabs.forEach(tab => tab.style.display = 'none');

  const target = document.getElementById(tabId);
  if (target) {
    target.style.display = 'block';
  }

  const buttons = document.querySelectorAll('.tab');
  buttons.forEach(btn => btn.classList.remove('active'));


  const tabButtons = {
    numbers: "Șiruri de Numere",
    matrix: "Matrice",
    string: "Șiruri de Caractere",
    graph: "Grafuri / Arbori",
    export: "Export"
  };

  buttons.forEach(btn => {
    if (btn.innerText === tabButtons[tabId]) {
      btn.classList.add('active');
    }
  });
}




window.onload = () => {
  openTab('numbers');
  toggleEdgeInput();
};




function toggleEdgeInput() {
  const complete = document.getElementById("graphComplete").checked;
  document.getElementById("edgeCountContainer").style.display = complete ? "none" : "block";
}

function generateNumbers() {
  const len = parseInt(document.getElementById("numLength").value);
  const min = parseInt(document.getElementById("numMin").value);
  const max = parseInt(document.getElementById("numMax").value);
  const numbers = [];

  for (let i = 0; i < len; i++) {
    numbers.push(Math.floor(Math.random() * (max - min + 1)) + min);
  }

  document.getElementById("numbersOutput").innerText = JSON.stringify(numbers);
saveToHistory("Șir de Numere", numbers);

}

function generateMatrix() {
  const rows = parseInt(document.getElementById("rows").value);
  const cols = parseInt(document.getElementById("cols").value);
  const min = parseInt(document.getElementById("minVal").value);
  const max = parseInt(document.getElementById("maxVal").value);

  const matrix = [];
  for (let i = 0; i < rows; i++) {
    const row = [];
    for (let j = 0; j < cols; j++) {
      row.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    matrix.push(row);
  }

  document.getElementById("matrixOutput").innerText = matrix.map(r => r.join(" ")).join("\n");
saveToHistory("Matrice", matrix);

}

function generateString() {
  const length = parseInt(document.getElementById("strLength").value);
  const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let result = "";

  for (let i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }

  document.getElementById("stringOutput").innerText = result;
  saveToHistory("String", string);
}

function generateGraph() {
  const n = parseInt(document.getElementById("graphNodes").value);
  const directed = document.getElementById("graphDirected").checked;
  const complete = document.getElementById("graphComplete").checked;
  const m = parseInt(document.getElementById("graphEdges")?.value || 0);

  const edges = [];
  const matrix = Array.from({ length: n }, () => Array(n).fill(0));
  const parent = Array(n).fill(-1);

  if (complete) {
    const used = new Set();
    for (let i = 0; i < n; i++) {
      for (let j = 0; j < n; j++) {
        if (i !== j) {
          if (directed) {
            if (!used.has(`${j}-${i}`)) {
              edges.push([i, j]);
              matrix[i][j] = 1;
              used.add(`${i}-${j}`);
            }
          } else {
            if (i < j) {
              edges.push([i, j]);
              matrix[i][j] = 1;
              matrix[j][i] = 1;
            }
          }
        }
      }
    }
  } else {
    const used = new Set();
    while (edges.length < m) {
      const u = Math.floor(Math.random() * n);
      const v = Math.floor(Math.random() * n);
      if (u === v) continue;

      const key = directed ? `${u}-${v}` : [Math.min(u, v), Math.max(u, v)].join("-");
      if (!used.has(key)) {
        edges.push([u, v]);
        matrix[u][v] = 1;
        if (!directed) matrix[v][u] = 1;
        used.add(key);
      }
    }

    for (let i = 1; i < n; i++) {
      if (parent[i] === -1) parent[i] = Math.floor(Math.random() * i);
    }
  }

  let result = "Lista muchii:\n" + edges.map(e => e.join(" ")).join("\n");
  result += "\n\nMatrice de adiacență:\n" + matrix.map(r => r.join(" ")).join("\n");
  result += "\n\nVector de tați:\n" + parent.join(" ");

  document.getElementById("graphOutput").innerText = result;
  saveToHistory("Graf", graph);

  if (n <= 10) {
    drawCustomGraphSVG(edges, n, directed, "graphSVG");
  }
}

function drawCustomGraphSVG(edges, n, directed, svgId) {
  const svg = document.getElementById(svgId);
  svg.innerHTML = "";

  const centerX = 200;
  const centerY = 200;
  const radius = 140;
  const angleStep = (2 * Math.PI) / n;

  const positions = [];

  for (let i = 0; i < n; i++) {
    const x = centerX + radius * Math.cos(i * angleStep);
    const y = centerY + radius * Math.sin(i * angleStep);
    positions.push({ x, y });
  }

  for (const [u, v] of edges) {
    const x1 = positions[u].x;
    const y1 = positions[u].y;
    const x2 = positions[v].x;
    const y2 = positions[v].y;

    const offset = 18;
    const dx = x2 - x1;
    const dy = y2 - y1;
    const dist = Math.sqrt(dx * dx + dy * dy);
    const ux = dx / dist;
    const uy = dy / dist;

    const startX = x1 + ux * offset;
    const startY = y1 + uy * offset;
    const endX = x2 - ux * offset;
    const endY = y2 - uy * offset;

    const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
    line.setAttribute("x1", startX);
    line.setAttribute("y1", startY);
    line.setAttribute("x2", endX);
    line.setAttribute("y2", endY);
    line.setAttribute("stroke", "#333");
    line.setAttribute("stroke-width", "2");
    svg.appendChild(line);

    if (directed) {
      const arrowSize = 6;
      const arrow = document.createElementNS("http://www.w3.org/2000/svg", "polygon");
      const points = [
        [endX, endY],
        [endX - uy * arrowSize - ux * arrowSize, endY + ux * arrowSize - uy * arrowSize],
        [endX + uy * arrowSize - ux * arrowSize, endY - ux * arrowSize - uy * arrowSize],
      ].map(p => p.join(",")).join(" ");
      arrow.setAttribute("points", points);
      arrow.setAttribute("fill", "#000");
      svg.appendChild(arrow);
    }
  }

  for (let i = 0; i < n; i++) {
    const { x, y } = positions[i];
    const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
    circle.setAttribute("cx", x);
    circle.setAttribute("cy", y);
    circle.setAttribute("r", 15);
    circle.setAttribute("fill", "#4CAF50");
    circle.setAttribute("stroke", "#222");
    circle.setAttribute("stroke-width", "1.5");
    svg.appendChild(circle);

    const label = document.createElementNS("http://www.w3.org/2000/svg", "text");
    label.setAttribute("x", x);
    label.setAttribute("y", y + 4);
    label.setAttribute("text-anchor", "middle");
    label.setAttribute("font-size", "13");
    label.setAttribute("fill", "white");
    label.textContent = i;
    svg.appendChild(label);
  }
}

function exportData() {
  const format = document.getElementById("exportFormat").value;
  const source = document.getElementById("exportSource").value;

  let data;
  switch (source) {
    case "numbers":
      data = document.getElementById("numbersOutput").innerText;
      break;
    case "matrix":
      data = document.getElementById("matrixOutput").innerText;
      break;
    case "string":
      data = document.getElementById("stringOutput").innerText;
      break;
    case "graph":
      data = document.getElementById("graphOutput").innerText;
      break;
    default:
      alert("Nicio sursă validă selectată.");
      return;
  }

  const blob = format === "json"
    ? new Blob([JSON.stringify(data)], { type: "application/json" })
    : new Blob([toCSV(data)], { type: "text/csv" });

  const a = document.createElement("a");
  a.href = URL.createObjectURL(blob);
  a.download = `export.${format}`;
  a.click();
}

function toCSV(text) {
  const lines = text.split("\n").filter(l => l.trim() !== "");
  return lines.map(line =>
    line.split(/\s+/).join(",")
  ).join("\n");
}


window.onload = () => {
  toggleEdgeInput();
};

function toggleEdgeInput() {
  const complete = document.getElementById("graphComplete").checked;
  document.getElementById("edgeCountContainer").style.display = complete ? "none" : "block";
}

// ----------------------------------------
// Generare șiruri de numere
function generateNumbers() {
  const len = parseInt(document.getElementById("numLength").value);
  const min = parseInt(document.getElementById("numMin").value);
  const max = parseInt(document.getElementById("numMax").value);
  const numbers = [];

  for (let i = 0; i < len; i++) {
    numbers.push(Math.floor(Math.random() * (max - min + 1)) + min);
  }

  document.getElementById("numbersOutput").innerText = JSON.stringify(numbers);
}

// ----------------------------------------
// Generare matrice
function generateMatrix() {
  const rows = parseInt(document.getElementById("rows").value);
  const cols = parseInt(document.getElementById("cols").value);
  const min = parseInt(document.getElementById("minVal").value);
  const max = parseInt(document.getElementById("maxVal").value);

  const matrix = [];
  for (let i = 0; i < rows; i++) {
    const row = [];
    for (let j = 0; j < cols; j++) {
      row.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    matrix.push(row);
  }

  document.getElementById("matrixOutput").innerText = matrix.map(r => r.join(" ")).join("\n");
}

// ----------------------------------------
// Generare șir caractere
function generateString() {
  const length = parseInt(document.getElementById("strLength").value);
  const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let result = "";

  for (let i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }

  document.getElementById("stringOutput").innerText = result;
}

// ----------------------------------------
// Generare graf/arbori
function generateGraph() {
  const n = parseInt(document.getElementById("graphNodes").value);
  const directed = document.getElementById("graphDirected").checked;
  const complete = document.getElementById("graphComplete").checked;
  const m = parseInt(document.getElementById("graphEdges")?.value || 0);

  const edges = [];
  const matrix = Array.from({ length: n }, () => Array(n).fill(0));
  const parent = Array(n).fill(-1);

  if (complete) {
    const used = new Set();
    for (let i = 0; i < n; i++) {
      for (let j = 0; j < n; j++) {
        if (i !== j) {
          if (directed) {
            if (!used.has(`${j}-${i}`)) {
              edges.push([i, j]);
              matrix[i][j] = 1;
              used.add(`${i}-${j}`);
            }
          } else {
            if (i < j) {
              edges.push([i, j]);
              matrix[i][j] = 1;
              matrix[j][i] = 1;
            }
          }
        }
      }
    }
  } else {
    const used = new Set();
    while (edges.length < m) {
      const u = Math.floor(Math.random() * n);
      const v = Math.floor(Math.random() * n);
      if (u === v) continue;

      const key = directed ? `${u}-${v}` : [Math.min(u, v), Math.max(u, v)].join("-");
      if (!used.has(key)) {
        edges.push([u, v]);
        matrix[u][v] = 1;
        if (!directed) matrix[v][u] = 1;
        used.add(key);
      }
    }

    for (let i = 1; i < n; i++) {
      if (parent[i] === -1) parent[i] = Math.floor(Math.random() * i);
    }
  }

  let result = "Lista muchii:\n" + edges.map(e => e.join(" ")).join("\n");
  result += "\n\nMatrice de adiacență:\n" + matrix.map(r => r.join(" ")).join("\n");
  result += "\n\nVector de tați:\n" + parent.join(" ");

  document.getElementById("graphOutput").innerText = result;

  if (n <= 10) {
    drawCustomGraphSVG(edges, n, directed, "graphSVG");
  }
}

// ----------------------------------------
// Desenare SVG graf
function drawCustomGraphSVG(edges, n, directed, svgId) {
  const svg = document.getElementById(svgId);
  svg.innerHTML = "";

  const centerX = 200;
  const centerY = 200;
  const radius = 140;
  const angleStep = (2 * Math.PI) / n;

  const positions = [];

  for (let i = 0; i < n; i++) {
    const x = centerX + radius * Math.cos(i * angleStep);
    const y = centerY + radius * Math.sin(i * angleStep);
    positions.push({ x, y });
  }

  for (const [u, v] of edges) {
    const x1 = positions[u].x;
    const y1 = positions[u].y;
    const x2 = positions[v].x;
    const y2 = positions[v].y;

    const offset = 18;
    const dx = x2 - x1;
    const dy = y2 - y1;
    const dist = Math.sqrt(dx * dx + dy * dy);
    const ux = dx / dist;
    const uy = dy / dist;

    const startX = x1 + ux * offset;
    const startY = y1 + uy * offset;
    const endX = x2 - ux * offset;
    const endY = y2 - uy * offset;

    const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
    line.setAttribute("x1", startX);
    line.setAttribute("y1", startY);
    line.setAttribute("x2", endX);
    line.setAttribute("y2", endY);
    line.setAttribute("stroke", "#333");
    line.setAttribute("stroke-width", "2");
    svg.appendChild(line);

    if (directed) {
      const arrowSize = 6;
      const arrow = document.createElementNS("http://www.w3.org/2000/svg", "polygon");

      const points = [
        [endX, endY],
        [endX - uy * arrowSize - ux * arrowSize, endY + ux * arrowSize - uy * arrowSize],
        [endX + uy * arrowSize - ux * arrowSize, endY - ux * arrowSize - uy * arrowSize],
      ].map(p => p.join(",")).join(" ");
      arrow.setAttribute("points", points);
      arrow.setAttribute("fill", "#000");
      svg.appendChild(arrow);
    }
  }

  for (let i = 0; i < n; i++) {
    const { x, y } = positions[i];
    const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
    circle.setAttribute("cx", x);
    circle.setAttribute("cy", y);
    circle.setAttribute("r", 15);
    circle.setAttribute("fill", "#4CAF50");
    circle.setAttribute("stroke", "#222");
    circle.setAttribute("stroke-width", "1.5");
    svg.appendChild(circle);

    const label = document.createElementNS("http://www.w3.org/2000/svg", "text");
    label.setAttribute("x", x);
    label.setAttribute("y", y + 4);
    label.setAttribute("text-anchor", "middle");
    label.setAttribute("font-size", "13");
    label.setAttribute("fill", "white");
    label.textContent = i;
    svg.appendChild(label);
  }
}

// ----------------------------------------
// Export JSON/CSV
function exportData() {
  const format = document.getElementById("exportFormat").value;
  const source = document.getElementById("exportSource").value;

  let data;
  switch (source) {
    case "numbers":
      data = document.getElementById("numbersOutput").innerText;
      break;
    case "matrix":
      data = document.getElementById("matrixOutput").innerText;
      break;
    case "string":
      data = document.getElementById("stringOutput").innerText;
      break;
    case "graph":
      data = document.getElementById("graphOutput").innerText;
      break;
    default:
      alert("Nicio sursă validă selectată.");
      return;
  }

  const blob = format === "json"
    ? new Blob([JSON.stringify(data)], { type: "application/json" })
    : new Blob([toCSV(data)], { type: "text/csv" });

  const a = document.createElement("a");
  a.href = URL.createObjectURL(blob);
  a.download = `export.${format}`;
  a.click();
}

function toCSV(text) {
  const lines = text.split("\n").filter(l => l.trim() !== "");
  return lines.map(line =>
    line.split(/\s+/).join(",")
  ).join("\n");
}


function saveToHistory(type, data) {
  const token = localStorage.getItem('token');
  if (!token) return;

  fetch('/api/verify', {
    headers: { 'Authorization': 'Bearer ' + token }
  })
  .then(res => res.ok ? res.json() : Promise.reject())
  .then(user => {
    const key = `history_${user.email}`;
    const history = JSON.parse(localStorage.getItem(key)) || [];
    history.push({
      type,
      data,
      timestamp: new Date().toLocaleString()
    });
    localStorage.setItem(key, JSON.stringify(history));
  });
}

function showHistory() {
  const token = localStorage.getItem('token');
  if (!token) return;

  fetch('/api/verify', {
    headers: { 'Authorization': 'Bearer ' + token }
  })
  .then(res => res.ok ? res.json() : Promise.reject())
  .then(user => {
    const key = `history_${user.email}`;
    const history = JSON.parse(localStorage.getItem(key)) || [];

    const container = document.getElementById('historyList');
    container.innerHTML = '';

    if (history.length === 0) {
      container.innerHTML = '<p>Nu există date salvate.</p>';
      return;
    }

    const table = document.createElement('table');
    table.style.borderCollapse = 'collapse';
    table.innerHTML = '<tr><th>Tip</th><th>Data</th><th>Generare</th></tr>';

    history.forEach(entry => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td style="padding:6px; border:1px solid #ccc;">${entry.type}</td>
        <td style="padding:6px; border:1px solid #ccc;">${entry.timestamp}</td>
        <td style="padding:6px; border:1px solid #ccc; white-space:pre-wrap;">${JSON.stringify(entry.data)}</td>
      `;
      table.appendChild(row);
    });

    container.appendChild(table);
  });
}
