<?php

require '../../config/config.php';

session_start();

$tasks = $tasks ?? [
    ['id'=>1, 'title'=>'Acheter du pain', 'status'=>'Terminée', 'due'=>'2025-11-20'],
    ['id'=>2, 'title'=>"Écrire rapport de réunion", 'status'=>'En cours', 'due'=>'2025-11-27'],
    ['id'=>3, 'title'=>'Appeler le plombier', 'status'=>'À faire', 'due'=>'2025-12-01'],
];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background:#f8f9fa; }
        .container-main { max-width: 1000px; margin: 30px auto; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="Index.php">To do List</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <form method="post" action="Auth/Logout.php" class="mb-0">
            <button type="submit" class="btn btn-danger">Se déconnecter</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container container-main">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h4 mb-0">Tableau de bord</h1>
      <div class="text-muted small">Gérez vos tâches</div>
    </div>
    <div>
      <a href="Tasks/CreateTask.php" class="btn btn-primary">+ Nouvelle tâche</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th> Tâche </th>
              <th> Statut </th>
              <th> Échéance </th>
              <th class="text-end"> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($tasks)): ?>
              <tr>
                <td colspan="4" class="text-center text-muted">Aucune tâche — créez la première !</td>
              </tr>
            <?php else: ?>
              <?php foreach ($tasks as $t): ?>
                <tr>
                  <td><?= htmlspecialchars($t['title'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td>
                    <?php
                      $badge = match($t['status']) {
                        'Terminée' => 'success',
                        'En cours' => 'warning',
                        default => 'secondary',
                      };
                    ?>
                    <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($t['status']) ?></span>
                  </td>
                  <td><?= htmlspecialchars($t['due']) ?></td>
                  <td class="text-end">
                    <a href="Tasks/Edit.php?id=<?= urlencode($t['id']) ?>" class="btn btn-sm btn-outline-primary me-1">Modifier</a>
                    <form method="post" action="Tasks/Delete.php" class="d-inline-block" onsubmit="return confirm('Supprimer cette tâche ?');">
                      <input type="hidden" name="id" value="<?= htmlspecialchars($t['id']) ?>">
                      <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<footer class="text-center mt-5 mb-4 text-muted small">
  © <?= date('Y') ?> To do List — Projet local
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>