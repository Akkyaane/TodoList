<?php
require '../../../config/config.php';
require '../../Controllers/AuthController.php';

$controller = new AuthController($pdo);
$controller->logout();

header('Location: ../Index.php');
exit;
?>