<?php 
    session_start();
    require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>CRUD</title>
</head>
<body>
    <?php include 'navbar.php' ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Visualizar Usuário
                            <a href="usuario-list.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php 
                            if (isset($_GET['id'])){
                                $usuario_id = $_GET['id'];

                                $sql = "SELECT * FROM usuarios WHERE id = :id";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([':id' => $usuario_id]);

                                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="mb-3">
                            <label for="perfil">Perfil</label>
                            <p class="form-control"><?php if ($usuario['perfil'] == 'admin'){
                                echo 'Administrador';
                            } else{
                                echo 'Comum';
                            }?></p>
                        </div>
                        <div class="mb-3">
                            <label for="first_name">Primeiro Nome</label>
                            <p class="form-control"><?php echo $usuario['primeiro_nome'];?></p>
                        </div>
                        <div class="mb-3">
                            <label for="last_name">Último Nome</label>
                            <p class="form-control"><?php echo $usuario['ultimo_nome'];?></p>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <p class="form-control"><?php echo $usuario['email'];?></p>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number">Telefone</label>
                            <p class="form-control"><?php echo $usuario['telefone'];?></p>
                        </div>
                        <div class="mb-3">
                            <label for="saldo">Saldo</label>
                            <p class="form-control"><?php echo $usuario['saldo'];?></p>
                        </div>
                        <?php 
                            } else{
                                echo "<h5>Usuário não encontrado!</h5>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>