<?php

require '../../../config/config.php';
require_once __DIR__ . '/../../Controllers/TaskController.php';
require_once __DIR__ . '/../../Classes/Task.php';

session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../Auth/Login.php');
    exit;
}

$errors = [];
$success = false;
$title = '';
$content = '';
$status = 1;
$ended_at = '';

$controller = new TaskController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = (int) ($_POST['status'] ?? 1);
    $ended_at = trim($_POST['ended_at'] ?? '') ?: null;
    $task = new Task($title, $content, $status, (int) $_SESSION['user_id'], null, $ended_at);
    $res = $controller->create($task);

    if ($res['success']) {
        header('Location: ../Dashboard.php');
        exit;
    } else {
        $errors = $res['messages'];
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Nouvelle tâche</title>
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
            --radius: 12px;
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

        .container-main {
            max-width: 820px;
            margin: 30px auto;
        }

        .form-card {
            max-width: 720px;
            margin: 20px auto;
        }

        .navbar.bg-primary {
            background: transparent !important;
            border-bottom: 1px solid var(--border);
        }

        .navbar .navbar-brand,
        .navbar .btn {
            color: var(--text) !important;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: none;
        }

        .form-control,
        .form-select {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            padding: 10px;
        }

        .btn-primary,
        .btn-outline-secondary {
            background: var(--btn-bg);
            color: var(--text) !important;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 8px;
        }

        .btn,
        .btn-primary,
        .btn-outline-secondary {
            transition: background .12s ease, color .12s ease, border-color .12s ease;
        }

        .btn:hover,
        .btn:focus,
        .btn:active {
            background: var(--azure) !important;
            border-color: var(--azure) !important;
            color: #fff !important;
        }

        .alert {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 8px;
            color: var(--text);
        }

        .alert.alert-danger {
            background: #ff4d4f;
            border-color: rgba(255, 77, 79, 0.12);
            color: #fff !important;
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

        .text-muted {
            color: var(--muted) !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../Index.php">To do List</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if (!empty($_SESSION['email'])): ?>
                        <li class="nav-item me-3 text-white small">Connecté :
                            <?= htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <form method="post" action="../Auth/Logout.php" class="mb-0">
                            <button type="submit" class="btn">Se déconnecter</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container container-main">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Nouvelle tâche</h1>
                <div class="text-muted small">Ajoutez une tâche à votre liste</div>
            </div>
            <div>
                <a href="../Dashboard.php" class="btn btn-outline-secondary">Retour</a>
            </div>
        </div>

        <div class="card form-card shadow-sm">
            <div class="card-body">
                <?php if ($success): ?>
                    <div class="alert alert-success">Tâche créée avec succès (sans persistance — branche ton modèle).</div>
                <?php elseif (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="" novalidate>
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input id="title" name="title" type="text" class="form-control" required
                            placeholder="Titre de la tâche"
                            value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Description</label>
                        <textarea id="content" name="content" rows="5" class="form-control"
                            placeholder="Détails de la tâche"><?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Statut</label>
                        <select id="status" name="status" class="form-select">
                            <option value="1" <?= $status === 1 ? 'selected' : '' ?>>Pas commencé</option>
                            <option value="2" <?= $status === 2 ? 'selected' : '' ?>>En cours</option>
                            <option value="3" <?= $status === 3 ? 'selected' : '' ?>>Terminé</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ended_at" class="form-label">Date de fin</label>
                        <input id="ended_at" name="ended_at" type="date" class="form-control"
                            value="<?= htmlspecialchars($ended_at ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Créer la tâche</button>
                        <a href="../Dashboard.php" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="text-center mt-5 mb-4 text-muted small">
        © <?= date('Y') ?> To do List — Projet local
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>