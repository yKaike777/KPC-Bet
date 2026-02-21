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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar Usuário
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
                        <form action="acoes.php?id=<?=$usuario['id']?>" method="post">

                            <input type="hidden" name="usuario_id" value="<?=$usuario['id']?>">
                        <div class="mb-3">
                            <label for="perfil">Perfil</label>
                            <select name="perfil" value="<?=$usuario['perfil']?>" class="form-control">
                                <option value="comum">Comum</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="first_name">* Primeiro Nome</label>
                            <input type="text" class="form-control" name="first_name" value="<?=$usuario['primeiro_nome']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name">* último Nome</label>
                            <input type="text" class="form-control" name="last_name" value="<?=$usuario['ultimo_nome']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">* Email</label>
                            <input type="email" class="form-control" name="email" value="<?=$usuario['email']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number">Telefone</label>
                            <input type="text" class="form-control" name="phone_number" value="<?=$usuario['telefone']?>">
                        </div>
                        <div class="mb-3">
                            <label for="saldo">Saldo</label>
                            <input type="number" class="form-control" name="saldo" value="<?=$usuario['saldo']?>" step='.01' max="100000">
                        </div>
                        <div class="mb-3">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                        <div class="mb-3">
                                <button type="submit" name="update_usuario" class="btn btn-primary">Editar</button>
                            </div>
                        </form>
                        <?php 
                            } else{
                                echo "<h5>Usuário não encontrado!</h5";
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