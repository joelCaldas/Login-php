<?php
include('conexao.php');

if(isset($_POST['email']) && isset($_POST['senha'])) {
    if(strlen($_POST['email']) == 0) {
      echo "Preencha seu email";
    } else if(strlen($_POST['senha']) == 0){
      echo "preencha sua senha";
    } else {
      
      $email = $mysqli->real_escape_string($_POST['email']);
      $password = $mysqli->real_escape_string($_POST['senha']);

      $sql_code = "SELECT * FROM usuário WHERE email = '$email' AND senha = '$password'";
      $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL:" . $mysqli->error);

      $quantidade = $sql_query->num_rows;
      
      if($quantidade == 1){

        $usuario = $sql_query->fetch_assoc();

        if(!isset($_SESSION)) {
          session_start();
        }

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['fName'] = $usuario['fName'];

          header("Location: wiki.php");

      } else {
        echo " Falha ao logar! email ou senhar incorreta";
      }

    }
  }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register</h1>
      <form method="post" action="register.php">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">Nome</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Sobre nome</label>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="senha" id="senha" placeholder="Password" required>
            <label for="senha">senha</label>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      <p class="or">
        ----------or--------
      </p>
      <div class="icons">
        <i class="fab fa-google"></i>
        <i class="fab fa-facebook"></i>
      </div>
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <div class="container" id="signIn">
        <h1 class="form-title">Entra</h1>
        <form method="post" action="register.php">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="senha" id="senha" placeholder="Password" required>
              <label for="senha">Senha</label>
          </div>
          <p class="recover">
            <a href="#">Novamente seu senha</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">
          ----------or--------
        </p>
        <div class="icons">
          <i class="fab fa-google"></i>
          <i class="fab fa-facebook"></i>
        </div>
        <div class="links">
          <p>Ainda não tem conta -></p>
          <button id="signUpButton">Cadastra-se</button>
        </div>
      </div>
      <script src="script.js"></script>
</body>
</html>
