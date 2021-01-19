<?php
session_start(); 


require_once "../conexao.php";
$nome = trim($_POST['nome']);
$bebe = trim($_POST['bebeConvidado']);
$emailConvidado = $_SESSION['username'];

    if((isset($_POST['acao'])) && ($_POST['acao'] == 'inserir_convidado')){  
      if($_SERVER["REQUEST_METHOD"]=="POST"&& isset($_POST['submit'])){
        $sqli = $conn->prepare("SELECT * FROM convidado where email=?");
      $sqli-> bind_param('s', $emailConvidado);
      $sqli -> execute();   
      $sqli -> store_result();  
  if($sqli-> num_rows < 1){  
    $sql = "INSERT INTO convidado (nome, bebeConvidado, email) values ('".$nome."', '".$bebe."', '".$emailConvidado."')";
    $Result1 = mysqli_query($conn,$sql) or die(mysqli_error($conn));      
    header("location:../crud-convidado.php?acao=sucesso");
    
  }else{        
    header("location:../crud-convidado.php?acao=erro");
  }       
 
      }
      
  
}

?>