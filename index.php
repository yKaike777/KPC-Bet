<?php 
    session_start();            //
    require_once('config.php'); // Inicia a sessão e conecta com o banco de daddos
    
    if(!isset($_SESSION['user_id'])){ // Se a sessão não foi iniciada, manda pro login
        header("Location: login.php");
        exit;
    };

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello, World!</h1>
    <?php if($_SESSION['user_profile'] === 'admin'):?>

        <p>administrador, <?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];?></p>

    <?php elseif($_SESSION['user_profile'] === 'comum'): ?>

        <p>Bem-vindo, <?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];?>!</p>

    <?php endif; ?>
    <button onclick="window.location.href='logout.php'">Sair</button>
</body>
</html>