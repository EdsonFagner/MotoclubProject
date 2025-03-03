<?php 
include 'conection.php';

//Consulta no banco de dados
$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

//Consulta no banco de dados
$codeConsultaAll2 = "SELECT * FROM register";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

//Função de alerta
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

//Verificar se o botão de cadastro foi clicado para inserir dados no banco de dados
if(isset($_POST['buttonRegister'])){

    //Captura de dados do formulário e criptografia de senha
    $password = htmlspecialchars($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $code = htmlspecialchars($_POST['code']);
    $email = htmlspecialchars($_POST['email']);

    //Contador para verificar se o código é válido
    $countInvalid = null;


    for($x=0; $x < count($consultAllResult); $x++){
        for($x=0; $x < count($consultAllResult2); $x++){
            //Verificação de código já utilizado e redirecionamento caso seja verdadeiro
            if($code == $consultAllResult2[$x][4]){
                alert('CÓDIGO JÁ UTILIZADO.');
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
                break;
            }
        }
        //Verificação de código válido para inclusão de dados no banco de dados
        if($code == $consultAllResult[$x][2]){

            $user = $consultAllResult[$x][1];
            $user = password_hash($user, PASSWORD_DEFAULT);

            $codeFirstInclude = "INSERT INTO register (user, password, email, code) VALUES ('$user', '$password', '$email', '$code')";
            $mysqli->query($codeFirstInclude) or die ($mysqli->error);

            $codeSecondInclude = "INSERT INTO acess_login (user, password) VALUES ('$user', '$password')";
            $mysqli->query($codeSecondInclude) or die ($mysqli->error);

            $codeSecondConsult = "SELECT * FROM register WHERE code = '$code'";
            $secondConsult = $mysqli->query($codeSecondConsult) or die ($mysqli->error);

            if(!empty($secondConsult)){
                alert('INSERÇÃO SUCEDIDA!');
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            }
        }else{
            $countInvalid += 1;
        }
    }
    //Verificação de código inválido
    if($countInvalidCode == count($consultAllResult)){
        alert('CÓDIGO INVÁLIDO');
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-register.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="container-fluid">
            <div class="section-title d-flex justify-content-center">
                <h1>Cadastro</h1>
            </div>
            <form id="formRegister" action="" method="post">
                <label class="lb-code d-flex justify-content-center" for="code">
                    <input class="code" type="text" name="code" placeholder="CÓDIGO DO CONVITE" autocomplete="off" required><br>
                </label>
                <label class="lb-password d-flex justify-content-center" for="password">
                    <input class="password" type="password" name="password" placeholder="SENHA" autocomplete="off !important" required><br>
                </label>
                <label class="lb-email d-flex justify-content-center" for="email">
                    <input class="email" type="email" name="email" placeholder="E-MAIL" autocomplete="off !important" required><br>
                </label>
                <div class="buttonAlign">
                    <input class="btn-register btn btn-outline-danger" name="buttonRegister" type="submit" value="Cadastrar" for="formRegister">
                </div> 
            </form>
        </div>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>