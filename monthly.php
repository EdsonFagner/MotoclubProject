<?php
session_start();
include 'conection.php';

$codeConsultaAll = "SELECT * FROM monthly_fee";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

$codeConsultaAll2 = "SELECT * FROM acess_login";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

$login = $_SESSION['login'];

if($_SESSION['login'] == password_verify($login, $consultAllResult2[0][1])){
    echo "<script type='module'>document.querySelector('.buttonPanel').style.display = 'flex';</script>";
    echo "<script type='module'>document.querySelector('.buttonCodeList').style.display = 'flex';</script>";
}

if(empty($_SESSION['login'])){
    alert('Usuário não autenticado');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
    exit(); 
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}



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


            echo "
                <tr>
                    <th>$nameArray</th>
                    $stat $paymentArray $stat2
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