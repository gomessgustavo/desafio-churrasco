<?php
require_once "conexao.php";
function consulta_convidado($conn, $emailConvidado){
  $query_consulta = "SELECT * FROM convidado where email='".$emailConvidado."'";
  $consulta = mysqli_query($conn, $query_consulta) or die(mysqli_error());  
    $lista = array();
    while($row_consulta = mysqli_fetch_assoc($consulta)){
        $lista[] = $row_consulta;
    }
  return $lista;
  }
  
  function listar_participantes($conn){
	  $query = "SELECT nome FROM funcionario where presenca='sim'";	  
	  $queryRes = mysqli_query($conn, $query) or die(mysqli_error()); 	  
    $lista = array();
    while($row_consulta = mysqli_fetch_assoc($queryRes)){
      $lista[] = $row_consulta;
  }  
return $lista;

}
function listar_convidados($conn){
	  $query = "SELECT nome FROM convidado";	  
	  $queryRes = mysqli_query($conn, $query) or die(mysqli_error()); 	  
    $lista = array();
    while($row_consulta = mysqli_fetch_assoc($queryRes)){
      $lista[] = $row_consulta;
  }  
return $lista;

}	  

?>