<?php
session_start();
include 'conection.php';

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';


$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

if(empty($_SESSION['login'])){
    alert('Usuário não autenticado');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
    exit(); 
}

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

generate_string($permitted_chars, 20);

if(isset($_POST['buttonGenerate'])){
    $codeGen = generate_string($permitted_chars, 5);
    $codeGen = strtoupper($codeGen);
    $nameCode = htmlspecialchars($_POST['nameCode']);
    $countInvalidCode = null;

    if(!empty($codeGen)){
        for($x=0; $x < count($consultAllResult); $x++){
            if($codeGen == $consultAllResult[$x][2]){
                alert('FALHA, O CÓDIGO GERADO É IGUAL HÁ UM JÁ CADASTRADO.');
                break;
            }else{
                $countInvalidCode += 1;
            }
        }
        if($countInvalidCode == count($consultAllResult)){
            $codeFirstInclude = "INSERT INTO code_table (name, code) VALUES ('$nameCode', '$codeGen')";
            $mysqli->query($codeFirstInclude) or die ($mysqli->error);
            $codeSecondConsult = "SELECT * FROM code_table WHERE code = '$codeGen'";
            $secondConsult = $mysqli->query($codeSecondConsult) or die ($mysqli->error);
            if(!empty($secondConsult)){
                alert('INSERÇÃO SUCEDIDA!');
                echo "<script type='text/javascript'> document.location = 'monthly.php'; </script>";
            }
        }else{
            alert('INSERÇÃO NÃO SUCEDIDA');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-panel.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="logout d-flex justify-content-end">
            <a href='codeList.php' class="btn btn-danger">Lista de Códigos</a>
            <a href='monthly.php' class="btn btn-danger">Lista de Mensalidades</a>
            <a href='logout.php' class="btn btn-outline-danger" id="buttonLogout">Logout</a> 
        </div>
        <div class="section-title d-flex justify-content-center">
            <h1>Painel de Controle</h1>
        </div>
        <br>
        <br>
        <br>
        <section class="section-body">
            <form id="codeForm" action="" method="post">
                <span class="inputTextSpan d-flex justify-content-center">
                    <input class="inputName" name="nameCode" type="text" placeholder="nome da pessoa" required autocomplete="off">
                </span>
                <br><br>
                <div class="alignButton">
                    <button type="submit" name="buttonGenerate"  class="btn btn-outline-danger" for="form">Gerar Código</button>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>