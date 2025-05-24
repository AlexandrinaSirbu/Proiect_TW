const apiBase = '/pig_proj/public/api';

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
  const payload = {
    length:      document.getElementById("numLength")?.value,
    min:         document.getElementById("numMin")?.value,
    max:         document.getElementById("numMax")?.value,
    is_sorted:   document.getElementById("numSorted")?.value || 'none',
    values:      data
    // pentru celelalte tipuri, adaptează proprietățile din payload
  };
  fetch(`${apiBase}/save_${type.toLowerCase().replace(/ /g,'_')}.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(resp => {
    if (!resp.success) console.error('Save error', resp);
  })
  .catch(console.error);
}


function showHistory() {
  fetch(`${apiBase}/get_history.php`)
    .then(res => res.json())
    .then(rows => {
      const container = document.getElementById("historyList");
      container.innerHTML = '';
      if (!rows.length) {
        container.innerHTML = '<p>Istoricul este gol.</p>';
        return;
      }
      const table = document.createElement("table");
      table.innerHTML = '<tr><th>Tip</th><th>Data sesiune</th><th>Date</th></tr>';
      rows.forEach(r => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${r.type}</td>
          <td>${new Date(r.session_at).toLocaleString()}</td>
          <td><pre>${r.values_json || r.value}</pre></td>
        `;
        table.appendChild(row);
      });
      container.appendChild(table);
    })
    .catch(err => console.error(err));
}


function exportData() {
  const format = document.getElementById("exportFormat").value; 
  fetch(`${apiBase}/get_history.php`)
    .then(res => res.json())
    .then(rows => {
      const source = document.getElementById("exportSource").value; 
      const filtered = rows.filter(r => r.type === source);
      let blobContent, mime;
      if (format === 'json') {
        blobContent = JSON.stringify(filtered, null, 2);
        mime = 'application/json';
      } else {
        const lines = ['session_id,type,data'];
        filtered.forEach(r => {
          const d = r.values_json || r.value;
          lines.push(`${r.session_id},${r.type},"${d.toString().replace(/"/g,'""')}"`);
        });
        blobContent = lines.join('\n');
        mime = 'text/csv';
      }
      const blob = new Blob([blobContent], { type: mime });
      const a = document.createElement("a");
      a.href = URL.createObjectURL(blob);
      a.download = `export_${source}.${format}`;
      a.click();
    })
    .catch(console.error);
}




openTab('numbers');
