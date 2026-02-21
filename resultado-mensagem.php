<?php 
    session_start();
    require_once 'config.php';
    if (isset($_SESSION['resultado_mensagem'])):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="bg-dark d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <?php if($_SESSION['resultado_mensagem'] === "Você Ganhou!"): ?>
            <h1 class="text-success" style="font-size: 12rem">
                <?= $_SESSION['resultado_mensagem'] ?>
            </h1>
            <span class="text-light">Dinheiro ganho: <?= number_format($_SESSION['saldo_atualizado'], 2, ',', '.')?> </span>
            <span class="text-light">Seu saldo atual: <?= number_format($_SESSION['user_balance'], 2, ',', '.') ?> </span>

            <a href="index.php" class="btn btn-success position-fixed bottom-0 m-5">Voltar</a>
        <?php else: ?>
            <h1 class="text-danger" style="font-size: 12rem">
                <?= $_SESSION['resultado_mensagem'] ?>
            </h1> 
            <a href="index.php" class="btn btn-danger position-fixed bottom-0 m-5">Voltar</a>
            <span class="text-light">Seu saldo atual: <?= number_format($_SESSION['user_balance'], 2, ',', '.') ?> </span>
            
        <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

<?php 
    unset($_SESSION['resultado_mensagem']);
    endif;
?>