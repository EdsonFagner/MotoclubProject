<?php
session_start();
include 'conection.php';

//Função de alerta
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

//Consulta no banco de dados
$codeConsultaAll = "SELECT * FROM acess_login";
$consultaAll = $mysqli->query($codeConsultaAll) or die ($mysqli->error);
$consultAllResult = $consultaAll->fetch_all();

//Verificar e se o login e a senha estão diferentes de vazio
if(!empty($_POST['login']) && !empty($_POST['password'])){ 

    //Captura de dados do formulário com tratamento de caracteres especiais
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $countIncorrectLogin = null;

    //Verificação de autenticação
    for ($x = 0; $x < count($consultAllResult); $x++){
        //Verificação de autenticação de administrador para redirecionamento para o painel
        if($login == password_verify($login, $consultAllResult[0][1]) && $password == password_verify($password, $consultAllResult[0][2])){
            $_SESSION['login'] = $login;
            echo "<script type='text/javascript'> document.location = 'panel.php'; </script>";
            break;
        }
        //Verificação de autenticação de usuário comum e redirecionamento para a página de mensalidade
        elseif($login == password_verify($login, $consultAllResult[$x][1]) && $password == password_verify($password, $consultAllResult[$x][2])){
            $_SESSION['login'] = $login;
            echo "<script type='text/javascript'> document.location = 'monthly.php'; </script>";
            break;
        }
        //Contador de login incorreto
        else{
            $countIncorrectLogin += 1;
        }
    }
    //Verificação de login incorreto
    if($countIncorrectLogin == count($consultAllResult)){
        alert('Usuário ou senha incorreta.');
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    }
}
