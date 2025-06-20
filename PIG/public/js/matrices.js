document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#generateForm");
    const resultDiv = document.querySelector("#result");
  
    form?.addEventListener("submit", function (e) {
      e.preventDefault();
  
      const formData = new FormData(this);
  
      fetch("/PIG/public/ajax/generate_matrix", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (Array.isArray(data)) {
            const text = data.map(row => row.join(" ")).join("\n");
            resultDiv.textContent = text;
          } else {
            resultDiv.textContent = "Eroare: răspuns invalid.";
          }
        })
        .catch((err) => {
          resultDiv.textContent = "Eroare: " + err;
        });
    });
  });
  