<?php
include 'conexao.php';

// Pegar dados do formulário
if(isset($_POST['signUp'])){
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['senha'];

    // Criptografar a senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserir no banco de dados
    $sql = "INSERT INTO usuário (fName, lName, email, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fName, $lName, $email, $hashed_password);

    if ($stmt->execute()==TRUE) {
        header("Location: index.php");
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

if(isset($_POST['signIn'])){
    $email=$_POST['email'];
    $password=$_POST['senha'];

    $sql="SELECT * FROM usuário WHERE email=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        if(password_verify($password, $row['senha'])){
            session_start();
            $_SESSION['email']=$row['email'];
            header("Location: wiki.php");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else{
        echo "Email não encontrado.";
    }
}

$conn->close();
?>
