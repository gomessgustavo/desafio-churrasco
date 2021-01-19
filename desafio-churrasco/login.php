<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: welcome.php");
  exit;
}
require_once "conexao.php";
$username     = $password = "";
$username_err = $password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["email"]))) {
    $username_err = "Insira seu e-mail.";
  } else {
    $username = trim($_POST["email"]);
  }
  if (empty(trim($_POST["senha"]))) {
    $password_err = "Insira sua senha.";
  } else {
    $password = trim($_POST["senha"]);
  }
  if (empty($username_err) && empty($password_err)) {
    $sql = "SELECT id, nome, email, senha, presenca FROM funcionario WHERE email = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      $param_username = $username;
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $id, $nome, $username, $hashed_password, $presenca);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
              session_start();
              $_SESSION["loggedin"] = true;
              $_SESSION["nome"]     = $nome;
              $_SESSION["id"]       = $id;
              $_SESSION["username"] = $username;
              $_SESSION["presenca"] = $presenca;
              header("location: welcome.php");
            } else {
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          $username_err = "No account found with that username.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      mysqli_stmt_close($stmt);
    }
  }
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
  <title>Churrasco Hammer - Login</title>
</head>
<body
<?php if(isset($_GET['acao'])){?>onLoad="<?php
		if($_GET['acao'] == 'erro'){echo 'aviso_erro();'; }
		if($_GET['acao'] == 'sucesso'){echo 'aviso_editado();'; }
		if($_GET['acao'] == 'inserido'){echo 'aviso_inserido();'; }
		if($_GET['acao'] == 'deletado'){echo 'aviso_deletado();'; }
		?>"<?php } ?>>
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
        <h1>LOGIN</h1>       
        <div class="login-form">
        <form action="" method="post">
            <div class="form-group">
              <label>Digite seu e-mail</label>
              <input class="input-form" type="email" name="email" class="form-control" required>
              <label>Digite sua senha</label>
              <input class="input-form" type="password" name="senha" class="form-control" required>
              <input type="submit" name="submit" class="btn-pequeno" value="Enviar">
            </div>
          </form>
        </div>
     </div>
   </section>
   <link rel="stylesheet" type="text/css" href="js/alert/lib/sweet-alert.css">
  <script src="js/alert/lib/sweet-alert.js"></script>
  <script type="text/javascript">
  function enviando(){
        swal({title:"Aguarde...", text:"Estamos processando sua solicitação.", type:"info", timer:6000});
      };
      function aviso_erro(){
        swal({title:"Falhou!", text:"Você só pode convidar uma pessoa.", type:"error", timer:6000});
      };
      function aviso_editado(){
        swal({title:"Sucesso!", text:"Alteração salva com sucesso! Você foi deslogado para atualizar os seus dados!", type:"success", timer:6000});
      };
      function aviso_inserido(){
        swal({title:"Sucesso!", text:"Inserido com sucesso!", type:"success", timer:6000});
      };		
      function aviso_deletado(){
        swal({title:"Sucesso!", text:"Deletado com sucesso!", type:"success", timer:6000});
      };

  function aviso_deletar_convidado(id){
			var id_item	= id;
			swal({
				title: "Seu convidado não irá mais?",
				text: "Após confirmar não há como recuperar!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				cancelButtonText: "Cancelar",
				confirmButtonText: "Sim, pode cancelar presenca!",
				closeOnConfirm: false },
				function(){
					location.href="funcoes/deleteConvidado.php?acao=deletar_convidado&id="+id_item;
				});
		};
        </script>

    
  
  
</body>
</html>