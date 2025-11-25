<?php
require '../../../config/config.php';
require '../../Classes/User.php';
require '../../Controllers/AuthController.php';

session_start();

if (!empty($_SESSION['user_id'])) {
  header('Location: ../Dashboard.php');
  exit;
}

$messages = [];
$success = null;
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  $controller = new AuthController($pdo);
  $result = $controller->login($email, $password);

  $success = $result['success'] ?? false;
  $messages = $result['messages'] ?? [];

  if ($success) {
    header('Location: ../Dashboard.php');
    exit;
  }
}
?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>To do List - Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --azure: #0ca3ff;
      --bg: #ffffff;
      --surface: #fafafa;
      --panel: #ffffff;
      --text: #0b0b0b;
      --muted: #6b6b6b;
      --border: rgba(0, 0, 0, 0.06);
      --btn-bg: rgba(0, 0, 0, 0.03);
      --radius: 12px;
      --status-done: #16a34a;
      --status-inprogress: #f97316;
      --status-todo: #ef4444;
    }

    body {
      padding-top: 70px;
      background: var(--surface);
      color: var(--text);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
    }

    .navbar.bg-primary {
      background: transparent !important;
      border-bottom: 1px solid var(--border);
    }

    .navbar-brand,
    .navbar .btn,
    .navbar .nav-link {
      color: var(--text) !important;
    }

    .card {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: none;
    }

    .card-body {
      padding: 24px;
    }

    .card-title {
      font-weight: 600;
      color: var(--text);
    }

    .form-label {
      color: var(--text);
      font-weight: 600;
    }

    .form-control {
      border: 1px solid rgba(0, 0, 0, 0.06);
      border-radius: 8px;
      padding: 10px 12px;
      background: #fff;
      color: var(--text);
    }

    .form-control::placeholder {
      color: #9fa3a6;
    }

    .btn-primary,
    .btn-outline-primary,
    .btn-outline-secondary,
    .btn-outline-light,
    .btn-light,
    .btn-danger,
    .btn-outline-danger,
    .btn-outline-dark {
      background: var(--btn-bg);
      color: var(--text) !important;
      border: 1px solid rgba(0, 0, 0, 0.06);
      border-radius: 8px;
      box-shadow: none;
    }

    .btn,
    .btn-outline-primary,
    .btn-outline-secondary,
    .btn-outline-light,
    .btn-light,
    .btn-danger,
    .btn-outline-danger,
    .btn-outline-dark {
      transition: background .12s ease, color .12s ease, border-color .12s ease;
    }

    .btn:hover,
    .btn:focus,
    .btn:active {
      background: var(--azure) !important;
      border-color: var(--azure) !important;
      color: #fff !important;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .alert {
      background: #fff;
      border: 1px solid rgba(0, 0, 0, 0.04);
      color: var(--text);
      border-radius: 8px;
    }

    .alert.alert-danger {
      background: #ff4d4f;
      /* rouge vif */
      border-color: rgba(255, 77, 79, 0.12);
      color: #fff !important;
    }

    .alert.alert-danger ul,
    .alert.alert-danger li {
      color: #fff;
    }

    .alert.alert-success {
      background: var(--status-done);
      border-color: rgba(22, 163, 74, 0.12);
      color: #fff !important;
    }

    .alert.alert-success ul,
    .alert.alert-success li {
      color: #fff;
    }

    .badge.bg-success {
      background: var(--status-done) !important;
      color: #fff !important;
    }

    .badge.bg-warning {
      background: var(--status-inprogress) !important;
      color: #fff !important;
    }

    .badge.bg-secondary {
      background: var(--status-todo) !important;
      color: #fff !important;
    }

    .text-muted {
      color: var(--muted) !important;
    }

    .auth-card {
      max-width: 420px;
      margin: 40px auto;
    }

    .btn-primary {
      padding: 8px 10px;
      border-radius: 8px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="../Index.php">To do List</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item me-2">
            <button type="button" class="btn btn-outline-light" onclick="location.href='Login.php'">Se
              connecter</button>
          </li>
          <li class="nav-item">
            <button type="button" class="btn btn-light text-primary"
              onclick="location.href='Register.php'">S'inscrire</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container">
    <div class="auth-card">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-3 text-center">Se connecter</h4>

          <?php if (!empty($messages)): ?>
            <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?>">
              <?php if (is_array($messages)): ?>
                <?php foreach ($messages as $err): ?>
                  <div><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endforeach; ?>
              <?php else: ?>
                <?= htmlspecialchars($messages, ENT_QUOTES, 'UTF-8') ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="" novalidate>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input id="email" type="email" name="email" required class="form-control" placeholder="vous@exemple.com"
                value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Mot de passe</label>
              <input id="password" type="password" name="password" required class="form-control"
                placeholder="Mot de passe">
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
          </form>

          <p class="mt-3 mb-0 text-center small">
            Pas encore de compte ? <button type="button" class="btn btn-sm btn-outline-primary"
              onclick="location.href='Register.php'">S'inscrire</button>
          </p>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>