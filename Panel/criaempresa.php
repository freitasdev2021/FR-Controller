<?php
require"../Configs/configs.php";
if($token->conferirLogin() == 0){
    header("location:login.html");
}else{
    if($token->conferirArea($_SESSION['login']['nivel']) == 3 ){
        $_SESSION['login']['empresa'] = Contratos::getEmpresa($_SESSION['login']['contrato']);
        if($_SESSION['login']['empresa'] > 0){
            header("location:index.php");
        }
    }elseif($token->conferirArea($_SESSION['login']['nivel']) == 3.5){
        header("location:../FRController/index.php");
    }else{
        header("location:../login.html");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR Tecnologia: Portal do cliente</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="../img/logo.png"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 bg-white p-5 rounded">
                <h3 align="center">Cadastre sua Empresa antes de Prosseguir!</h3>
                <hr>
                <form id="form_cria_empresa">
                <!-- Email input -->
                <input type="hidden" name="IDContrato" value="<?=$_SESSION['login']['contrato']?>">
                <div class="form-outline mb-4">
                    <input type="name" name="fantasia" class="form-control form-control-lg" placeholder="Nome fantasia" minlength="10" maxlength="100" />
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>

                <div class="form-outline mb-3">
                    <input type="name" name="razao" class="form-control form-control-lg" placeholder="Razão social" minlength="10" maxlength="100" />
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>

                <div class="form-outline mb-3 cpfCnpj">
                    <input type="text" name="cnpj" class="form-control form-control-lg" placeholder="CNPJ" minlength="18" />
                    <div class="error-input text-danger">
                        Preenchimento incorreto!
                    </div>
                </div>

                </form>
                <div class="text-center text-lg-start mt-4 pt-2">
                    <button class="btn btn-lg col-sm-12 btn-primary bt_criar_empresa">Criar</button>
                </div>
            </div>
            </div>
        </div>
    </section>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="../js/contratos.js"></script>
</body>
</html>
<?php
include "views/modais/modalAlert.php";
?>