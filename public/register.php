<?php

require '../config/db.php';
require '../src/Classes/User.php';
require '../src/Controllers/AuthController.php';

$message = '';
$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = new User($email, $password);

    $controller = new AuthController($pdo);
    $result = $controller->register($user);

    if ($result['success']) {
        $messages = $result['messages'];
    } else {
        $messages = $result['messages'];
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php if (!empty($messages)): ?>
        <ul>
            <?php foreach ($messages as $m): ?>
                <li><?php echo htmlspecialchars($m, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="">
        <label>Email :</label><br>
        <input type="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
