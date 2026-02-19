<nav class="navbar navbar-dark bg-dark d-flex justify-content-around p-3">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div style="margin-left: 50px;">
    <a href="index.php" class="navbar-brand">HOME</a>
    <a href="index.php" class="navbar-brand">Apostas Esportivas</a>
    <?php if ($_SESSION['user_profile'] === 'admin'):
      echo "<a href='usuario-list.php' class='navbar-brand'>Lista de Usuários</a>";
    ?>
    <?php endif; ?>
    </div>


<div class="dropdown d-flex align-items-center gap-2">
  
  <span class="text-light">
    <?php
      if ($_SESSION['user_profile'] === "admin"){
        echo "<span class='text-success'><b>Admin</b></span> " . $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
      } else{
        echo $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];
      }
       
    ?>
  </span>

  <button class="btn p-0 border-0"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          style="height: 30px; width: 30px; border-radius: 50%; background-color: grey;">
  </button>

  <ul class="dropdown-menu dropdown-menu-end">
    <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
    <li><a class="dropdown-item" href="#">Configurações</a></li>
    <li><a class="dropdown-item text-danger" href="logout.php">Sair</a></li>
  </ul>

</div>

  </div>
</nav>