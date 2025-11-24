<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background:#f8f9fa; }
        .auth-card { max-width: 420px; margin: 40px auto; }
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
        <h4 class="card-title mb-3 text-center">Se connecter</h4>

        <?php if (!empty($errors ?? [])): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST" action="/login" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" required class="form-control" placeholder="vous@exemple.com"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password" required class="form-control" placeholder="Mot de passe">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Se connecter</button>
          </div>
        </form>

        <p class="mt-3 mb-0 text-center small">
          Pas encore de compte ? <a href="Register.php">S'inscrire</a>
        </p>
      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>