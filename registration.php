<?php 
    require_once('config.php');
    $sucesso = false;

    if(isset($_POST['create'])){ // Depois do botão 'create' ser apertado, cria um novo usuário no banco de dados
        $profile        = 'comum';
        $firstName      = trim($_POST['first-name']);
        $lastName       = trim($_POST['last-name']);
        $email          = trim($_POST['email']);
        $phoneNumber    = preg_replace('/[^0-9]/', '', $_POST['phone-number']);
        $password       = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO usuarios (perfil, primeiro_nome, ultimo_nome, email, telefone, senha) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);

        $result= $stmt->execute([$profile, $firstName, $lastName, $email, $phoneNumber, $password]);

        if($result){
            header("Location: registration.php?success=1");
            exit;
        }

    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="input.css">
    <title>User Registration</title>
</head>
<body>
    
    <div id="form-container">
        <form action="registration.php" method="post" id="form">
            <div class="container">
                <h1>Registration</h1>

                <!-- Linha 1 -->
                <div class="row">
                    <div class="input-group">
                        <input type="text" name="first-name" id="first-name" required>
                        <label for="first-name">* Primeiro Nome</label>
                    </div>

                    <div class="input-group">
                        <input type="text" name="last-name" id="last-name" required>
                        <label for="last-name">* Último Nome</label>
                    </div>
                </div>

                <!-- Linha 2 (Email ocupa tudo) -->
                <div class="input-group full">
                    <input type="email" name="email" id="email" required>
                    <label for="email">* Email</label>
                </div>

                <!-- Linha 3 -->
                <div class="row">
                    <div class="input-group">
                        <input type="password" name="password" id="password" required>
                        <label for="password">* Senha</label>
                    </div>

                    <div class="input-group">
                        <input type="text" name="phone-number" id="phone-number" required>
                        <label for="phone-number">* Telefone</label>
                    </div>
                </div>

                <input type="submit" name="create" id="register" value="Sign Up">
            </div>
            <p>Já possui uma conta? <a href="login.php">Clique aqui!</a></p>

            <div class="icons">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="50" alt="Facebook" class="icon">
                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="50" alt="Google" class="icon">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733553.png" width="50" alt="GitHub" class="icon" id="github">
            </div>
        </form>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if(isset($_GET['success'])): ?>
    <script>
        Swal.fire({
            title: 'Tudo Certo!',
            text: 'Usuário salvo com sucesso!',
            icon: 'success'
        });
    </script>
    <?php endif; ?>
    
    <script src="js/main.js"></script>
</body>
</html>