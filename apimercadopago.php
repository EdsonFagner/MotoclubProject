<?php
    include 'conection.php';
    require_once 'vendor/autoload.php';
    session_start();

    if(empty($_SESSION['login'])){
        alert('Usuário não autenticado');
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";  
        exit(); 
    }

    
    //Importando classes do MercadoPago
    use MercadoPago\MercadoPagoConfig;
    use MercadoPago\Client\Preference\PreferenceClient;
    
    //Configuração do MercadoPago para ambiente local de teste
    MercadoPagoConfig::setAccessToken('YOUR-TOKEN');
    MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

    //Variável para definir caracters permitidos na geração do código de pagamento
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //Função para gerar o código de pagamento
    function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    //Variável para armazenar o código de pagamento gerado
    $paymentCode = generate_string($permitted_chars, 10);

    //Inserindo variável de pagamento no banco de dados
    $codeFirstInclude = "INSERT INTO code_payment (codePayment) VALUES ('$paymentCode')";
    $mysqli->query($codeFirstInclude) or die ($mysqli->error);

    //Transformando variável de pagamento em URL
    $paymentURL = '?payment_code='.$paymentCode;


    //Criando objeto de pagamento
    $client = new PreferenceClient();

    //Criando preferência de pagamento
    $preference = $client->create([
        'items' => [
            [
                'title' => 'Mensalidade MotoClube',
                'description' => 'Mensalidade MotoClube',
                'quantity' => 1,
                'unit_price' => 60.00,
                'currency_id' => 'BRL',
            ]
        ],
        'payer' => [
            'name' => 'Name User',
            'surname' => 'Surname User',
            'email' => 'E-mail User',
        ],
        'marketplace_fee' => 0.00,
        'back_urls' => [
            'success' => 'YOUR-BACK-SUCCESS-URL'.$paymentURL,
            'failure' => 'YOUR-FAIL-URL',
            'pending' => 'YOUR-PENDING-URL',
        ],
        "auto_return" => "all",
        "external_reference" => "1643827245",
        "operation_type" => "regular_payment",
        "marketplace" => "none",
    ]);

    $response = json_encode($preference);

    $responseObj = json_decode($response);

    $sandBoxPoint = $responseObj->sandbox_init_point;

    //Redirecionando para a página de pagamento de teste do MercadoPago
    echo "<script type='text/javascript'>document.location='$sandBoxPoint'</script>";

?>
