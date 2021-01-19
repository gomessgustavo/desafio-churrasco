<?php
session_start();

require_once ("funcoes/consultas.php");

$calc = 0;
$calcComida=0;
$calcBebida=0;
require_once "conexao.php";
$query = "SELECT presenca, bebe FROM funcionario";
$query2 = "SELECT bebeConvidado FROM convidado";
$consulta = mysqli_query($conn, $query) or die(mysqli_error());  
$consulta2 = mysqli_query($conn, $query2) or die(mysqli_error());
$sql = $conn->prepare("SELECT * FROM funcionario");      
$sql -> execute();   
$sql -> store_result(); 
$sqli = $conn->prepare("SELECT * FROM convidado");      
$sqli -> execute();   
$sqli -> store_result();  
if($sql-> num_rows>0){
  while($row_consulta = mysqli_fetch_assoc($consulta)){
    $lista[] = $row_consulta;
  };
  
  foreach($lista as $consulta_item){
    if($consulta_item['presenca'] == "sim"){
      $calc += 10;
    $calcComida += 10;	
    if($consulta_item['bebe'] == "sim"){
      $calc += 10;
    $calcBebida +=10;	
    }
    }
  } 
}if($sqli-> num_rows > 0){
	while($row_consulta = mysqli_fetch_assoc($consulta2)){
    $lista2[] = $row_consulta;
  };
  foreach($lista2 as $consulta2_item){
    if($consulta2_item['bebeConvidado'] == "sim"){
      $calc += 40;
      $calcBebida += 20;
      $calcComida +=20;
    }else{
      $calc += 20;
     $calcComida +=20;
    }
  }
}

$listagem = listar_participantes($conn);
$listagemConv = listar_convidados($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Churrasco Hammer</title>
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
      <div class="informacoes-churrasco">
        <div class="texto-churrasco">
          <h1>Nós da Hammer, estamos realizando um churrasco e contamos com a sua presença! Para mais detalhes, clique abaixo.</h1>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
          <a class="btn-secundario" href="cadastro.php">Participar do churrasco</a>
        </div>
        <div class="sobre-churrasco">
          <?php echo "<h3>Arrecadação total: R$ $calc,00</h3>"; ?>
          <?php echo "<h3>Arrecadado de comida: R$ $calcComida,00</h3>"; ?>
          <?php echo "<h3>Arrecadado de bebida: R$ $calcBebida,00</h3>"; ?>
        </div>
      </div>

      <div class="btn-informacao"> 
        <a class="btn-primario" href="about.php">Saber mais</a>
      </div>
    </section>

    <section class="lista-participantes">   
      <div class="participantes">
        <h1>Lista de participantes</h1>
        <?php foreach($listagem as $item){ ?>
          <p><?php echo $item['nome'] ?></p>
        <?php } ?>
      </div>
      <div class="participantes">
        <h1>Lista de convidados</h1>
        <?php foreach($listagemConv as $item){ ?>
          <p><?php echo $item['nome'] ?></p>
        <?php } ?>
      </div>
    </section>   
  </body>
</html>
