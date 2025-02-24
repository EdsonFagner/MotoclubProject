<?php
include 'conection.php';

//Consulta no banco de dados
$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

//Consulta no banco de dados
$codeConsultaAll2 = "SELECT * FROM acess_login";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

//Consulta no banco de dados
$codeConsultaAll3 = "SELECT * FROM monthly_fee";
$consultaAll3 = $mysqli->query($codeConsultaAll3) or die ($mysqli->error);
$consultAllResult3 = $consultaAll3->fetch_all();

//Consulta no banco de dados
$codeConsultaAll4 = "SELECT * FROM register";
$consultaAll4 = $mysqli->query($codeConsultaAll4) or die ($mysqli->error);
$consultAllResult4 = $consultaAll4->fetch_all();

//Função de alerta
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

//Função para atualizar senha
function updatePassword($arrayLength2, $arrayLength4, $code, $password2, $criptUser, $mysqli) {

    //Criptografia de senha e armazenamento em variável
    $criptPassword = password_hash($password2, PASSWORD_DEFAULT);

    //Atualização de senha no banco de dados no registro de usuário
    for($x = 0; $x < count($arrayLength4); $x++){
        if($code == $arrayLength4[$x][4]){
            $codeThirdUpdate = "UPDATE register SET password = '$criptPassword' WHERE code = '$code'";
            $mysqli->query($codeThirdUpdate) or die ($mysqli->error);
        }   
    }

    //Atualização de senha no banco de dados no registro de login
    for($x = 0; $x < count($arrayLength2); $x++){
        if($criptUser == $arrayLength2[$x][1]){
            $codeFourthUpdate = "UPDATE acess_login SET password = '$criptPassword' WHERE user = '$criptUser'";
            $mysqli->query($codeFourthUpdate) or die ($mysqli->error);
        }   
    }

    alert('SENHA ATUALIZADA COM SUCESSO!');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>"; 

}

//Verificar se o botão de atualização de senha foi clicado para atualizar senha
if(isset($_POST['buttonUpdatePassword'])){

    //Captura de dados do formulário
    $code = htmlspecialchars($_POST['code']);
    $password2 = htmlspecialchars($_POST['password2']);
    $countInvalid = 0;

    //Contador para verificar se o código é válido
    for($x = 0; $x < count($consultAllResult); $x++){
        if($code == $consultAllResult[$x][2]){

            $criptUser = $consultAllResult2[$x][1];
            
            //Chamada da função de atualização de senha
            updatePassword($consultAllResult2, $consultAllResult4, $code, $password2, $criptUser, $mysqli);
        }else{
            $countInvalid += 1;
        }
    }
    if ($countInvalid == count($consultAllResult)){
        alert('CÓDIGO INVÁLIDO.');
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-forgot_password.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="section-title d-flex justify-content-center">
            <h1>Atualizar Senha</h1>
        </div>
        <form id="formUpdate" action="" method="post">
            <label class="lb-code d-flex justify-content-center" for="code">
                <input class="code" type="text" name="code" placeholder="CÓDIGO DO CONVITE" autocomplete="off" required><br>
            </label>
            <label class="lb-password2 d-flex justify-content-center" for="password2">
                <input class="password2" type="password" name="password2" placeholder="NOVA SENHA" autocomplete="off" required><br>
            </label>
            <div class="buttonAlign">
                <input class="btn-updatePassword btn btn-outline-danger" name="buttonUpdatePassword" type="submit" value="Recuperar Senha" for="formUpdate">
            </div> 
        </form>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>