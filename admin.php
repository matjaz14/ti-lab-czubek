<?php
require __DIR__ . '/auth.php';   // 1. strażnik
require __DIR__ . '/baza.php';

$blad = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   // 2. obsługa formularzy
    $akcja = $_POST['akcja'] ?? '';

    if ($akcja === 'dodaj') {
        $nazwa = trim($_POST['nazwa'] ?? '');
        $cena = (int) ($_POST['cena'] ?? 0);

        if ($nazwa !== '' && mb_strlen($nazwa) <= 100 && $cena > 0) {   // sprawdź
            $z = $pdo->prepare('INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)');
            $z->execute(['nazwa' => $nazwa, 'cena' => $cena]);          // zapisz
            header('Location: admin.php?ok=dodano');                     // przekieruj
            exit;
        }
        $blad = 'Podaj nazwę (do 100 znaków) i cenę większą od zera.';
    }
}

// 3. lista usług do tabeli
$uslugi = $pdo->query('SELECT id, nazwa, cena FROM uslugi ORDER BY nazwa')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel – Szprycha</title>
</head>
<body>
  <h1>Panel: Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?></h1>
  <p><a href="index.php">Zobacz stronę</a> | <a href="wyloguj.php">Wyloguj</a></p>

  <?php if (($_GET['ok'] ?? '') === 'dodano'): ?>
    <p role="status">Usługa dodana.</p>
  <?php endif; ?>

  <?php if ($blad !== ''): ?>
    <p role="alert"><?= htmlspecialchars($blad) ?></p>
  <?php endif; ?>

  <h2>Usługi</h2>
  <table border="1" cellpadding="6">
    <thead>
      <tr><th>Usługa</th><th>Cena</th></tr>
    </thead>
    <tbody>
      <?php foreach ($uslugi as $usluga): ?>
        <tr>
          <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
          <td><?= (int) $usluga['cena'] ?> zł</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h2>Dodaj usługę</h2>
  <form method="post">
    <input type="hidden" name="akcja" value="dodaj">
    <label for="nazwa">Nazwa</label>
    <input id="nazwa" name="nazwa" required maxlength="100">
    <label for="cena">Cena (zł)</label>
    <input id="cena" name="cena" type="number" min="1" required>
    <button>Dodaj</button>
  </form>
</body>