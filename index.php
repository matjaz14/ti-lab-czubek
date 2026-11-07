<?php
$firma = 'Szprycha';
$rok = date('Y');
$cennik = [
    ['nazwa' => 'Przegląd podstawowy', 'cena' => 120],
    ['nazwa' => 'Wymiana dętki', 'cena' => 40],
    ['nazwa' => 'Regulacja hamulców i przerzutek', 'cena' => 80],
    ['nazwa' => 'Wymiana łańcucha', 'cena' => 90],
    ['nazwa' => 'Serwis generalny', 'cena' => 250],
];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Pracownia Rowerowa Szprycha w Bydgoszczy: przeglądy, naprawy i serwis rowerów. Sprawdź ofertę i cennik.">
  <title>Szprycha – pracownia rowerowa, Bydgoszcz</title>
  <link rel="stylesheet" href="style.css">
  <script src="app.js" defer> </script>
</head>
<body>
  <header class="site-header">
    <a class="logo" href="#">
      <svg viewBox="0 0 120 64" width="72" height="38" role="img" aria-labelledby="logo-tytul">
        <title id="logo-tytul">Szprycha</title>
        <g fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="28" cy="42" r="18"/>
          <circle cx="92" cy="42" r="18"/>
          <polyline points="28,42 48,14 80,14 92,42"/>
          <polyline points="48,14 60,42 80,14"/>
        </g>
      </svg>
      <span>Szprycha</span>
    </a>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="menu-glowne">Menu</button>
    <nav class="menu" id="menu-glowne" aria-label="Menu główne">
      <a href="#uslugi">Usługi</a>
      <a href="#cennik">Cennik</a>
      <a href="#kontakt">Kontakt</a>
    </nav>
  </header>

  <main>
    <div class="hero">
      <div class="hero__text">
        <h1>Serwis rowerowy w Bydgoszczy</h1>
        <p>Przeglądy, naprawy i regulacje. Szybko, uczciwie i w rozsądnej cenie.</p>
      </div>
      <img class="hero__img" src="hero.svg" width="320" height="200"
           alt="Uproszczona ilustracja roweru">
    </div>

    <section id="uslugi" class="section">
      <h2>Usługi</h2>
      <div class="cards">
        <article class="card">
          <h3>Przegląd podstawowy</h3>
          <p>Kontrola hamulców, przerzutek, łańcucha i ciśnienia w oponach.</p>
          <p class="card__price">od 120 zł</p>
        </article>

        <article class="card card--highlight">
          <p class="card__badge">Najczęściej wybierane</p>
          <h3>Naprawy i regulacje</h3>
          <p>Wymiana dętki, regulacja hamulców i przerzutek, centrowanie kół.</p>
          <p class="card__price">od 40 zł</p>
        </article>

        <article class="card">
          <h3>Serwis generalny</h3>
          <p>Pełne czyszczenie, smarowanie, wymiana zużytych części i test jazdy.</p>
          <p class="card__price">od 250 zł</p>
        </article>
      </div>
    </section>

    <section id="cennik" class="section">
      <h2>Cennik</h2>
      <table class="price-table">
        <thead>
          <tr>
            <th scope="col">Usługa</th>
            <th scope="col" class="num">Cena</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cennik as $usluga): ?>
            <tr>
              <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
              <td class="num"><?= $usluga['cena'] ?> zł</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>

  <footer id="kontakt" class="site-footer">
    <h2>Kontakt</h2>
    <address>
      Pracownia Rowerowa Szprycha<br>
      ul. Przykładowa 12, 85-000 Bydgoszcz<br>
      Tel.: <a href="tel:+48500100200">500 100 200</a><br>
      E-mail: <a href="mailto:kontakt@szprycha.example">kontakt@szprycha.example</a>
    </address>
    <p>Pn–Pt 9:00–17:00, sob. 9:00–13:00</p>
    <p>&copy; <?= $rok ?> <?= $firma ?></p>
  </footer>
</body>
</html>