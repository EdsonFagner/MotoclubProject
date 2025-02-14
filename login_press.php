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

$codeConsultaAll = "SELECT * FROM acess_login";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();


if(!empty($_POST['login']) && !empty($_POST['password'])){   
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $countIncorrectLogin = null;


    for ($x = 0; $x < count($consultAllResult); $x++){
        if($login == password_verify($login, $consultAllResult[0][1]) && $password == password_verify($password, $consultAllResult[0][2])){
            $_SESSION['login'] = $login;
            echo "<script type='text/javascript'> document.location = 'panel.php'; </script>";
            break;
        }elseif($login == password_verify($login, $consultAllResult[$x][1]) && $password == password_verify($password, $consultAllResult[$x][2])){
            $_SESSION['login'] = $login;
            echo "<script type='text/javascript'> document.location = 'monthly.php'; </script>";
            break;
        }else{
            $countIncorrectLogin += 1;
        }
    }
    if($countIncorrectLogin == count($consultAllResult)){
        alert('Usuário ou senha incorreta.');
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    }
}
