<?php
require_once("../conexao.php");
if((isset($_POST['acao'])) && ($_POST['acao'] == 'editar_convidado')){
  $n_form = count($_POST['id']);
  $i = '';

	for($i=0; $i<$n_form; $i++){
	
		$id_item	= $_POST['id'][$i];
		$nome		= $_POST['nome'.$id_item.''];
		$bebe		= $_POST['bebeConvidado'.$id_item.''];
		
		$updateSQL = "UPDATE convidado SET nome='".$nome."', bebeConvidado='".$bebe."' WHERE id='".$id_item."'";
		$Result1 = mysqli_query($conn, $updateSQL) or die(mysqli_error());

	}	
	header("Location: ../crud-convidado.php?acao=sucesso");
}
?>