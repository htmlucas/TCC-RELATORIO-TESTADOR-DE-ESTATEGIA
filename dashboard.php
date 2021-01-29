<?php
//Inicia Sessão
	session_start();
    //Verifica Sessão
    if(!isset($_SESSION['nome'])){
        //Se não estiver logado, volta para o índice
        header('Location: login.php');
        exit;
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
   <h1>Bem vindo <?php echo $_SESSION['nome']; ?> </h1>
   <h1>Envie um relatório (Aceitamos apenas HTML) </h1>
   <br>
   <form action="lerhtml.php" method="post" enctype="multipart/form-data">
      Selecione o arquivo: <input type="file" name="arquivo" />
      <input type="submit" value="Enviar"/>
    </form>
    
</body>
</html>