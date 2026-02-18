<?php 
    session_start();
    require_once 'config.php';

    if (isset($_POST['create_usuario'])){
        $perfil = trim($_POST['perfil']);
        $primeiro_nome = trim($_POST['first_name']);
        $ultimo_nome = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $telefone = preg_replace('/[^0-9]/', '', $_POST['phone_number']);
        $senha = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (perfil, primeiro_nome, ultimo_nome, email, telefone, senha) VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$perfil, $primeiro_nome, $ultimo_nome, $email, $telefone, $senha]);

        if ($result){
            $_SESSION['message'] = "Usuário criado com sucesso!";
            header("Location: usuario-list.php");
        } else{
            $_SESSION['message'] = "Erro ao criar usuário!";
            header("Location: usuario-list.php");           
        }
    }
?>