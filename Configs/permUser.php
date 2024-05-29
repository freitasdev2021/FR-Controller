<?php
require"class_Processamento.php";

$permUser = $usuarios->conferirUpdate($_SESSION['idUser']);

echo $permUser['STUpdate'];