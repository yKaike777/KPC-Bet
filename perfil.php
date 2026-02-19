<?php include 'header.php' ?>
<?php
    
    $stmt = $conn->prepare("SELECT saldo FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>




<?php include 'navbar.php'?>

<div class="container mt-5 mb-5">
    <?php include('message.php');?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Perfil</h2>
            <span><b><?= $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']?></b></span>
        </div>
        <div class="card-body">
            <div class="container d-flex justify-content-between align-items-center">
                <h3>Saldo</h3>
                <span class="text-success" style="font-size: 20pt">
                    <b>R$ <?= number_format($usuario['saldo'], 2, ',', '.') ?></b>
                </span>
            </div>
            <hr>
            <a href="saldo.php?id=1" class="btn btn-success float-end m-2">Adicionar Saldo</a>
            <a href="saldo.php?id=2" class="btn btn-danger float-end m-2">Sacar</a>
        </div>
    </div>
</div>
<?php include 'footer.php'?>