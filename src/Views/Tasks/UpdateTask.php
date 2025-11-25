<?php
require '../../../config/config.php';
require_once __DIR__ . '/../../Controllers/TaskController.php';
require_once __DIR__ . '/../../Classes/Task.php';

session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../Auth/Login.php');
    exit;
}

$controller = new TaskController($pdo);

$errors = [];
$success = false;

$id = isset($_GET['id']) ? (int) $_GET['id'] : (int) ($_POST['id'] ?? 0);

$taskData = $id > 0 ? $controller->findById($id, (int) $_SESSION['user_id']) : null;

if (!$taskData) {
    $task = null;
} else {
    $task = new Task($taskData['title'], $taskData['content'], (int) $taskData['status_id'], (int) $taskData['user_id'], (int) $taskData['id'], $taskData['ended_at'] ?? null);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $task !== null) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = (int) ($_POST['status'] ?? 1);
    $ended_at = trim($_POST['ended_at'] ?? '') ?: null;

    $task->setTitle($title);
    $task->setContent($content);
    $task->setStatusId($status);
    $task->setEndedAt($ended_at);

    $res = $controller->update($task);
    if ($res['success']) {
        $success = true;
        $taskData = $controller->findById($id, (int) $_SESSION['user_id']);
    } else {
        $errors = $res['messages'];
    }
}

$endedInput = '';
if (!empty($taskData['ended_at'])) {
    $d = date_create($taskData['ended_at']);
    $endedInput = $d ? $d->format('Y-m-d') : $taskData['ended_at'];
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Modifier la tâche</title>
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

        .navbar.bg-primary {
            background: transparent !important;
            border-bottom: 1px solid var(--border);
        }

        .navbar .navbar-brand,
        .navbar .btn {
            color: var(--text) !important;
        }

        body {
            padding-top: 70px;
            background: #f8f9fa;
        }

        .container-main {
            max-width: 820px;
            margin: 30px auto;
        }

        .form-card {
            max-width: 760px;
            margin: 20px auto;
        }

        .btn-primary,
        .btn-outline-secondary,
        .btn-outline-danger {
            background: var(--btn-bg);
            color: var(--text) !important;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 8px;
        }

        .btn,
        .btn-primary,
        .btn-outline-secondary,
        .btn-outline-danger {
            transition: background .12s ease, color .12s ease, border-color .12s ease;
        }

        .btn:hover,
        .btn:focus,
        .btn:active {
            background: var(--azure) !important;
            border-color: var(--azure) !important;
            color: #fff !important;
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
                <h1 class="h4 mb-0">Modifier la tâche</h1>
                <div class="text-muted small">Mettez à jour les informations de la tâche</div>
            </div>
            <div>
                <a href="../Dashboard.php" class="btn btn-outline-secondary">Retour</a>
            </div>
        </div>

        <div class="card form-card shadow-sm">
            <div class="card-body">
                <?php if (!$task): ?>
                    <div class="alert alert-warning">Tâche introuvable.</div>
                <?php else: ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success">Tâche mise à jour avec succès.</div>
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
                        <input type="hidden" name="id"
                            value="<?= htmlspecialchars($taskData['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input id="title" name="title" type="text" class="form-control" required
                                placeholder="Titre de la tâche"
                                value="<?= htmlspecialchars($taskData['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu / Description</label>
                            <textarea id="content" name="content" rows="6" class="form-control"
                                placeholder="Détails de la tâche"><?= htmlspecialchars($taskData['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="status" class="form-label">Statut</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1" <?= ((int) ($taskData['status_id'] ?? 1) === 1) ? 'selected' : '' ?>>Pas
                                        commencé
                                    </option>
                                    <option value="2" <?= ((int) ($taskData['status_id'] ?? 1) === 2) ? 'selected' : '' ?>>En
                                        cours</option>
                                    <option value="3" <?= ((int) ($taskData['status_id'] ?? 1) === 3) ? 'selected' : '' ?>>
                                        Terminé
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ended_at" class="form-label">Date de fin</label>
                            <input id="ended_at" name="ended_at" type="date" class="form-control"
                                value="<?= htmlspecialchars($endedInput, ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <?php if (!empty($taskData['ended_at'])): ?>
                            <?php $dt = date_create($taskData['ended_at']); ?>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <a href="../Dashboard.php" class="btn btn-outline-secondary">Annuler</a>
                            <form method="post" action="DeleteTask.php" onsubmit="return confirm('Supprimer cette tâche ?');"
                                class="ms-auto mb-0">
                                <input type="hidden" name="id"
                                    value="<?= htmlspecialchars($taskData['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <button class="btn btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="text-center mt-5 mb-4 text-muted small">
        © <?= date('Y') ?> To do List — Projet local
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>