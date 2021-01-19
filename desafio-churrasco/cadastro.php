<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: welcome.php");
  exit;
}
require_once "conexao.php";
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $nome         = trim($_POST['nome']);
  $email        = trim($_POST['email']);
  $presenca     = trim($_POST['presenca']);
  $bebe         = trim($_POST['bebe']);
  $senha        = trim($_POST['senha']);
  $confirm_pass = trim($_POST['confirm_pass']);
  $pass_hash    = password_hash($senha, PASSWORD_DEFAULT);
  if ($query = $conn->prepare("SELECT * FROM funcionario WHERE email = ?")) {
    $query->bind_param('s', $email);
    $query->execute();
    $query->store_result();
    if ($query->num_rows > 0) {
      $error .= '<p class="error"> O email já está registrado!</p>';
    } else {
      if (strlen($senha) < 6) {
        $error .= '<p class="error">Sua senha deve conter mais de 6 caracteres.</p>';
      }
      if (empty($confirm_pass)) {
        $error .= '<p class="error">Por favor confirme sua senha!</p>';
      } else {
        if (empty($error) && ($senha != $confirm_pass)) {
          $error .= '<p class="error">Suas senhas não batem!</p>';
        }
      }
      if (empty($error)) {
        $insertQuery = $conn->prepare("INSERT INTO funcionario(nome, email, senha, presenca, bebe) values (?, ?, ?, ?, ?);");
        $insertQuery->bind_param("sssss", $nome, $email, $pass_hash, $presenca, $bebe);
        $result = $insertQuery->execute();
        if ($result) {
          $error .= '<p class="error">Seu cadastro foi um sucesso!</p>';
        } else {
          $error .= '<p class="error">Algo está errado</p>';
        }
      }
    }
  }
  $query->close();
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro</title>
  </head>
  <body>
    <nav class="menu">
      <a href="index.php"><img src="img/logo.png" alt="Logo Hammer"></a>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="cadastro.php">Cadastro</a></li>
        <li><a href="about.php">Sobre Nós</a></li>
      </ul>
    </nav>
    <section class="main-section">
      <div class="login">
        <h1>Cadastro</h1>
        <?php echo $error; ?>
        <div class="login-form">
          <form action="" method="post">
            <p>Complete os campos para confirmar seu cadastro.</p>
            <div class="form-group">
              <label>Digite seu nome completo</label>
              <input class="input-form" type="text" name="nome" class="form-control" required>
              <label>Digite seu e-mail</label>
              <input class="input-form" type="email" name="email" class="form-control" required>
              <label>Você irá ir no churrasco?</label>          
              <div class="form-check">
                <input type="radio" name="presenca" id="exampleRadios1" value="sim" checked>
                <label for="exampleRadios1">
                Sim
                </label>
                <input type="radio" name="presenca" id="exampleRadios2" value="nao">
                <label for="exampleRadios2">
                Não
                </label>
              </div>
              <label>Você irá beber?</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="bebe" id="exampleRadios1" value="sim" checked>
                <label class="form-check-label" for="exampleRadios1">
                Sim
                </label>
                <input class="form-check-input" type="radio" name="bebe" id="exampleRadios2" value="nao">
                <label class="form-check-label" for="exampleRadios2">
                Não
                </label>
              </div>
              <label>Digite sua senha</label>
              <input class="input-form" type="password" name="senha" class="form-control" required>
              <label>Confirme sua senha</label>
              <input class="input-form" type="password" name="confirm_pass" class="form-control" required>            
              <input type="submit" name="submit" class="btn-pequeno" value="Enviar">
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
</html>