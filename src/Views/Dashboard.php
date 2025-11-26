<?php

require '../../config/config.php';
require_once __DIR__ . '/../Controllers/TaskController.php';

session_start();

if (empty($_SESSION['user_id'])) {
    header('Location: Auth/Login.php');
    exit;
}

$controller = new TaskController($pdo);
$tasks = $controller->findAllByUser((int) $_SESSION['user_id']);

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Tableau de bord</title>
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
            max-width: 1000px;
            margin: 30px auto;
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

        .table thead th {
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            color: var(--text);
            font-weight: 600;
            background: transparent;
        }

        .table-hover tbody tr:hover {
            background: rgba(0, 0, 0, 0.02);
        }

        .btn-primary,
        .btn-outline-primary,
        .btn-outline-secondary {
            background: var(--btn-bg);
            color: var(--text) !important;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 8px;
        }

        .btn,
        .btn-primary,
        .btn-outline-primary,
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
            <a class="navbar-brand fw-bold" href="Index.php">To do List</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <form method="post" action="Auth/Logout.php" class="mb-0">
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
                                <th> Date de fin </th>
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
                                            $badge = match ((int) $t['status_id']) {
                                                3 => 'success',
                                                2 => 'warning',
                                                default => 'secondary',
                                            };
                                            $statusLabel = match ((int) $t['status_id']) {
                                                3 => 'Terminée',
                                                2 => 'En cours',
                                                default => 'Pas commencé',
                                            };
                                            ?>
                                            <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($statusLabel) ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($t['ended_at'])):
                                                $d = date_create($t['ended_at']);
                                                echo htmlspecialchars($d ? $d->format('d/m/Y') : $t['ended_at'], ENT_QUOTES, 'UTF-8');
                                            endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="Tasks/UpdateTask.php?id=<?= urlencode($t['id']) ?>"
                                                class="btn btn-sm me-1">Modifier</a>
                                            <form method="post" action="Tasks/DeleteTask.php" class="d-inline-block"
                                                onsubmit="return confirm('Supprimer cette tâche ?');">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($t['id']) ?>">
                                                <button class="btn btn-sm btn-outline-primary">Supprimer</button>
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