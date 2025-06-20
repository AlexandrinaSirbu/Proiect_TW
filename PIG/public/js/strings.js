//strings.js
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#generateForm");
    const resultDiv = document.querySelector("#result");
  
    form?.addEventListener("submit", function (e) {
      e.preventDefault();
  
      const formData = new FormData(this);
  
      fetch("/PIG/public/ajax/generate_string", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data && typeof data.generated === "string") {
            resultDiv.textContent = data.generated;
          } else {
            resultDiv.textContent = "Eroare: răspuns invalid.";
          }
        })
        .catch((err) => {
          resultDiv.textContent = "Eroare: " + err;
        });
    });
  });
  