
let currentUser = null;

window.addEventListener('DOMContentLoaded', () => {

  fetch('/pig_proj/public/verify')
    .then(res => res.json())
    .then(data => {
      if (!data.loggedIn) {
        window.location.href = '/pig_proj/public/login';
      } else {
        currentUser = data;
        document.getElementById('userInfo').innerText =
          '👤 Utilizator: ' + (data.username || data.email);
      }
    })
    .catch(err => {
      console.error('Eroare la verify:', err);
      window.location.href = '/pig_proj/public/login';
    });
});

function logout() {

  fetch('/pig_proj/public/logout')
    .then(res => {
      console.log('logout response status:', res.status);
      return res.json();
    })
    .then(data => {
      console.log('logout JSON:', data);
      if (data.success) {
        window.location.href = '/pig_proj/public/login';
      } else {
        console.error('Logout a eșuat pe server');
      }
    })
    .catch(err => console.error('Eroare la logout:', err));
}


function openTab(id) {
  document.querySelectorAll('.tab-content')
    .forEach(el => el.style.display = 'none');
  document.querySelectorAll('.tab')
    .forEach(el => el.classList.remove('active'));

  document.getElementById(id).style.display = 'block';
  if (event && event.target) {
    event.target.classList.add('active');
  }
}

function generateNumbers() {
  const len = parseInt(document.getElementById("numLength").value, 10);
  const min = parseInt(document.getElementById("numMin").value, 10);
  const max = parseInt(document.getElementById("numMax").value, 10);
  const arr = Array.from({ length: len }, () =>
    Math.floor(Math.random() * (max - min + 1)) + min
  );
  document.getElementById("numbersOutput").innerText = JSON.stringify(arr);
  saveToHistory("Șir de Numere", arr);
}

function generateMatrix() {
  const rows = parseInt(document.getElementById("rows").value, 10);
  const cols = parseInt(document.getElementById("cols").value, 10);
  const min = parseInt(document.getElementById("minVal").value, 10);
  const max = parseInt(document.getElementById("maxVal").value, 10);
  const matrix = Array.from({ length: rows }, () =>
    Array.from({ length: cols }, () =>
      Math.floor(Math.random() * (max - min + 1)) + min
    )
  );
  document.getElementById("matrixOutput").innerText =
    matrix.map(row => row.join(" ")).join("\n");
  saveToHistory("Matrice", matrix);
}

function generateString() {
  const len = parseInt(document.getElementById("strLength").value, 10);
  const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let str = '';
  for (let i = 0; i < len; i++) {
    str += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  document.getElementById("stringOutput").innerText = str;
  saveToHistory("Șir de Caractere", str);
}

function toggleEdgeInput() {
  const complete = document.getElementById("graphComplete").checked;
  document.getElementById("edgeCountContainer").style.display =
    complete ? "none" : "block";
}

function generateGraph() {
  const n = parseInt(document.getElementById("graphNodes").value, 10);
  const directed = document.getElementById("graphDirected").checked;
  const complete = document.getElementById("graphComplete").checked;
  const m = parseInt(document.getElementById("graphEdges")?.value || 0, 10);

  const edges = [];
  const used = new Set();

  if (complete) {
    for (let i = 0; i < n; i++) {
      for (let j = 0; j < n; j++) {
        if (i !== j && (!directed && i < j || directed)) {
          const key = `${i}-${j}`;
          if (!used.has(key)) {
            edges.push([i, j]);
            used.add(key);
          }
        }
      }
    }
  } else {
    while (edges.length < m) {
      const u = Math.floor(Math.random() * n);
      const v = Math.floor(Math.random() * n);
      if (u !== v) {
        const key = directed
          ? `${u}-${v}`
          : [Math.min(u, v), Math.max(u, v)].join("-");
        if (!used.has(key)) {
          edges.push([u, v]);
          used.add(key);
        }
      }
    }
  }

  document.getElementById("graphOutput").innerText =
    edges.map(e => e.join(" ")).join("\n");
  saveToHistory("Graf", edges);
}

function saveToHistory(type, data) {
  if (!currentUser || !currentUser.email) return;
  const key = `history_${currentUser.email}`;
  const history = JSON.parse(localStorage.getItem(key) || '[]');
  history.push({ type, data, timestamp: new Date().toLocaleString() });
  localStorage.setItem(key, JSON.stringify(history));
}

function showHistory() {
  if (!currentUser || !currentUser.email) return;
  const key = `history_${currentUser.email}`;
  const history = JSON.parse(localStorage.getItem(key) || '[]');
  const container = document.getElementById("historyList");
  container.innerHTML = '';

  if (history.length === 0) {
    container.innerHTML = '<p>Istoricul este gol.</p>';
    return;
  }

  const table = document.createElement("table");
  table.innerHTML = '<tr><th>Tip</th><th>Data</th><th>Valoare</th></tr>';
  history.forEach(entry => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${entry.type}</td>
      <td>${entry.timestamp}</td>
      <td><pre>${JSON.stringify(entry.data)}</pre></td>
    `;
    table.appendChild(row);
  });
  container.appendChild(table);
}

function exportData() {
  const format = document.getElementById("exportFormat").value;
  const source = document.getElementById("exportSource").value;
  const data = document.getElementById(source + "Output").innerText;
  const blob = new Blob(
    [format === "json" ? JSON.stringify(JSON.parse(data)) : data.replace(/\s+/g, ',')],
    { type: format === "json" ? "application/json" : "text/csv" }
  );
  const a = document.createElement("a");
  a.href = URL.createObjectURL(blob);
  a.download = `export.${format}`;
  a.click();
}

openTab('numbers');
