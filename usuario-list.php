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
    <title>Lista de Usuários</title>
</head>
<body>
    <?php include 'navbar.php' ?>

    <div class="container mt-4">
        <?php include('message.php');?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Usuários
                            <a href="usuario-create.php" class="btn btn-primary float-end">Adicionar Usuário</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Perfil</th>
                                    <th>Primeiro Nome</th>
                                    <th>Último Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Saldo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql = "SELECT * FROM usuarios";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute(); 

                                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($usuarios){
                                        foreach($usuarios as $usuario){
                                    ?>
                                <tr>
                                    <td><?php echo $usuario['id']?></td>
                                    <td><?php echo $usuario['perfil']?></td>
                                    <td><?php echo $usuario['primeiro_nome']?></td>
                                    <td><?php echo $usuario['ultimo_nome']?></td>
                                    <td><?php echo $usuario['email']?></td>
                                    <td><?php echo $usuario['telefone']?></td>
                                    <td><?= number_format($usuario['saldo'], 2, ',', '.') ?></td>
                                    <td>
                                        <a href="usuario-view.php?id=<?=$usuario['id']?>" class="btn btn-secondary btn-sm">Visualizar</a>
                                        <a href="usuario-edit.php?id=<?=$usuario['id']?>" class="btn btn-success btn-sm">Editar</a>
                                        <form action="acoes.php?id=<?=$usuario['id']?>" method="post" class="d-inline">
                                            <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit" name="delete_usuario" value="<?=$usuario['id']?>" class="btn btn-danger btn-sm">Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else{
                                    echo '<h5>Nenhum usuário encontrado</h5>';
                                };
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>   
</body>
</html>