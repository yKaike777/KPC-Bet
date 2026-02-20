<?php include 'header.php'?>
<?php include 'navbar.php'?>

<div class="container">
    <h1></h1>
    <p>Hoje é dia</p>

    <form method="post">
        <input type="text" name="nome" placeholder="Digite seu nome">
        <br><br>
        <button type="submit">Enviar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = htmlspecialchars($_POST["nome"]);
        echo "<h2>Olá, $nome! 👋</h2>";
    }
    ?>
</div>


<h2>🎰 Roleta</h2>

<div class="roleta-container">
    <div class="ponteiro"></div>
    <div class="roleta" id="roleta"></div>
</div>

<button onclick="girar()">Girar</button>
<a href="index.php" class="btn btn-success">Voltar</a>

<script>
function girar() {
    const roleta = document.getElementById("roleta");
    const graus = 3600 + Math.floor(Math.random() * 360);
    roleta.style.transform = "rotate(" + graus + "deg)";
}
</script>

<?php include 'footer.php'?>

