<?php include 'header.php' ?>
<?php
    
    $stmt = $conn->prepare("SELECT saldo FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    $page = $_GET['id'];
?>




<?php include 'navbar.php'?>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <?php if($page === '1'){ echo "<h2 class='text-success'>Adicionar Saldo</h2>"; } else{
                    echo "<h2 class='text-danger'>Sacar</h2>";
                }?>
            <span><b><?= $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name']?></b></span>
        </div>
        <div class="card-body">
            <div class="container d-flex justify-content-between align-items-center">
                <h3>Saldo atual</h3>
                <span class="text-success" style="font-size: 20pt">
                    <b>R$ <?= number_format($usuario['saldo'], 2, ',', '.') ?></b>
                </span>
            </div>
            <hr>
            <form action="acoes.php" method="post">
                <?php if($page === '1'){
                    echo "<label for='quantia' class='text-dark mb-1'>Quantidade que deseja adicionar (Em Reais):</label>";
                    echo "
                    <div class='input-group mb-3'>
                    <div class='input-group-prepend'>
                        <span class='input-group-text'>$</span>
                    </div>
                    <input type='number' step='.01' class='form-control' name='quantia' aria-label='Amount (to the nearest dollar)'>
                    <div class='input-group-append'>
                        <span class='input-group-text'>.00</span>
                    </div>
                    </div>";

                    echo "<button type='submit' class='btn btn-success float-end m-1' name='adicionar_saldo'>Adicionar</button>";
                } else{
                    echo "<label for='quantia' class='text-dark mb-1'>Quantidade que deseja sacar (Em Reais):</label>";
                    echo "
                    <div class='input-group mb-3'>
                    <div class='input-group-prepend'>
                        <span class='input-group-text'>$</span>
                    </div>
                    <input type='number' step='.01' class='form-control' name='quantia' aria-label='Amount (to the nearest dollar)'>
                    <div class='input-group-append'>
                        <span class='input-group-text'>.00</span>
                    </div>
                    </div>"; 
                    
                    echo "<button type='submit' class='btn btn-danger float-end m-1' name='sacar_saldo'>Sacar</button>";
                }?>

                
                <a href="perfil.php" type="submit" class="btn btn-primary float-end m-1">Voltar</a>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'?>