<?php include 'header.php' ?>

    <h1>Hello, World!</h1>
    <?php if($_SESSION['user_profile'] === 'admin'):?>

        <p>administrador, <?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];?></p>

    <?php elseif($_SESSION['user_profile'] === 'comum'): ?>

        <p>Bem-vindo, <?php echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];?>!</p>

    <?php endif; ?>
    <button onclick="window.location.href='logout.php'">Sair</button>
    
<?php include 'footer.php' ?>