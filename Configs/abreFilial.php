<?php
require"configs.php";
if(isset($_SESSION['login'])){
    if(isset($_GET['filial']) && isset($_GET['open'])){
        if(is_string($_GET['filial'])){
            $filial = base64_decode($_GET['filial']);
            $idusuario = $_SESSION['login']['dados']['id'];
            mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET LOGFilial = $filial WHERE IDUsuario = $idusuario ");
            $_SESSION['login']['filial'] = $filial;
            header("location:../FRController/");
        }
    }else{
        echo "tentou invadir e se arrependeu";
    } 
}else{
    echo "Você não está autenticado! Faça login: <a href='https://www.frcontroller.com.br/FRController/login.html'>Login</a>";
}
