<?php
session_start();
include 'conection.php';

$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

$codeConsultaAll2 = "SELECT * FROM acess_login";
$consultaAll2 = $mysqli->query($codeConsultaAll2) or die ($mysqli->error);
$consultAllResult2 = $consultaAll2->fetch_all();

$login = $_SESSION['login'];

if($_SESSION['login'] != password_verify($login, $consultAllResult2[0][1])){
    alert('Usuário sem permissão');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
    exit(); 
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}



    function tableCreate($arrayLength){
        
        for($x = 0; $x < count($arrayLength); $x++){

            $nameArray = $arrayLength[$x][1];
            $codeArray = $arrayLength[$x][2];
            $totalMembers = count($arrayLength);

            echo "
                <tr>
                    <th>$nameArray</th>
                    <th>$codeArray</th>
                </tr>
            ";
        }

        echo "
            <tr>
                <th style='color: gold'>Total de Menbros: </th>
                <th style='color: gold'>$totalMembers</th>
            </tr>
        ";
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-codeList.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="divFunction"></div>
        <div class="logout d-flex justify-content-end">
            <a href='panel.php' class="btn btn-danger">Painel de Controle</a>
            <a href='monthly.php' class="btn btn-danger">Lista de Mensalidades</a>
            <a href='logout.php' class="btn btn-outline-danger" id="buttonLogout">Logout</a> 
        </div>
        <div class="section-title d-flex justify-content-center">
            <h1>Lista de Códigos</h1>
        </div>

        <div class="section-body">
                <br>
                <br>
                <table id="table-01" class="d-flex justify-content-center">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CÓDIGO</th>
                        </tr>
                        <?= tableCreate($consultAllResult); ?>
                    </thead>    
                </table>
            </div>
        
    </main>
    <footer class="float-end">
        <?php require 'footer.php'; ?>
    </footer>
    <script src="assets/scripts/codeList.js"></script>
</body>
</html>