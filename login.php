<?php
session_start();
require __DIR__ . '/baza.php';

if (!empty($_SESSION['uzytkownik'])) {
    header('Location: admin.php');
    exit;
}

$blad = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $z = $pdo->prepare(
        'SELECT login, haslo_hash FROM uzytkownicy WHERE login = :login');
    $z->execute(['login' => trim($_POST['login'] ?? '')]);
    $u = $z->fetch();

    if ($u && password_verify($_POST['haslo'] ?? '', $u['haslo_hash'])) {
        session_regenerate_id(true);
        $_SESSION['uzytkownik'] = $u['login'];
        header('Location: admin.php');
        exit;
    }
    $blad = 'Błędny login lub hasło.';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logowanie – Szprycha</title>
</head>
<body>
  <h1>Logowanie</h1>
  <?php if ($blad !== ''): ?>
    <p role="alert"><?= htmlspecialchars($blad) ?></p>
  <?php endif; ?>
  <form method="post">
    <label for="login">Login</label>
    <input id="login" name="login" required>
    <label for="haslo">Hasło</label>
    <input id="haslo" name="haslo" type="password" required>
    <button>Zaloguj</button>
  </form>
</body>
</html>