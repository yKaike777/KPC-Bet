<?php 
    session_start();
    require_once('config.php'); // Faz a conexão com o banco de dados

    if(isset($_POST['login'])){

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM usuarios WHERE email = ?"; //
        $stmt = $conn->prepare($sql);                    // Seleciona o usuario baseado no email
        $stmt->execute([$email]);                        //

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if($usuario && password_verify($password, $usuario['senha'])){ // Verifica se a senha está certa

            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_first_name'] = $usuario['primeiro_nome'];
            $_SESSION['user_last_name'] = $usuario['ultimo_nome'];
            // 👆 Pega os dados do Banco de Dados

            header("Location: index.php");
            exit;

        } else {
            $erro = true;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="input.css">
    <title>Login</title>
</head>
<body>
    <div id="form-container">
        <form method="post" id="form">
            <div class="container">
                <h1>Login</h1>

                <div class="row">
                    <div class="input-group">
                        <input type="email" name="email" id="email" required>
                        <label for="email">Email</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <input type="password" name="password" id="password" required>
                        <label for="password">Senha</label>
                    </div>
                </div>

                

                <input type="submit" name="login" id="login" value="Login">
            </div>
            <p>Ainda não possui uma conta? <a href="registration.php">Clique Aqui!</a></p>

            <div class="icons">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="50" alt="Facebook" class="icon">
                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="50" alt="Google" class="icon">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733553.png" width="50" alt="GitHub" class="icon">
            </div>
        </form>

        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <?php if(isset($erro)): // Se a senha não estiver certa, dispara um alerta ?> 
        <script>
        Swal.fire({
            title: 'Erro!',
            text: 'Email ou senha incorretos.',
            icon: 'error',
            confirmButtonText: 'Tentar novamente'
        });
        </script>
    <?php endif; ?>

</body>
</html>