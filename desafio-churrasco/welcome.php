<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
require_once("conexao.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  $id       = $_SESSION['id'];
  $presenca = $_POST['presenca'];
  $sql      = "UPDATE funcionario SET presenca='" . $presenca . "' where id='" . $id . "'";
  $Result1 = mysqli_query($conn, $sql) or die(mysqli_error());
  header("Location: logout.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Churrasco Hammer - Bem Vindo</title>
  </head>
  <body>
    <nav class="menu">
      <a href="index.php"><img src="img/logo.png" alt="Logo Hammer"></a>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="cadastro.php">Cadastro</a></li>
        <li><a href="about.php">Sobre Nós</a></li>
		<li><a href="logout.php">Deslogar</a></li> 
      </ul>
    </nav>
    <section class="main-section">
      <div class="boas-vindas">
        <h1>Seja bem vindo, <b><?php echo htmlspecialchars(ucfirst($_SESSION["nome"])); ?></b></h1>
        
        <div class="btn-boas-vindas">
          <a href="crud-convidado.php" class="btn-secundario" style="margin-right: 20px">Meus Convidados</a>
          <?php
            $presenca = $_SESSION['presenca'];
            if ($presenca == 'sim'){
              echo "
              <form action='' method='post' class='contact-form'>
              <input type='hidden' name='acao'>
              <input type='hidden' name='presenca' value='nao'>
              <input type='submit' name='submit' class='btn-secundario' value='Cancelar Presença'>
              </form>";
            }  else {
              echo "
              <form action='' method='post' class='contact-form'>
              <input type='hidden' name='acao'>
              <input type='hidden' name='presenca' value='sim'>
              <input type='submit' name='submit' class='btn-secundario' value='Marcar Presença'>
              </form>";
            }
          ?>
        </div>
      </div>
    </section>
    <link rel="stylesheet" type="text/css" href="js/alert/lib/sweet-alert.css">
    <script src="js/alert/lib/sweet-alert.js"></script>
    <script type="text/javascript">
      function enviando() {
          swal({title:"Aguarde...", text:"Estamos processando sua solicitação.", type:"info", timer:6000});
          };
          function aviso_erro(){
            swal({title:"Falhou!", text:"Você só pode convidar uma pessoa.", type:"error", timer:6000});
          };
          function aviso_editado(){
            swal({title:"Sucesso!", text:"Alteração salva com sucesso!", type:"success", timer:6000});
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
      			location.href="funcoes/delete-convidado.php?acao=deletar_convidado&id=" + id_item;
      		});
      };
    </script>
  </body>
</html>