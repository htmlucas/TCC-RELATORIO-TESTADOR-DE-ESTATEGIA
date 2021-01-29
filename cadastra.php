 <?php

    require_once 'conexao.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$mydb", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     $stmt = $conn->prepare("INSERT INTO usuario (name,password) VALUES (:name,:password)");
    $stmt->bindParam(':name',$_POST['name']);
    $stmt->bindParam(':password',$_POST['password']);
        $stmt->execute();
        header('Location:login.php');
    }
catch(PDOException $e)
    {
        echo "OPS..ERRO NO SERVIDOR ".$e->getMessage();
    }

?>