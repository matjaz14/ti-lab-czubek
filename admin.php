<?php
require __DIR__ . '/auth.php';   // 1. strażnik
require __DIR__ . '/baza.php';

$blad = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   // 2. obsługa formularzy
    $akcja = $_POST['akcja'] ?? '';

    if ($akcja === 'dodaj') {
        $nazwa = trim($_POST['nazwa'] ?? '');
        $cena = (int) ($_POST['cena'] ?? 0);

        if ($nazwa !== '' && mb_strlen($nazwa) <= 100 && $cena > 0) {
            $z = $pdo->prepare('INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)');
            $z->execute(['nazwa' => $nazwa, 'cena' => $cena]);
            header('Location: admin.php?ok=dodano');
            exit;
        }
        $blad = 'Podaj nazwę (do 100 znaków) i cenę większą od zera.';
    }

    if ($akcja === 'usun') {
        $z = $pdo->prepare('DELETE FROM uslugi WHERE id = :id');
        $z->execute(['id' => (int) ($_POST['id'] ?? 0)]);
        header('Location: admin.php?ok=usunieto');
        exit;
    }
}

$komunikaty = [
    'dodano' => 'Usługa dodana.',
    'usunieto' => 'Usługa usunięta.',
];
$ok = $komunikaty[$_GET['ok'] ?? ''] ?? '';

// 3. lista usług do tabeli
$uslugi = $pdo->query('SELECT id, nazwa, cena FROM uslugi ORDER BY nazwa')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel – Szprycha</title>
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <div class="container">
      <span class="navbar-brand">Szprycha · panel</span>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="index.php">Zobacz stronę</a>
        <a class="nav-link" href="wyloguj.php">Wyloguj</a>
      </div>
    </div>
  </nav>

  <main class="container">
    <h1 class="h3 mb-3">Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?></h1>

    <?php if ($ok !== ''): ?>
      <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
    <?php endif; ?>

    <?php if ($blad !== ''): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($blad) ?></div>
    <?php endif; ?>

    <div class="row g-4">
      <div class="col-lg-8">
        <table class="table table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col">Usługa</th>
              <th scope="col" class="text-end">Cena</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($uslugi as $usluga): ?>
              <tr>
                <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
                <td class="text-end"><?= (int) $usluga['cena'] ?> zł</td>
                <td class="text-end">
                  <form method="post" class="d-inline">
                    <input type="hidden" name="akcja" value="usun">
                    <input type="hidden" name="id" value="<?= (int) $usluga['id'] ?>">
                    <button class="btn btn-sm btn-outline-danger">Usuń</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="col-lg-4">
        <h2 class="h5">Dodaj usługę</h2>
        <form method="post">
          <input type="hidden" name="akcja" value="dodaj">
          <div class="mb-3">
            <label for="nazwa" class="form-label">Nazwa</label>
            <input id="nazwa" name="nazwa" class="form-control" required maxlength="100">
          </div>
          <div class="mb-3">
            <label for="cena" class="form-label">Cena (zł)</label>
            <input id="cena" name="cena" type="number" min="1" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Dodaj</button>
        </form>
      </div>
    </div>
  </main>
</body>
</html>