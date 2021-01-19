<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
$emailConvidado = $_SESSION['username'];
require_once("funcoes/consultas.php");
$convidado = consulta_convidado($conn, $emailConvidado);

$id  = $_SESSION['id'];
$sql = $conn->prepare("SELECT * FROM convidado WHERE id = ?");
$sql -> bind_param("i", $id);
$sql -> execute();
$sql -> store_result(); 
$row = $sql->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Churrasco Hammer - Convidados</title>
  </head>
  <body <?php if(isset($_GET['acao'])){?>onLoad="<?php
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
		<li><a href="logout.php">Deslogar</a></li> 
      </ul>
    </nav>
    <section class="main-section">
      <div class="convidados">
      <h1>Adicionar Convidado</h1>
      <form action="funcoes/insert-convidado.php" method="post">
        <input type="hidden" name="acao" value="inserir_convidado">
        <div class="form-group">
          <label>Digite o nome do seu convidado</label>
          <input class="input-form" type="text" name="nome" class="form-control" required>
          <label>Ele irá beber?</label>          
          <div class="form-check">
            <input class="form-check-input" type="radio" name="bebeConvidado" id="exampleRadios1" value="sim" checked>
            <label class="form-check-label" for="exampleRadios1"> Sim </label>
            <input class="form-check-input" type="radio" name="bebeConvidado" id="exampleRadios2" value="nao">
            <label class="form-check-label" for="exampleRadios2"> Não </label>
          </div>
          <div class="form-group">            
            <input type="submit" name="submit" class="btn-pequeno" value="Enviar">
          </div>
      </form>
      </div>
      <div class="convidados">
      <?php
        if($row > 0){
          echo "<h1>ATUALIZAR</h1>
          <label>Dados dos seus convidados:</label>";
        }
        ?>
      <form action="funcoes/update-convidado.php" method="post" class="contact-form">
        <input type="hidden" name="acao" value="editar_convidado">
        <?php foreach($convidado as $convidado_item){ ?>
        <input type="hidden" name="id[]" id="id<?php echo $convidado_item['id']; ?>" value="<?php echo $convidado_item['id']; ?>">
        <div class="form-group">
          <span class="icon-delete"><img src="img/icon-delete.png" width="12" height="12" alt="Excluir" onClick="aviso_deletar_convidado('<?php echo $convidado_item['id']; ?>');" /></span>
          <label for="nome">Nome:</label>
          <input class="input-form" type="text" required name="nome<?php echo $convidado_item['id']; ?>" value="<?php echo $convidado_item['nome']; ?>">
          <label for="bebeConvidado">Ele irá beber?</label>
          <div class="drop">
            <select name="bebeConvidado<?php echo $convidado_item['id']; ?>" class="input-form">
              <option value="" disabled>Selecione...</option>
              <option value="sim" <?php if($convidado_item['bebeConvidado'] == 'sim'){echo 'selected';}?>>Sim</option>
              <option value="nao" <?php if($convidado_item['bebeConvidado'] == 'nao'){echo 'selected';}?>>Nao</option>
            </select>
          </div>
          <?php } ?>
          <?php
            if($row > 0){
              echo "
              <input type='submit' name='submit' class='btn-pequeno' value='Enviar'>
            </div> ";
            }
            ?>
      </form>
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
      			location.href="funcoes/delete-convidado.php?acao=deletar_convidado&id="+id_item;
      		});
      };
    </script>
  </body>
</html>