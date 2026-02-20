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

    if (isset($_POST['update_usuario'])){
        $usuario_id = $_GET['id'];
        $perfil = trim($_POST['perfil']);
        $primeiro_nome = trim($_POST['first_name']);
        $ultimo_nome = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $saldo = $_POST['saldo'];
        $telefone = preg_replace('/[^0-9]/', '', $_POST['phone_number']);
        $senha = trim($_POST['password']);
        
        $sql = "UPDATE usuarios
        SET perfil = :perfil,
            primeiro_nome = :primeiro_nome,
            ultimo_nome = :ultimo_nome,
            email = :email,
            saldo = :saldo,
            telefone = :telefone";

        if (!empty($senha)){
            $sql .= ", senha = :senha";
        }

        $sql .= " WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $params = [
            ':perfil' => $perfil,
            ':primeiro_nome' => $primeiro_nome,
            ':ultimo_nome' => $ultimo_nome,
            ':email' => $email,
            ':saldo' => $saldo,
            ':telefone' => $telefone,
            ':id' => $usuario_id
        ];

        if (!empty($senha)) {
            $params[':senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        $result = $stmt->execute($params);

        if ($result){
            $_SESSION['message'] = "Usuário atualizado com sucesso!";
            header("Location: usuario-list.php");
        } else{
            $_SESSION['message'] = "Erro ao atualizar usuário!";
            header("Location: usuario-list.php");           
        }
    }

    if (isset($_POST['delete_usuario'])){
        $usuario_id = $_GET['id'];  

        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ':id' => $usuario_id
            ]);

        if ($result){
            $_SESSION['message'] = "Usuário deletado com sucesso!";
            header("Location: usuario-list.php");
            exit;
        } else{
            $_SESSION['message'] = "Erro ao deletar usuário";
            header("Location: usuario-list.php");
            exit;
        }
    }

    if (isset($_POST['adicionar_saldo'])){

        session_start();
        require_once('config.php');

        $usuario_id = $_SESSION['user_id'];
        $quantia = floatval($_POST['quantia']);

        if ($quantia <= 0){
            $_SESSION['message'] = "Valor inválido!";
            header("Location: perfil.php");
            exit;
        }

        $sql = "UPDATE usuarios SET saldo = saldo + :quantia WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ':id' => $usuario_id,
            ':quantia' => $quantia
        ]);

        if ($result){
            $_SESSION['message'] = "Saldo adicionado com sucesso!";
        } else{
            $_SESSION['message'] = "Erro ao adicionar saldo.";
        }

        header("Location: perfil.php");
        exit;
    }

    if (isset($_POST['sacar_saldo'])){

        session_start();
        require_once('config.php');

        $usuario_id = $_SESSION['user_id'];
        $quantia = floatval($_POST['quantia']);

        if ($quantia <= 0){
            $_SESSION['message'] = "Valor inválido!";
            header("Location: perfil.php");
            exit;
        }

        $sql = "UPDATE usuarios 
                SET saldo = saldo - :quantia 
                WHERE id = :id 
                AND saldo >= :quantia";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => $usuario_id,
            ':quantia' => $quantia
        ]);

        if ($stmt->rowCount() > 0){
            $_SESSION['message'] = "Saque efetuado com sucesso!";
        } else{
            $_SESSION['message'] = "Saldo insuficiente!";
        }

        header("Location: perfil.php");
        exit;
    }

    if(isset($_POST['apostar'])){

        $quantia_aposta = $_POST['quantia_aposta'];
        $odd = $_POST['odd'];

        $probabilidade = (1 / $odd) * 100;
        

        function gerarResultado($probabilidade){
            return (mt_rand(1,100) <= $probabilidade) ? 1 : 0;
        }

        $resultado = gerarResultado($probabilidade);

        if ($resultado == 1){
            $mensagem = "Você ganhou";
        } else{
            $mensagem = "Você perdeu";
        }

        $saldo_atual = $quantia_aposta * $odd;
        echo "ODD: $odd <br>";
        echo "Probabilidade: " . number_format($probabilidade, 2) . "% <br>";
        echo "Quantia apostada: R$ " . number_format($quantia_aposta, 2, ',', '.') . "<br>";
        echo "Resultado: $mensagem <br>";
        echo "Saldo: R$ " . number_format($saldo_atual, 2, ',', '.') ;
    }

?>