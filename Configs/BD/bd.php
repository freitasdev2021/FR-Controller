<?php
class FRController{
    public static function conectarDatabase(){
        return mysqli_connect('localhost','root','','frcontroller');
    }
}

class FRGeral{
    //FUNÇÃO QUE TRATA VALORES MONETARIOS NO SISTEMA
    public static function trataValor($valor,$tratamento){
        switch($tratamento){
            case "0": //TRATA OS VALORES QUE VEM DO BANCO DE DADOS PARA IMPRIMIR NA TELA
                return number_format($valor,2,",",",");
            break;
            case "1": //TRATA OS VALORES QUE VEM DO SISTEMA PARA FAZER CALCULOS OU ENVIAR PARA O BANCO DE DADOS
                $envBanco = $valor; //VALOR
                $firstChar = strtok($envBanco,","); //NUMEROS ANTES DA PRIMEIRA VIRGULA
                $lastChar = strstr($envBanco,","); //NUMEROS DEPOIS DA VIRGULA
                $valorTratado = str_replace(",","",$firstChar.ltrim($lastChar,",")); //JUNTA OS DOIS E RETIRAM AS VIRGULAS JUNTO COM OS CENTAVOS
                $strlenValor = strlen($valorTratado) -2; //BUSCA OS DOIS ULTIMOS CARACTERES QUE SÃO OS CENTAVOS
                return substr_replace($valorTratado,".",$strlenValor,0); //COLOCA UM PONTO NOS DOIS ULTIMOS CARACTERES PARA BUSCAR OS CENTAVOS
            break;
        }
    }

    public static function trataEnvioVenda($valor){
        $envBanco = $valor; //VALOR
        $firstChar = strtok($envBanco,","); //NUMEROS ANTES DA PRIMEIRA VIRGULA
        $lastChar = strstr($envBanco,","); //NUMEROS DEPOIS DA VIRGULA
        $valorTratado = str_replace(",","",$firstChar.ltrim($lastChar,",")); //JUNTA OS DOIS E RETIRAM AS VIRGULAS JUNTO COM OS CENTAVOS
        $strlenValor = strlen($valorTratado); //BUSCA OS DOIS ULTIMOS CARACTERES QUE SÃO OS CENTAVOS
        return substr_replace($valorTratado,".",$strlenValor,0); //COLOCA UM PONTO NOS DOIS ULTIMOS CARACTERES PARA BUSCAR OS CENTAVOS
    }

    //FUNÇÃO DE MASCARA CPF E CNPJ PARA IMPRESSÃO NA TELA
    //$cpf = mask($details["cpf"], '###.###.###-##');
    //$cnpj = mask($details["cnpj"], '##.###.###/####-##');
    public static function cpfCnpj($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
    //MASCARA PARA TELEFONE
    public static function formataTelefone($numero){
        if(strlen($numero) == 10){
            $novo = substr_replace($numero, '(', 0, 0);
            $novo = substr_replace($novo, '9', 5, 0);
            $novo = substr_replace($novo, ')', 3, 0);
        }else{
            $novo = substr_replace($numero, '(', 0, 0);
            $novo = substr_replace($novo, ')', 3, 0);
            $novo = substr_replace($novo, '-', 9, 0);
            $novo = substr_replace($novo, ' ', 4, 0);
            $novo = substr_replace($novo, ' ', 6, 0);
        }
        return $novo;
    }
    //MASCARA PARA DATA
    public static function data($data,$tipo){
        return date($tipo, strtotime($data));
    }
}