<?php
session_start();
include 'conection.php';

if(empty($_SESSION['login'])){
    alert('Usuário não autenticado');
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
    exit(); 
}

$codeConsultaAll = "SELECT * FROM code_table";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

    function tableCreate($arrayLength){
        
        for($x = 0; $x < count($arrayLength); $x++){

            $nameArray = $arrayLength[$x][1];
            $codeArray = $arrayLength[$x][2];
            $totalMembers = count($arrayLength);

            echo "
                <tr>
                    <th>$nameArray</th>
                    <th id='codeArray$x'>$codeArray</th>
                    <th>
                        <div class='d-flex justify-content-center'>
                            <a class='btn btn-outline-success buttonCopy$x'>Copiar</a>
                            <a class='btn btn-danger buttonExclude'>Excluir</a>
                        </div>
                    </th>
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
    <link rel="stylesheet" href="./assets/css/style-monthly.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="logout d-flex justify-content-end">
            <a href='panel.php' class="btn btn-danger">Painel de Controle</a>
            <a href='monthly.php' class="btn btn-danger">Lista de Mensalidades</a>
            <a href='logout.php' class="btn btn-outline-danger" id="buttonLogout">Logout</a> 
        </div>
        <div class="section-title d-flex justify-content-center">
            <h1>Painel de Controle</h1>
        </div>

        <div class="section-body">
                <br>
                <br>
                <table id="table-01" class="d-flex justify-content-center">
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>CÓDIGO</th>
                            <th>AÇÕES</th>
                        </tr>
                        <?= tableCreate($consultAllResult); ?>
                    </thead>    
                </table>
            </div>
        
    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
    <script src="assets/scripts/monthly.js"></script>
</body>
</html>