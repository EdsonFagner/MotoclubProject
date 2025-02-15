<?php
include 'conection.php';

$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

$codeConsultaAll2 = "SELECT * FROM acess_login";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

$codeConsultaAll3 = "SELECT * FROM monthly_fee";
$consultaAll3 = $mysqli->query($codeConsultaAll3) or die ($mysqli->error);
$consultAllResult3 = $consultaAll3->fetch_all();

$codeConsultaAll4 = "SELECT * FROM register";
$consultaAll4 = $mysqli->query($codeConsultaAll4) or die ($mysqli->error);
$consultAllResult4 = $consultaAll4->fetch_all();

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function updatePassword($arrayLength2, $arrayLength4, $code, $password2, $criptUser, $mysqli) {

    $criptPassword = password_hash($password2, PASSWORD_DEFAULT);

    for($x = 0; $x < count($arrayLength4); $x++){
        if($code == $arrayLength4[$x][4]){
            $codeThirdUpdate = "UPDATE register SET password = '$criptPassword' WHERE code = '$code'";
            $mysqli->query($codeThirdUpdate) or die ($mysqli->error);
        }   
    }

    for($x = 0; $x < count($arrayLength2); $x++){
        if($criptUser == $arrayLength2[$x][1]){
            $codeFourthUpdate = "UPDATE acess_login SET password = '$criptPassword' WHERE user = '$criptUser'";
            $mysqli->query($codeFourthUpdate) or die ($mysqli->error);
        }   
    }

    alert('SENHA ATUALIZADA COM SUCESSO!');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>"; 

}

if(isset($_POST['buttonUpdatePassword'])){

    $code = htmlspecialchars($_POST['code']);
    $password2 = htmlspecialchars($_POST['password2']);
    $countInvalid = 0;

    for($x = 0; $x < count($consultAllResult); $x++){
        if($code == $consultAllResult[$x][2]){

            $criptUser = $consultAllResult2[$x][1];

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