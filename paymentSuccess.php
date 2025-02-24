<?php
include 'conection.php';
session_start();

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

//Consulta no banco de dados
$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

//Consulta no banco de dados
$codeConsultaAll2 = "SELECT * FROM code_payment";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

//Captura de dados de pagamento e verificação de autenticação para mudança de status no banco de dados e exclusão de código de pagamento
for ($x=0; $x < count($consultAllResult); $x++){
    if($_SESSION['login'] == $consultAllResult[$x][1]){
        for ($y=0; $y < count($consultAllResult2); $y++){
            if($_GET['payment_code'] != $consultAllResult2[$y][1] || $_GET['payment_code'] == null || empty($_GET['payment_code'])){
                $codeSecondExclude = "DELETE FROM code_payment WHERE codePayment = '$_GET[payment_code]'";
                alert('Pagamento não encontrado');
                echo "<script type='text/javascript'> document.location = 'paymentFail.php'; </script>";
                break;
            }elseif($_GET['payment_code'] == $consultAllResult2[$y][1] && $_GET['status'] == 'approved'){
                $_SESSION['payed'] = 'Pago';
                $codeSecondExclude = "DELETE FROM code_payment WHERE codePayment = '$_GET[payment_code]'"; 
                $mysqli->query($codeSecondExclude) or die ($mysqli->error);
                break;
            }
        }
        break;    
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-paymentSuccess.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="section-title d-flex justify-content-center">
            <h1>Pagamento Aprovado</h1>
        </div>
        <div class="section-body d-flex flex-column align-items-center">
            <img src="assets/images/payed.png" alt="">
            <h5>Você será redirecionado para a página mensalidades em segundos!</h5>
        </div>
        <br><br>
        <div class="alignCount d-flex justify-content-center">
            <h1 class="contador"></h1>
        </div>

    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script type="text/javascript" src="assets/scripts/paymentSuccess.js"></script>
</body>
</html>

<?php

