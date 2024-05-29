<?php
require"configs.php";

if(isset($_POST["emailAcesso"]) && isset($_POST["senhaAcesso"])){
    echo Autenticacao::efetuarLogin($_POST["emailAcesso"],$_POST["senhaAcesso"]);
}else{
    echo Autenticacao::conferirAcesso($_SESSION['login']['dados']['id']);
}
//echo "aa";


