<?php

require '../../../config/config.php';
require '../../Classes/User.php';
require '../../Controllers/AuthController.php';

$messages = [];
$success = null;
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password === '' || $email === '') {
        $success = false;
        $messages[] = "Veuillez remplir tous les champs.";
    } elseif ($password !== $confirm) {
        $success = false;
        $messages[] = "Les mots de passe ne correspondent pas.";
    } else {
        $user = new User($email, $password);
        $controller = new AuthController($pdo);
        $result = $controller->register($user);
        $success = $result['success'] ?? false;
        $messages = $result['messages'] ?? [];
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background:#f8f9fa; }
        .auth-card { max-width: 520px; margin: 40px auto; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../../Index.php">To do List</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item me-2">
          <a class="btn btn-outline-light" href="Login.php">Se connecter</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-light text-primary" href="Register.php">S'inscrire</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container">
  <div class="auth-card">
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="card-title mb-3 text-center">S'inscrire</h4>

        <?php if (!empty($messages)): ?>
          <div class="mb-3">
            <?php if ($success === true): ?>
              <div class="alert alert-success">
                <?php foreach ($messages as $m): ?>
                  <div><?= htmlspecialchars($m, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php foreach ($messages as $m): ?>
                    <li><?= htmlspecialchars($m, ENT_QUOTES, 'UTF-8') ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <form method="post" action="" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" required class="form-control" placeholder="vous@exemple.com"
                   value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password" required class="form-control" placeholder="Mot de passe (min 8 caractères)">
          </div>

          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
            <input id="confirm_password" type="password" name="confirm_password" required class="form-control" placeholder="Confirmez le mot de passe">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">S'inscrire</button>
          </div>
        </form>

        <p class="mt-3 mb-0 text-center small">
          Déjà inscrit ? <a href="Login.php">Se connecter</a>
        </p>
      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>