<?php
require_once "../conexao.php";
if((isset($_POST['acao'])) && ($_POST['acao'] == 'update_presenca')){
  $id = $_SESSION['id'];
  $presenca = $_POST['presenca'];
  $sql = "UPDATE funcionario SET presenca='".$presenca."' where id='".$id."'";
  $Result1 = mysqli_query($conn, $sql) or die(mysqli_error());
  header("Location: ../welcome.php?acao=sucesso");
}

?>