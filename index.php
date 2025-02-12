<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'head.php'; ?>
    <link rel="stylesheet" href="./assets/css/style-index.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <div class="container-fluid">
            <section class="banner">
                <div class="sliders" style="margin-left: 0vw;">
                    <div class="slide">
                        <div class="slidearea">
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!--Modal Login-->
            <div class="modal" tabindex="-1" id="modalPost">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title ">Sistema de Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="login_press.php" method="post" name="formLogin">
                        <div class="modal-body d-flex justify-content-center flex-column">
                            <label class="lb-login d-flex justify-content-center" for="login">
                                <input class="login" type="text" name="user" placeholder="USUÁRIO" required><br>
                            </label>
                            <label class="lb-password d-flex justify-content-center" for="password">
                                <input class="password" type="password" name="password" placeholder="SENHA" required>
                            </label>
                            <br>
                            <div class="buttonAlign">
                                <input class="btn-login btn btn-outline-danger " type="submit" value="Login" for="formLogin">
                            </div>
                            <br><br>
                            <div class="forgetPassword">
                                <a href="#">Esqueceu a senha?</a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

    </main>
    <footer>
        <?php require 'footer.php'; ?>
    </footer>
</body>
</html>