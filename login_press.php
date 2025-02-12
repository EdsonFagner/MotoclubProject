<?php
session_start();
include 'conection.php';


function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function console_log($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$codeConsultaAll = "SELECT * FROM acesso";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();


if(!empty($_POST['user']) && !empty($_POST['password'])){   
    $user = htmlspecialchars($_POST['user']);
    $password = htmlspecialchars($_POST['password']);
    if($user == $consultAllResult[0][1] && $password == $consultAllResult[0][2]){
        $_SESSION['user'] = $user;
        echo "<script type='text/javascript'> document.location = 'panel.php'; </script>";
    } else {
        alert('Usuário ou senha incorreta.');
        echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
    }
}