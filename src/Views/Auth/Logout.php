<?php
require '../../../config/config.php';
require '../../Controllers/AuthController.php';

$controller = new AuthController($pdo);
$controller->logout();

// rediriger vers la page d'accueil
header('Location: ../Index.php');
exit;
?>