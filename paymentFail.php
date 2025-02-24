<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-paymentFail.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="section-title d-flex justify-content-center">
            <h1>Pagamento Falhou</h1>
        </div>
        <div class="section-body d-flex flex-column align-items-center">
            <img src="assets/images/fail.png" alt="">
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