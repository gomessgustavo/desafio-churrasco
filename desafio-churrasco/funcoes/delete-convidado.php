<?php
require_once("../conexao.php");
if((isset($_GET['acao'])) && ($_GET['acao'] == 'deletar_convidado')){

	$id_item   = $_GET['id'];

	$deleteSQL = "DELETE FROM convidado WHERE id='".$id_item."'";
	$Result1 = mysqli_query($conn, $deleteSQL) or die(mysqli_error());			
	
	header("Location:../crud-convidado.php?&acao=deletado");
}
?>