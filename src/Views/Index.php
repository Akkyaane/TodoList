<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>To do List - Accueil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --bg: #ffffff;
      --surface: #fafafa;
      --panel: #ffffff;
      --text: #0b0b0b;
      --muted: #6b6b6b;
      --border: rgba(0, 0, 0, 0.06);
      --btn-bg: rgba(0, 0, 0, 0.03);
      --radius: 14px;
      --status-done: #16a34a;
      --status-inprogress: #f97316;
      --status-todo: #ef4444;
      --azure: #0ca3ff;
    }

    body {
      padding-top: 70px;
      background: var(--surface);
      color: var(--text);
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .hero {
      padding: 64px 0;
    }

    .display-5 {
      color: var(--text);
      font-weight: 700;
    }

    .lead {
      color: var(--muted);
    }

    .navbar.bg-primary {
      background: transparent !important;
      border-bottom: 1px solid var(--border);
    }

    .navbar-brand {
      color: var(--text) !important;
    }

    .btn-primary,
    .btn-outline-primary,
    .btn-outline-light,
    .btn-light {
      background: var(--btn-bg);
      color: var(--text) !important;
      border: 1px solid rgba(0, 0, 0, 0.06);
      border-radius: 12px;
    }

    .btn,
    .btn-primary,
    .btn-outline-primary,
    .btn-outline-light,
    .btn-light {
      transition: background .12s ease, color .12s ease, border-color .12s ease;
    }

    .btn:hover,
    .btn:focus,
    .btn:active {
      background: var(--azure) !important;
      border-color: var(--azure) !important;
      color: #fff !important;
    }

    .task-sample {
      max-width: 720px;
      margin: 18px auto;
      background: var(--panel);
      border: 1px solid rgba(0, 0, 0, 0.03);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: none;
    }

    .list-group-item {
      border: none;
      border-bottom: 1px solid rgba(0, 0, 0, 0.03);
      padding: 10px 0;
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
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">To do List</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item me-2">
            <a class="btn btn-outline-light" href="Auth/Login.php">Se connecter</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-light text-primary" href="Auth/Register.php">S'inscrire</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="hero text-center">
    <div class="container">
      <h1 class="display-5">Organisez vos tâches simplement</h1>
      <p class="lead text-muted">Créez, suivez et terminez vos tâches quotidiennes avec une interface légère et
        efficace.</p>
      <p>
        <a class="btn btn-primary btn-lg me-2" href="Auth/Register.php">Commencer</a>
        <a class="btn btn-outline-primary btn-lg" href="Auth/Login.php">J'ai déjà un compte</a>
      </p>
    </div>
  </header>

  <main class="container">
    <section class="task-sample bg-white p-4 rounded shadow-sm">
      <h5>Exemple rapide</h5>
      <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Acheter du pain
          <span class="badge bg-success rounded-pill">Terminée</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Écrire rapport de réunion
          <span class="badge bg-warning text-dark rounded-pill">En cours</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Appeler le plombier
          <span class="badge bg-secondary rounded-pill">À faire</span>
        </li>
      </ul>
      <p class="mt-3 text-muted small">Créez un compte pour sauvegarder vos listes et y accéder depuis n'importe où.</p>
    </section>
  </main>

  <footer class="text-center mt-5 mb-4 text-muted small">
    © <?= date('Y') ?> To do List — Projet local
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>