document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#generateGraphForm");
  const resultDiv = document.querySelector("#graphResult");
  const svg = document.querySelector("#graphSvg");

  form?.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const numNodes = parseInt(formData.get("nodes"));
    const type = formData.get("type");

    fetch("/PIG/public/ajax/generate_graph", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((edges) => {
        if (!Array.isArray(edges)) {
          resultDiv.textContent = "Eroare: răspuns invalid.";
          return;
        }

        // Textual
        const text = edges.map(edge => edge.join(" ")).join("\n");
        resultDiv.textContent = text;

        // Desenare SVG doar dacă sunt ≤ 10 noduri
        if (numNodes <= 10) {
          drawGraph(edges, numNodes, type);
        } else {
          svg.innerHTML = ""; // șterge dacă sunt prea multe noduri
        }
      })
      .catch((err) => {
        resultDiv.textContent = "Eroare: " + err;
      });
  });

  function drawGraph(edges, numNodes, type) {
  // (Re)inserăm markerul pentru săgeți
  svg.innerHTML = `
    <defs>
      <marker id="arrowhead" markerWidth="10" markerHeight="7"
              refX="10" refY="3.5" orient="auto" markerUnits="strokeWidth">
        <polygon points="0 0, 10 3.5, 0 7" fill="#333" />
      </marker>
    </defs>
  `;

  const width = parseInt(svg.getAttribute("width"));
  const height = parseInt(svg.getAttribute("height"));
  const centerX = width / 2;
  const centerY = height / 2;
  const radius = Math.min(width, height) / 2 - 50;

  const coords = [];

  // Noduri poziționate pe cerc
  for (let i = 0; i < numNodes; i++) {
    const angle = (2 * Math.PI * i) / numNodes;
    const x = centerX + radius * Math.cos(angle);
    const y = centerY + radius * Math.sin(angle);
    coords.push({ x, y });

    // Cerc nod
    const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
    circle.setAttribute("cx", x);
    circle.setAttribute("cy", y);
    circle.setAttribute("r", 15);
    circle.setAttribute("fill", "#df7d90");
    svg.appendChild(circle);

    // Etichetă nod
    const label = document.createElementNS("http://www.w3.org/2000/svg", "text");
    label.setAttribute("x", x);
    label.setAttribute("y", y + 5);
    label.setAttribute("text-anchor", "middle");
    label.setAttribute("font-size", "12px");
    label.setAttribute("fill", "#fff");
    label.textContent = i;
    svg.appendChild(label);
  }

  // Muchii
  for (const edge of edges) {
    const [from, to, weight] = edge;
    const x1 = coords[from].x;
    const y1 = coords[from].y;
    const x2 = coords[to].x;
    const y2 = coords[to].y;

    const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
    line.setAttribute("x1", x1);
    line.setAttribute("y1", y1);
    line.setAttribute("x2", x2);
    line.setAttribute("y2", y2);
    line.setAttribute("stroke", "#333");
    line.setAttribute("stroke-width", "2");

    if (type === "directed") {
      line.setAttribute("marker-end", "url(#arrowhead)");
    }

    svg.appendChild(line);

    // Etichetă greutate pentru graf ponderat
    if (type === "weighted" && typeof weight !== "undefined") {
      const midX = (x1 + x2) / 2;
      const midY = (y1 + y2) / 2;

      const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
      text.setAttribute("x", midX + 5);
      text.setAttribute("y", midY - 5);
      text.setAttribute("fill", "#000");
      text.setAttribute("font-size", "12px");
      text.setAttribute("font-weight", "bold");
      text.setAttribute("text-anchor", "middle");
      text.textContent = weight;

      svg.appendChild(text);
    }
  }
}

});
