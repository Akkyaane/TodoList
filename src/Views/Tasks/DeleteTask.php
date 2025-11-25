<?php
require '../../../config/config.php';
require_once __DIR__ . '/../../Controllers/TaskController.php';

session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../Auth/Login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Dashboard.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$controller = new TaskController($pdo);
$res = $controller->delete($id, (int) $_SESSION['user_id']);

header('Location: ../Dashboard.php');
exit;
