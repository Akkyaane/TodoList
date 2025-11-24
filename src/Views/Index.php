<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background:#f8f9fa; }
        .hero { padding: 60px 0; }
        .task-sample { max-width: 720px; margin: 0 auto; }
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
    <p class="lead text-muted">Créez, suivez et terminez vos tâches quotidiennes avec une interface légère et efficace.</p>
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