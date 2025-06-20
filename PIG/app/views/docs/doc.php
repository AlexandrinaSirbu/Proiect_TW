<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Specificația cerințelor aplicației PIG</title>
  <meta name="author" content="Echipa PIG">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background-color: #f9f9fb;
      color: #222;
      margin: 0;
      padding: 2rem;
      line-height: 1.6;
    }

    article {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 2rem 3rem;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #2b4b80;
    }

    h2 {
      color: #2b4b80;
      border-bottom: 2px solid #d0d7e4;
      padding-bottom: 4px;
      margin-top: 2rem;
    }

    h3 {
      margin-top: 1.5rem;
      color: #3b3b3b;
      font-size: 1.2rem;
      border-left: 4px solid #2b4b80;
      padding-left: 0.6rem;
      margin-bottom: 0.8rem;
      background-color: #eef3fc;
      padding-top: 0.2rem;
      padding-bottom: 0.2rem;
      border-radius: 4px;
    }

    ul {
      padding-left: 1.5rem;
    }

    li {
      margin-bottom: 0.5rem;
    }

    section ul li strong {
      color: #2b4b80;
    }

    strong {
      color: #222;
    }

    p {
      text-align: justify;
    }

    .diagram {
      text-align: center;
      margin-top: 1rem;
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>
  <article typeof="schema:ScholarlyArticle">
    <h1>Specificația cerințelor software – Aplicația PIG</h1>

    <section typeof="schema:Introduction">
      <h2>1. Introducere</h2>
      <p>
        Acest document descrie cerințele funcționale și nefuncționale pentru aplicația Web <strong>PIG</strong> – un generator modular de inputuri pentru probleme de informatică. Aplicația va fi accesibilă printr-o interfață Web și va permite generarea de șiruri de numere, matrice, șiruri de caractere, grafuri și arbori.
      </p>
    </section>

    <section>
      <h2>2. Descriere generală</h2>
      <ul>
        <li><strong>Utilizatori vizați:</strong> elevi, studenți, profesori sau pasionați de algoritmică.</li>
        <li><strong>Scopul aplicației:</strong> generarea rapidă și personalizată de date de intrare pentru probleme de tip algoritmic.</li>
        <li><strong>Platformă:</strong> aplicație Web accesibilă din browser, responsive.</li>
      </ul>
    </section>

    <section>
      <h2>3. Cerințe funcționale</h2>
      <ul>
        <li>
          Utilizatorii pot genera:
          <ul>
            <li>Șiruri de numere (configurabile: lungime, interval, ordine)</li>
            <li>Matrice (dimensiune, valori etc.)</li>
            <li>Grafuri și arbori (configurabile: conex, orientat, bipartit, ponderat etc.)</li>
          </ul>
        </li>
        <li>Grafuri cu mai puțin de 10 noduri sunt reprezentate SVG.</li>
        <li>Autentificarea permite stocarea inputurilor și exportul în formate JSON/CSV.</li>
      </ul>
    </section>

    <section>
      <h2>4. Interfața cu utilizatorul</h2>
      <p>
        Interfața este realizată în HTML și CSS și permite interacțiune intuitivă, pe pași, cu actualizare în timp real a preview-ului datelor generate. Designul este responsive și compatibil cu toate dispozitivele moderne.
      </p>
    </section>

    <section>
      <h2>5. Cerințe nefuncționale</h2>
      <ul>
        <li>Performanță: generarea inputurilor trebuie să fie aproape instantanee .</li>
        <li>Portabilitate: aplicația trebuie să funcționeze în browsere moderne (Chrome, Firefox, Edge).</li>
        <li>Licențiere: codul va fi publicat sub o licență liberă compatibilă Creative Commons.</li>
      </ul>
    </section>

    <section>
      <h2>6. Cerințe privind stocarea datelor</h2>
      <ul>
        <li>Utilizatorii autentificați pot salva inputurile generate.</li>
        <li>Datele pot fi exportate în format <strong>JSON</strong> și <strong>CSV</strong>.</li>
        <li>Datele persistă în baza de date a proiectului pentru revizitare.</li>
      </ul>
    </section>

    <section>
      <h2>7. Arhitectura de ansamblu și etapele dezvoltării</h2>

      <h3>7.1 Arhitectura aplicației (Model C4 - nivel contextual & container)</h3>
      <p>
        Aplicația PIG urmează o arhitectură de tip <strong>client-server</strong>, separată în următoarele componente:
      </p>
      <ul>
        <li>
          <strong>Frontend (Client Web):</strong> aplicație Web construită cu HTML, CSS și JavaScript, responsabilă de interacțiunea utilizatorului și trimiterea cererilor către backend.
        </li>
        <li>
          <strong>Backend (Server logică aplicație):</strong> aplicație scrisă în PHP, care gestionează logica de generare a inputurilor, autentificarea utilizatorilor și interacțiunea cu baza de date.
        </li>
        <li>
          <strong>Baza de date:</strong> sistem de stocare a utilizatorilor autentificați și a istoricului inputurilor generate, exportabile ulterior în formate JSON și CSV.
        </li>
      </ul>
      <p>
        Componenta backend expune puncte de acces interne (rute) la care frontend-ul trimite cereri POST/GET pentru generare și stocare date.
      </p>


      <h3>7.2 Etapele dezvoltării proiectului</h3>
      <ul>
        <li><strong>Etapa 1:</strong> Analiza cerințelor și redactarea specificației</li>
        <li><strong>Etapa 2:</strong> Proiectarea interfeței și prototipare rapidă a UI/UX</li>
        <li><strong>Etapa 3:</strong> Implementarea modulelor de generare (șiruri, matrici, grafuri etc.)</li>
        <li><strong>Etapa 4:</strong> Implementarea funcționalităților de autentificare și salvare în baza de date</li>
        <li><strong>Etapa 5:</strong> Adăugarea exportului CSV/JSON și a vizualizării SVG</li>
        <li><strong>Etapa 6:</strong> Testare, refinare UI și pregătirea pentru prezentare</li>
      </ul>
    </section>
    <section>
        <h2>8. Soluția funcțională și modelarea datelor</h2>

        <p>
            Aplicația PIG oferă o soluție complet funcțională, evaluabilă conform cerințelor funcționale și nefuncționale prezentate anterior. Funcționalitatea este accesibilă printr-o interfață Web modulară, care permite generarea, vizualizarea, salvarea și exportul datelor în diferite formate.
        </p>

        <h3>8.1 Modelarea datelor</h3>
        <p>
            Structura datelor generate este reprezentată intern prin obiecte JSON. Fiecare modul (șiruri, matrici, grafuri, arbori) are un format dedicat, care permite păstrarea clară a conținutului și metadatelor:
        </p>
        <ul>
            <li><strong>Șiruri:</strong> vectori de numere sau caractere în format JSON (e.g., <code>[1, 2, 3]</code>).</li>
            <li><strong>Matrici:</strong> liste de liste cu dimensiune și tip specificat.</li>
            <li><strong>Grafuri/arbori:</strong> reprezentări variate – listă de muchii, matrice de adiacență, vectori de tați, etc.</li>
        </ul>

        <p>
            Salvarea datelor în baza de date se face cu metainformații (tip, dată generare, utilizator) pentru a permite afișarea ulterioară în pagina de istoric.
        </p>

        <h3>8.2 Proveniența și sursele datelor</h3>
        <p>
            Toate datele sunt generate intern, folosind funcții implementate în backend-ul aplicației. Pentru diversitate și complexitate, se pot utiliza:
        </p>
        <ul>
            <li>Algoritmi randomizați (cu seed opțional pentru reproducibilitate).</li>
            <li>Intervale și reguli definite de utilizator pentru generare controlată.</li>
        </ul>
    </section>

  </article>
</body>
</html>
