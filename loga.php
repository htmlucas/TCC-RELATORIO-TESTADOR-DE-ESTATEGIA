<?php
//Inicia Sessão
   session_start();
//Chama as variaveis de conexão
    include_once 'conexao.php';

//Verifica se veio do formulario de login
	if(isset($_POST['name'])){
//Define variaveis para o login
        $nome =$_POST ['name']; 
        $senha=$_POST ['password'];
//Conecta com o banco
        $conn = new PDO("mysql:host=$servername;dbname=$mydb", $username, $password);
// Exibe erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $selectusuario = $conn->query("SELECT idusuario,name,password FROM usuario WHERE name='$nome' and password='$senha'");
        
        
        if (!$result = $selectusuario->fetchAll()){
            echo "Usuario ou senha inválidos";
            exit;
        }
        $login = $result[0];

       
        
		if($_POST ['name']  == $login['name'] && $_POST ['password'] == $login['password']){
            $_SESSION['id'] = $login['idusuario']; 
			$_SESSION['nome'] = $login['name'];
            $_SESSION['password'] = $login['password'];
         
			header("Location:dashboard.php");
            
		} else{
			echo 'Usuário ou senha inválidos';
		}
	} 
?>