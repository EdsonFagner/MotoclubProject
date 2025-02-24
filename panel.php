<?php
session_start();
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

//Variável de caracteres permitidos para gerar código
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

$login = $_SESSION['login'];

//Função de alerta
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

//Verificação de autenticação para redirecionamento caso não esteja autenticado
if($_SESSION['login'] != password_verify($login, $consultAllResult2[0][1])){
    alert('Usuário sem permissão');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
    exit(); 
}

//Função para criar códigos
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

//Verificar se o botão de gerar código foi clicado para gerar código
if(isset($_POST['buttonGenerate'])){
    //Variável para armazenar código gerado
    $codeGen = generate_string($permitted_chars, 5);
    //Conversão de código gerado para maiúsculo
    $codeGen = strtoupper($codeGen);
    //Captura de nome do formulário com tratamento de caracteres especiais
    $nameCode = htmlspecialchars($_POST['nameCode']);
    $countInvalidCode = null;

    //Verificar se o código gearado é diferente de vazio
    if(!empty($codeGen)){
        for($x=0; $x < count($consultAllResult); $x++){
            //Verificação de código já utilizado
            if($codeGen == $consultAllResult[$x][2]){
                alert('FALHA, O CÓDIGO GERADO É IGUAL HÁ UM JÁ CADASTRADO.');
                break;
            }else{
                $countInvalidCode += 1;
            }
        }
        //Verificação de código válido para inclusão de dados no banco de dados
        if($countInvalidCode == count($consultAllResult)){
            $codeFirstInclude = "INSERT INTO code_table (name, code) VALUES ('$nameCode', '$codeGen')";
            $mysqli->query($codeFirstInclude) or die ($mysqli->error);
            $codeSecondInclude = "INSERT INTO monthly_fee (userName) VALUES ('$nameCode')";
            $mysqli->query($codeSecondInclude) or die ($mysqli->error);
            $codeSecondConsult = "SELECT * FROM code_table WHERE code = '$codeGen'";
            $secondConsult = $mysqli->query($codeSecondConsult) or die ($mysqli->error);
            //Verificação de inclusão de dados no banco de dados
            if(!empty($secondConsult)){
                alert('INSERÇÃO SUCEDIDA!');
                echo "<script type='text/javascript'> document.location = 'codeList.php'; </script>";
            }
        }else{
            alert('INSERÇÃO NÃO SUCEDIDA');
        }
    }
}

//Verificar se o botão de exclusão foi clicado para excluir código
if(isset($_POST['buttonExclude'])){
    $codeExclude = htmlspecialchars($_POST['code']);
    $codeExclude = strtoupper($codeExclude);

    if(!empty($codeExclude)){
        $countInvalid = 0;
        for($x=0; $x < count($consultAllResult); $x++){
            if($codeExclude == $consultAllResult[$x][2]){

                $nameEx = $consultAllResult[$x][1];
                $codeEx = $consultAllResult[$x][2];

                $codeFirstExclude = "DELETE FROM code_table WHERE code = '$codeExclude'";
                $mysqli->query($codeFirstExclude) or die ($mysqli->error);

                for($x=0; $x < count($consultAllResult3); $x++){
                    if($nameEx == $consultAllResult3[$x][1]){
                        $codeSecondExclude = "DELETE FROM monthly_fee WHERE userName = '$nameEx'";
                        $mysqli->query($codeSecondExclude) or die ($mysqli->error);
                    }
                }

                for($x=0; $x < count($consultAllResult4); $x++){
                    if($codeEx == $consultAllResult4[$x][4]){

                        $loginEx = $consultAllResult4[$x][1];

                        $codeThirdExclude = "DELETE FROM register WHERE code = '$codeEx'";
                        $mysqli->query($codeThirdExclude) or die ($mysqli->error);
                    }
                }

                for($x=0; $x < count($consultAllResult2); $x++){
                    if($loginEx == $consultAllResult2[$x][1]){
                        $codeSecondExclude = "DELETE FROM acess_login WHERE user = '$loginEx'";
                        $mysqli->query($codeSecondExclude) or die ($mysqli->error);
                    }
                }


                alert('EXCLUSÃO REALIZADA COM SUCESSO.');
                echo "<script type='text/javascript'> document.location = 'codeList.php'; </script>";
            }else{
                $countInvalid +=1;
            }
        }
        if($countInvalid >= count($consultAllResult)){
            alert('CÓDIGO INVALIDO');
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
        <section class="section-body d-flex align-items-center flex-column">
            <form id="codeForm" action="" method="post">
                <span class="spanText d-flex justify-content-center">
                    <h5>Gerador de Códigos</h5>
                </span>
                <span class="inputTextSpan d-flex justify-content-center">
                    <input class="inputName" name="nameCode" type="text" placeholder="nome da pessoa" required autocomplete="off">
                </span>
                <br><br>
                <div class="alignButton">
                    <button type="submit" name="buttonGenerate"  class="btn btn-outline-success" for="form">Gerar Código</button>
                </div>
            </form>

            <form id="codeForm2" action="" method="post">
                <span class="spanText2 d-flex justify-content-center">
                    <h5>Exclusão de Códigos</h5>
                </span>
                <span class="inputTextSpan d-flex justify-content-center">
                    <input class="inputName2" name="code" type="text" placeholder="código" required autocomplete="off">
                </span>
                <br><br>
                <div class="alignButton">
                    <button type="submit" name="buttonExclude"  class="btn btn-outline-danger" for="form">Excluir Código</button>
                </div>
            </form>

        </section>
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>