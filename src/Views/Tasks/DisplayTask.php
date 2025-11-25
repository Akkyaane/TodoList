<?php
require '../../../config/config.php';

session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../Auth/Login.php');
    exit;
}

$id = $_GET['id'] ?? null;
$task = null;

if ($id !== null) {
    $task = [
        'id' => (int) $id,
        'title' => 'Exemple de tâche #' . htmlspecialchars($id),
        'content' => "Description détaillée de la tâche exemple. Remplacez par la logique réelle.",
        'status' => 'En cours',
        'due' => '2025-12-01'
    ];
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>To do List - Tâche</title>
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

        .task-card {
            max-width: 760px;
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

        h3.h5 {
            color: var(--text);
            font-weight: 600;
        }

        .text-muted {
            color: var(--muted) !important;
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

        .btn-outline-primary,
        .btn-outline-danger {
            border: 1px solid rgba(0, 0, 0, 0.06);
            color: var(--text) !important;
            background: var(--btn-bg);
            border-radius: 8px;
            padding: 6px 10px;
        }

        .btn,
        .btn-outline-primary,
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

        .alert {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.04);
            color: var(--text);
            border-radius: 8px;
        }

        .alert.alert-danger {
            background: #ff4d4f;
            border-color: rgba(255, 77, 79, 0.12);
            color: #fff !important;
        }

        .alert.alert-danger ul,
        .alert.alert-danger li {
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
                            <?= htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?></li>
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
                <h1 class="h4 mb-0">Détails de la tâche</h1>
                <div class="text-muted small">Consultez et gérez cette tâche</div>
            </div>
            <div>
                <a href="../Dashboard.php" class="btn btn-outline-secondary">Retour</a>
            </div>
        </div>

        <?php if (!$task): ?>
            <div class="card task-card shadow-sm">
                <div class="card-body">
                    <div class="alert alert-warning mb-0">Tâche introuvable.</div>
                </div>
            </div>
        <?php else: ?>
            <div class="card task-card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="h5 mb-1"><?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <div class="text-muted mb-2 small">Échéance :
                                <?= htmlspecialchars($task['due'], ENT_QUOTES, 'UTF-8') ?></div>
                            <p class="mb-3"><?= nl2br(htmlspecialchars($task['content'], ENT_QUOTES, 'UTF-8')) ?></p>
                            <div>
                                <?php
                                $badge = match ($task['status']) {
                                    'Terminé', 'Terminée' => 'success',
                                    'En cours' => 'warning',
                                    default => 'secondary',
                                };
                                ?>
                                <span
                                    class="badge bg-<?= $badge ?>"><?= htmlspecialchars($task['status'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="Edit.php?id=<?= urlencode($task['id']) ?>"
                                class="btn btn-sm btn-outline-primary mb-2">Modifier</a>
                            <form method="post" action="Delete.php" onsubmit="return confirm('Supprimer cette tâche ?');"
                                class="d-inline-block">
                                <input type="hidden" name="id"
                                    value="<?= htmlspecialchars($task['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer class="text-center mt-5 mb-4 text-muted small">
        © <?= date('Y') ?> To do List — Projet local
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>