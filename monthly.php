<?php
session_start();
include 'conection.php';

//Consulta no banco de dados
$codeConsultaAll = "SELECT * FROM monthly_fee";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

//Consulta no banco de dados
$codeConsultaAll2 = "SELECT * FROM acess_login";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

$login = $_SESSION['login'];

//Verificação de autenticação para exibição de botões
if($_SESSION['login'] == password_verify($login, $consultAllResult2[0][1])){
    echo "<script type='module'>document.querySelector('.buttonPanel').style.display = 'flex';</script>";
    echo "<script type='module'>document.querySelector('.buttonCodeList').style.display = 'flex';</script>";
}

//Verificação de autenticação para redirecionamento caso não esteja autenticado
if(empty($_SESSION['login'])){
    alert('Usuário não autenticado');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
    exit(); 
}

//Função de alerta
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

//Verificação de pagamento através de sessão e mudança de status no banco de dados
if(isset($_SESSION['payed']) == 'Pago'){
    for($x = 0; $x < count($consultAllResult); $x++){
        if($_SESSION['login'] == $consultAllResult[$x][1]){
            $userNameCheck = $consultAllResult[$x][1];
            $codeFirstUpdate = "UPDATE monthly_fee SET monthly_fee = 'Pago' WHERE userName = '$userNameCheck'";
            $mysqli->query($codeFirstUpdate) or die ($mysqli->error);
            echo "<script type='module'>window.location.reload(true);</script>";
            unset($_SESSION['payed']);
            break;
        }
    }
}


//Verificação de autenticação para exibição de botões
if(isset($_SESSION['login'])){
    for($x = 0; $x < count($consultAllResult); $x++){
        if($_SESSION['login'] == $consultAllResult[$x][1]){
            echo "<script type='module'>document.querySelector('.buttonPay$x').style.display = 'flex';</script>";
        }
    }
}

//Verificação de autenticação para ocultar botões
if(isset($_SESSION['login'])){
    for($x = 0; $x < count($consultAllResult); $x++){
        if($consultAllResult[$x][2] == 'Pago'){
            echo "<script type='module'>document.querySelector('.buttonPay$x').style.display = 'none';</script>";
        }
    }
}

    //Função para criar tabela de mensalidades
    function tableCreate($arrayLength){
        
        for($x = 0; $x < count($arrayLength); $x++){
            $nameArray = $arrayLength[$x][1];
            $paymentArray = $arrayLength[$x][2];


            if($arrayLength[$x][2] == 'Pendente'){
                $stat = '<th style="color: yellow">';
                $stat2 = '</th>';
            }else{
                $stat = '<th style="color: green">';
                $stat2 = '</th>';
            }

            $classButton = 'buttonPay'.$x;


            echo "
                <tr>
                    <th>$nameArray</th>
                    $stat $paymentArray $stat2
                    <th>
                        <div class='alignButton'>
                            <a class='btn btn-outline-success $classButton btn-table' name='buttonPay' href='apimercadopago.php'>Pagar</a>
                        </div>
                    </th>
                </tr>
            ";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-monthly.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="logout d-flex justify-content-end">
            <a href='panel.php' class="btn btn-danger buttonPanel" style="display: none;">Painel de Controle</a>
            <a href='codeList.php' class="btn btn-danger buttonCodeList" style="display: none;">Lista de Códigos</a>
            <a href='logout.php' class="btn btn-outline-danger" id="buttonLogout">Logout</a> 
        </div>
        <div class="section-title d-flex justify-content-center">
            <h1>Mensalidades</h1>
        </div>

        <div class="section-body">
                <br>
                <br>
                <table id="table-01" class="d-flex justify-content-center">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>STATUS</th>
                            <th>OPÇÕES</th>
                        </tr>
                        <?= tableCreate($consultAllResult); ?>
                    </thead>    
                </table>
            </div>
    </main>
    <footer class="float-end">
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>
