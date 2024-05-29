<?php
date_default_timezone_set('America/Sao_Paulo');
require"BD/bd.php";
//require"header.php";
session_start();
class Autenticacao {
    /** EFETUA O LOGIN
	 * 
	 * Retorna um array contendo o status do login e abastecendo as sessoes
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public static function efetuarLogin($v_emailAcesso,$v_senhaAcesso){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios as us 
        LEFT JOIN colaboradores as col USING(IDColaborador) 
        LEFT JOIN contratos USING(IDContrato)
        LEFT JOIN empresas USING(IDContrato)
        LEFT JOIN planos ON(planos.IDPlano = contratos.IDPlano) 
        WHERE NMEmailUsuario = '$v_emailAcesso' AND NMSenhaUsuario = '$v_senhaAcesso' "); //CONSULTA - REALIZA A CONSULTA NO BANCO DE DADOS
        $login = mysqli_fetch_assoc($SQL);
        if($login){
            $PMUsuario = json_decode($login['PMUsuario']); //Permissões do usuário
            $STAcesso = $login['STAcesso']; //Situação do Colaborador
            $STUsuario = $login['STUsuario']; //Situação do Usuario
            $FLUsuario = $login['IDFilial'];  //FILIAL DO USUARIO
            $DSEndContrato = $login['DSEndContrato'];
            $IDContrato = $login['IDContrato'];
            $NVUsuario = $login['NVUsuario']; //Nivel do usuário dentro do sistema
            $IDUsuario = $login['IDUsuario']; //identificação do usuário dentro do sistema
            $STContrato = $login['STContrato'];
            $DSEmail = $login['NMEmailUsuario']; //Email do usuário
            $DSSenha = $login['NMSenhaUsuario']; //Senha do Usuário
            $NMUsuario = $login['NMUsuario']; //nome do usuario
            $IDEmpresa = $login['IDEmpresa'];
            //$TPSoftware = $login['DSSoftware'];
            //Pergunta se o contrato do usuário está ativo
            $retorno['primeirologin'] = false;
            switch($NVUsuario){
                case 1:
                    $_SESSION['login'] = array(
                        "nivel" => $NVUsuario,
                        "dados" => array(
                            'id' => $IDUsuario,
                            "nome" => $NMUsuario,
                            'email' => $DSEmail,
                            'senha' => $DSSenha
                        )
                    );
                    $retorno['status'] = true;
                    $retorno['nivel'] = $NVUsuario;
                    SELF::horaLogin($IDUsuario);
                break;
                case 1.5:
                    if($STUsuario == 1){
                        $_SESSION['login'] = array(
                            "nivel" => $NVUsuario,
                            'permissoes' => $PMUsuario,
                            "dados" => array(
                                'id' => $IDUsuario,
                                "nome" => $NMUsuario,
                                'email' => $DSEmail,
                                'senha' => $DSSenha
                            )
                        );
                        $retorno['status'] = true;
                        $retorno['nivel'] = $NVUsuario;
                        SELF::horaLogin($IDUsuario);
                    }else{
                        $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso negado, usuário bloqueado</strong></h5>";
                        $retorno['status'] = false;
                    }
                break;
                case 2:
                    if($STUsuario == 1){
                        $_SESSION['login'] = array(
                            "nivel" => $NVUsuario,
                            "dados" => array(
                                'id' => $IDUsuario,
                                "nome" => $NMUsuario,
                                'email' => $DSEmail,
                                'senha' => $DSSenha
                            )
                        );
                        if(SELF::primeroLogin($DSEmail)){
                            $retorno['primeirologin'] = false;
                            SELF::horaLogin($IDUsuario);
                        }else{
                            $retorno['primeirologin'] = true;
                            SELF::horaLogin($IDUsuario);
                        }
                        $retorno['status'] = true;
                        $retorno['nivel'] = $NVUsuario;
                    }else{
                        $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                        $retorno['status'] = false;
                    }
                break;
                case 2.5:
                    if($STUsuario == 1){
                        $_SESSION['login'] = array(
                            "nivel" => $NVUsuario,
                            'permissoes' => $PMUsuario,
                            "dados" => array(
                                'id' => $IDUsuario,
                                "nome" => $NMUsuario,
                                'email' => $DSEmail,
                                'senha' => $DSSenha
                            )
                        );
                        $retorno['status'] = true;
                        $retorno['nivel'] = $NVUsuario;
                        SELF::horaLogin($IDUsuario);
                    }else{
                        $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso negado, usuário bloqueado</strong></h5>";
                        $retorno['status'] = false;
                    }
                break;
                case 3:
                    if($STContrato == 1){
                        $_SESSION['login'] = array(
                            "nivel" => $NVUsuario,
                            'contrato' => $IDContrato,
                            "dados" => array(
                                'id' => $IDUsuario,
                                "nome" => $NMUsuario,
                                'email' => $DSEmail,
                                'senha' => $DSSenha
                            )
                        );
                        if(SELF::primeroLogin($DSEmail)){
                            $retorno['primeirologin'] = false;
                            SELF::horaLogin($IDUsuario);
                        }else{
                            $retorno['primeirologin'] = true;
                            SELF::horaLogin($IDUsuario);
                        }
                        $retorno['status'] = true;
                        $retorno['nivel'] = $NVUsuario;
                    }else{
                        $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                        $retorno['status'] = false;
                    }
                break;
                case 3.5:
                    if($STContrato == 1){
                        if($STAcesso == 1){
                            $_SESSION['login'] = array(
                                "nivel" => $NVUsuario,
                                'contrato' => $IDContrato,
                                'permissoes' => $PMUsuario,
                                'filial' => $FLUsuario,
                                "dados" => array(
                                    'id' => $IDUsuario,
                                    "nome" => $NMUsuario,
                                    'email' => $DSEmail,
                                    'senha' => $DSSenha
                                )
                            );
                            $retorno['status'] = true;
                            $retorno['nivel'] = $NVUsuario;
                            SELF::horaLogin($IDUsuario);
                        }else{
                            $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Administrador</strong></h5>";
                            $retorno['status'] = false;
                        }
                    }else{
                        $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Contate o Suporte</strong></h5>";
                        $retorno['status'] = false;
                    }
                break;
            }
        }else{
            $retorno['error'] = "<h5 style='text-align:center;' class='text-danger'><strong>Acesso Negado, Credenciais incorretas</strong></h5>";
            $retorno['status'] = false;
        }
        return json_encode($retorno);
    }

    public static function userPerm($numero,$modulo){
        $nivel = $_SESSION['login']['nivel'];
        if($nivel == 3.5 || $nivel == 1.5 || $nivel == 2.5){
            $p1 = json_encode($_SESSION['login']['permissoes']);
            $permissoes = json_decode($p1,true);
            if(is_int(array_search($numero,$permissoes[$nivel][$modulo]))){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public static function userPermOffline($numero,$modulo,$nivel,$permissoesBd){
        if($nivel == 3.5 || $nivel == 1.5 || $nivel == 2.5){
            $permissoes = json_decode($permissoesBd,true);
            if(is_int(array_search($numero,$permissoes[$nivel][$modulo]))){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    /** RETORNA A HORA DO LOGIN
	 * 
	 * Retorna a hora do login
	 * 
	 * @type	function
	 * @date	01/07/2023
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 *
     */
    public static function primeroLogin($email){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT IDContrato FROM empresas INNER JOIN usuarios USING(IDContrato) WHERE NMEmailUsuario = '$email' ");
        return mysqli_fetch_assoc($SQL);
    }

    /** RETORNA A HORA DO LOGIN
	 * 
	 * Retorna a hora do login
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */

    public static function horaLogin($ID){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET DTUltimoAcesso = NOW() WHERE IDUsuario = '$ID' ");
        return $v_SQL;
    }

    /** CONFERE SE O USUARIO ESTA LOGADO
	 * 
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public static function conferirLogin(){
        if(empty($_SESSION["login"])){
            $v_return = 0;
        }else{
            $v_return = 1;
        }

        return $v_return;
    }

    /** RETORNA A PERMISSÃO DO USUARIO
	 * 
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public function conferirArea($Nivel){
        if(self::conferirLogin() == 1){
            return $Nivel;
        }
    }

    /** RETORNA O ACESSO DO CLIENTE
	 * 
	 * 
	 * @type	function
	 * @date	04/10/2022
	 * @since	1.0.1
	 *
	 * @param	VAR|ARRAY|OBJ
	 * @return	OBJ|ARRAY
	 */
    public static function conferirAcesso($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT col.STAcesso,us.STUsuario,con.STContrato FROM usuarios as us 
        LEFT JOIN colaboradores as col USING(IDColaborador) 
        LEFT JOIN contratos con USING(IDContrato) 
        WHERE IDUsuario = $ID  ");
        $v_acesso = mysqli_fetch_assoc($SQL);
        if($_SESSION['login']['nivel'] > 1){
            if($v_acesso['STContrato'] == 0){
                if($_SESSION['login']['nivel'] == 1.5){
                    if($v_acesso['STUsuario'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }elseif($_SESSION['login']['nivel'] == 2){
                    if($v_acesso['STUsuario'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }elseif($_SESSION['login']['nivel'] == 2.5){
                    if($v_acesso['STUsuario'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }else{
                    $v_access = 0;
                }
            }else{
                if($_SESSION['login']['nivel'] == 3.5){
                    if($v_acesso['STAcesso'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }elseif($_SESSION['login']['nivel'] == 3){
                    if($v_acesso['STContrato'] == 0){
                        $v_access = 0;
                    }else{
                        $v_access = 1;
                    }
                }
            }
        }else{
            $v_access = 1;
        }
        return $v_access;
    }
    //

}
class Usuarios{

    /** RETORNA  LISTA DE USUARIOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getUsuarios($IDEmpresa){
        $current_id = $_SESSION['login']['dados']['id'];
        switch($_SESSION['login']['nivel']){
            case "1.0":
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE NVUsuario <= 3 AND IDUsuario != $current_id ");
            break;
            case "1.5":
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE NVUsuario IN(1.5,3) AND IDUsuario != $current_id ");
            break;
            case "2":
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE NVUsuario = 2.5 AND NVUsuario = 3 AND IDUsuario != $current_id AND IDCriador = '".$_SESSION['login']['dados']['id']."' ");
            break;
            case "2.5":
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE NVUsuario = 2.5 AND NVUsuario = 3 AND IDUsuario != $current_id AND IDCriador = '".$_SESSION['login']['dados']['id']."' ");
            break;
            case "3":
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
                u.*,
                c.NMColaborador,
                c.IDColaborador,
                f.NMFilial
            FROM usuarios u
            LEFT JOIN colaboradores c USING(IDColaborador) 
            LEFT JOIN filiais f USING(IDFilial) 
            LEFT JOIN empresas e USING(IDEmpresa)
            WHERE NVUsuario = 3.5 AND IDEmpresa = $IDEmpresa AND IDUsuario != $current_id");
            break;
        }
        return $v_SQL;
    }

    public static function getUsuario($IDUsuario){
        $current_id = $_SESSION['login']['dados']['id'];
        switch($_SESSION['login']['nivel']){
            case "1.0":
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE IDUsuario = $IDUsuario ");
            break;
            case "1.5":
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE IDUsuario = $IDUsuario ");
            break;
            case "3":
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
                u.*,
                c.NMColaborador,
                c.IDColaborador,
                f.NMFilial
            FROM usuarios u
            LEFT JOIN colaboradores c USING(IDColaborador) 
            LEFT JOIN filiais f USING(IDFilial) 
            LEFT JOIN empresas e USING(IDEmpresa)
            WHERE IDUsuario = $IDUsuario");
            break;
        }
        return mysqli_fetch_assoc($v_SQL);
    }

    /** EXCLUI USUARIOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function excluirUsuario($dados){
        extract($dados);
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM usuarios WHERE IDUsuario = '$IDUsuario' ");
        return $v_SQL;
    }

    /** RETORNA MUDA O STATUS DOS USUARIOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function changeUsuario($ID,$STUsuario){
        if($STUsuario == 1){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET STUsuario = 0 WHERE IDUsuario = '$ID'   ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET STUsuario = 1 WHERE IDUsuario = '$ID'   ");
        }
        return $v_SQL;
    }

    /** RETORNA UM USUARIO ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarUsuario($Permissao,$IDUsuario,$IDEmpresa){
        if($Permissao <= 1){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE IDUsuario = '$IDUsuario' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE IDUsuario = '$IDUsuario' AND IDEmpresa = '$IDEmpresa' ");
        }
        return $v_SQL;
    }

    /** SALVA UM USUARIO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function setRegistro($dados){
        extract($dados);
        switch($nivel){
            case "1.5":
                if($IDUsuario){
                    $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET 
                    NMUsuario = '$nome', 
                    NMEmailUsuario = '$email', 
                    PMUsuario = '$permissoes',
                    NMSenhaUsuario = '$senha'
                    WHERE IDUsuario = '$IDUsuario' ");
                }else{
                    $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO 
                    usuarios (NMUsuario,NMEmailUsuario,NMSenhaUsuario,PMUsuario,NVUsuario) 
                    VALUES 
                    ('$nome','$email','$senha','$permissoes','$nivel') ");
                }
            break;
            case "2":
                if($IDUsuario){
                    $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET 
                    NMUsuario = '$nome', 
                    NMEmailUsuario = '$email',
                    NMSenhaUsuario = '$senha' 
                    WHERE IDUsuario = $IDUsuario ");
                }else{
                    $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO 
                    usuarios (NMUsuario,NMEmailUsuario,NMSenhaUsuario,NVUsuario) 
                    VALUES 
                    ('$nome','$email','$senha',2) ");
                }
            break;
            case "2.5":
                if($IDUsuario){
                    $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET 
                    NMUsuario = '$nome', 
                    NMEmailUsuario = '$email', 
                    PMUsuario = '$permissoes',
                    NMSenhaUsuario = '$senha'
                    WHERE IDUsuario = '$IDUsuario' ");
                }else{
                    $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO 
                    usuarios (NMUsuario,NMEmailUsuario,NMSenhaUsuario,PMUsuario,NVUsuario,IDCriador) 
                    VALUES 
                    ('$nome','$email','$senha','$permissoes','$nivel','".$_SESSION['login']['dados']['id']."') ");
                }
            break;
            case "3.0":
                if($IDUsuario){
                    $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET 
                    NMUsuario = '$nome', 
                    NMEmailUsuario = '$email',
                    NMSenhaUsuario = '$senha' 
                    WHERE IDUsuario = $IDUsuario ");
                }else{
                    $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO 
                    usuarios (NMUsuario,NMEmailUsuario,NMSenhaUsuario,IDContrato,NVUsuario,IDCriador) 
                    VALUES 
                    ('$nome','$email','$senha',".intval($contrato).",3,'".$_SESSION['login']['dados']['id']."') ");
                }
            break;
            case "3.5":
                if($IDUsuario){
                    $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET 
                    NMUsuario = '$nome', 
                    NMEmailUsuario = '$email', 
                    PMUsuario = '$permissoes'
                    WHERE IDUsuario = '$IDUsuario' ");
                }else{
                    $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO 
                    usuarios (NMUsuario,NMEmailUsuario,NMSenhaUsuario,IDContrato,NVUsuario,IDColaborador,PMUsuario) 
                    VALUES 
                    ('$nome','$email','$senha',".intval($contrato).",3.5,".intval($colaborador).",'$permissoes') ");
                }
            break;
        }
        return $SQL;
    }

    /** RETORNA SITUAÇÃO DO UPDATE
     * 
     * AO ATUALIZAR STATUS, ELE RETORNA 1 E RECARREGA A TELA PARA LISTAR AS NOVAS PERMISSOES DE UM USUARIO ESPECIFICO
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function updatePerm($ID){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE usuarios SET STUpdate = 0 WHERE IDUsuario = '$ID' ");
        return $v_SQL;
    }

    /** CONFERE O STATUS DO USUARIO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */

    public function conferirUpdate($ID){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT STUpdate FROM usuarios WHERE IDUsuario = '$ID' ");
        return mysqli_fetch_assoc($v_SQL);
    }

}
//CLASSE DE CUPONS
class Cupons{

    public static function sincronizaCupons($dados){
        extract($dados);
        mysqli_query(FRController::conectarDatabase(),"INSERT INTO cupons (IDCaixa,ANCupom,CDVenda,IDCliente,IDFilial) VALUES('$IDCaixa','$ANCupom','$CDVenda','$IDCliente','$IDFilial')");
    }

    public static function setCupom($dados){
        extract($dados);
        if(isset($_SESSION['login']['filial'])){
            $filiauu = $_SESSION['login']['filial'];
        }else{
            $filiauu  = $IDFilial;
        }
        $SQL = "INSERT INTO cupons (IDCaixa,CDVenda,ANCupom,IDCliente,IDFilial) VALUES('$IDCaixa','$CDVenda','$ANCupom','$IDCliente','".$filiauu."')";
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
    //COLETA OS DADOS DO CABECALHO DO CUPOM
    public static function getHeaderCupom($IDFilial){
        $SQL = "SELECT DSEnderecoJSON,NMFilial,NUCnpjEmpresa,NMRazaoEmpresa FROM filiais INNER JOIN empresas USING(IDEmpresa) WHERE IDFilial = $IDFilial";
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
}
//CLASSE DE SERVICOS
class Vendas{

    //CANCELA A VENDA
    public static function cancelaVenda($dados){
        extract($dados);
        $dadosProduto = mysqli_query(FRController::conectarDatabase(),"SELECT NUCustoProduto,NUEstoqueProduto,IDProduto,VLVenda FROM produtos INNER JOIN vendas USING(IDProduto) WHERE IDVenda = $IDVenda ");
        $produto = mysqli_fetch_assoc($dadosProduto);
        $vlvenda = $produto['VLVenda']/$Vendas;
        $aidi = implode(",",mysqli_fetch_assoc(mysqli_query(FRController::conectarDatabase(),"SELECT IDProduto FROM vendas WHERE IDVenda = $IDVenda")));
        if($QTDevolucao == $Vendas){
            if($Acao == "Repor"){
                mysqli_query(FRController::conectarDatabase(),"UPDATE vendas SET STVenda = 0 WHERE IDVenda = $IDVenda");
                mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET NUEstoqueProduto = produtos.NUEstoqueProduto + $QTDevolucao WHERE IDProduto = '".$produto['IDProduto']."' ");
            }else{
                mysqli_query(FRController::conectarDatabase(),"UPDATE vendas SET STVenda = 0 WHERE IDVenda = $IDVenda");
            }
        }else{
            if($Acao == "Repor"){
                mysqli_query(FRController::conectarDatabase(),"UPDATE vendas SET NUUnidadesVendidas = vendas.NUUnidadesVendidas - $QTDevolucao,VLVenda = vendas.VLVenda - $vlvenda WHERE IDVenda = $IDVenda");
                mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET NUEstoqueProduto = produtos.NUEstoqueProduto + $QTDevolucao WHERE IDProduto = '".$produto['IDProduto']."' ");
            }else{
                mysqli_query(FRController::conectarDatabase(),"UPDATE vendas SET NUUnidadesVendidas = vendas.NUUnidadesVendidas - $QTDevolucao,VLVenda = vendas.VLVenda - $vlvenda WHERE IDVenda = $IDVenda");
            }  
        }
        return true;
    }

    public static function getListaVendas($IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        NMProduto,
        VLVenda,
        NMPagamento,
        NMPromo,
        NMCliente,
        NMPdv,
        DSGarantiaProduto,
        DTVenda,
        IDVenda,
        IDVenda,
        NUUnidadesVendidas,
        NMColaborador,
        NUCustoProduto,
        QTDesconto,
        pagamentos.TPDesconto,
        DTVenda
        FROM vendas
        INNER JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        INNER JOIN pagamentos ON(pagamentos.IDPagamento = vendas.IDPagamento)
        LEFT JOIN promocoes ON(promocoes.IDPromocao = vendas.IDPromocao)
        LEFT JOIN clientes ON(clientes.IDCliente = vendas.IDCliente)
        LEFT JOIN caixa ON(caixa.IDCaixa = vendas.IDCaixa)
        LEFT JOIN colaboradores ON(colaboradores.IDColaborador = vendas.IDColaborador)
        LEFT JOIN fornecedores ON(fornecedores.IDFornecedor = produtos.IDFornecedor)
        LEFT JOIN filiais ON(filiais.IDFilial = fornecedores.IDFilial)
        WHERE STInsumo = 0 AND filiais.IDFilial = $IDFilial AND STVenda = 1");
        return $SQL;
    }

    public static function getListaVendasInsumos($IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        NMProduto,
        VLVenda,
        NMPagamento,
        NMPromo
        NMCliente,
        NMPdv,
        IDVenda,
        NUUnidadesVendidas,
        NMColaborador,
        DSTipoServico,
        NUCustoProduto,
        QTDesconto,
        pagamentos.TPDesconto,
        DTVenda
        FROM vendas
        INNER JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        INNER JOIN pagamentos ON(pagamentos.IDPagamento = vendas.IDPagamento)
        LEFT JOIN promocoes ON(promocoes.IDPromocao = vendas.IDPromocao)
        LEFT JOIN clientes ON(clientes.IDCliente = vendas.IDCliente)
        LEFT JOIN caixa ON(caixa.IDCaixa = vendas.IDCaixa)
        LEFT JOIN colaboradores ON(colaboradores.IDColaborador = vendas.IDColaborador)
        LEFT JOIN fornecedores ON(fornecedores.IDFornecedor = produtos.IDFornecedor)
        LEFT JOIN filiais ON(filiais.IDFilial = fornecedores.IDFilial)
        INNER JOIN servicos ON(servicos.IDFilial = filiais.IDFilial)
        INNER JOIN ordemservico ON(ordemservico.IDServico = servicos.IDServico)
        LEFT JOIN custosordem ON(ordemservico.IDOrdem = custosordem.IDOrdem)
        WHERE STInsumo = 1 AND filiais.IDFilial = $IDFilial");
        return $SQL;
    }

    public static function confereVenda($IDProduto){
       $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM vendas WHERE IDProduto = '$IDProduto' ");
       return mysqli_fetch_assoc($SQL);
    }
    public static function sincronizaVendas($dados){
        extract($dados);
        $SQL = <<<SQL
        INSERT INTO vendas (
            IDProduto,
            IDFornecedor,
            IDPromocao,
            IDCliente,
            IDColaborador,
            NUUnidadesVendidas,
            IDCaixa,
            IDFilial,
            IDPagamento,
            VLVenda,
            CDVenda
            )
            VALUES (
                '$IDProduto',
                '$IDFornecedor',
                '$IDPromocao',
                '$IDCliente',
                '$IDColaborador',
                '$NUUnidadesVendidas',
                '$IDCaixa',
                '$IDFilial',
                '$IDPagamento',
                '$VLVenda',
                '$CDVenda'
            )
        SQL;
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
    public static function setVenda($dados){
        extract($dados);
        if(isset($IDOrdem)){
            $ordi = $IDOrdem;
        }else{
            $ordi = "";
        }
        $SQL = <<<SQL
        INSERT INTO vendas (
            IDProduto,
            IDFornecedor,
            IDPromocao,
            IDCliente,
            IDColaborador,
            NUUnidadesVendidas,
            IDCaixa,
            IDFilial,
            IDPagamento,
            VLVenda,
            CDVenda,
            IDOrdem
            )
            VALUES (
                '$IDProduto',
                '$IDFornecedor',
                '$IDPromocao',
                '$IDCliente',
                '$IDColaborador',
                '$NUUnidadesVendidas',
                '$IDCaixa',
                '$IDFilial',
                '$IDPagamento',
                '$VLVenda',
                '$CDVenda',
                '$ordi'
            )
        SQL;
        return mysqli_query(FRController::conectarDatabase(),$SQL) && mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET produtos.NUEstoqueProduto = produtos.NUEstoqueProduto - $NUUnidadesVendidas WHERE IDProduto = $IDProduto ");
    }
    //PEGA A QUANTIDADE DE VENDAS
    public static function getQuantidadeVendas($IDProduto){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        SUM(NUUnidadesVendidas) as quantidadeVendas,
        SUM(NUUnidadesVendidas) * NUValorProduto as valorVendas,
        SUM(NUCustoProduto) as custoProd,
        produtos.IDProduto as produto,
        CASE WHEN vendas.IDPagamento IS NOT NULL THEN vendas.IDPagamento ELSE 0 END as pagamento
        FROM produtos LEFT JOIN vendas USING(IDProduto) WHERE IDProduto = $IDProduto AND STVenda = 1");
        $retorno = mysqli_fetch_assoc($SQL);
        $valorDescontoPagamento = SELF::getDescontoPagamento($retorno['valorVendas'],$retorno['pagamento']);
        $valorDescontoPromo = Promocoes::confProdutoPromocional($retorno['produto'],FRGeral::trataValor($valorDescontoPagamento,1),$_SESSION['login']['filial']);
        return array(
            "quantidade" => ($retorno['quantidadeVendas']) ? $retorno['quantidadeVendas'] : 0,
            "valorVendas" => $valorDescontoPromo - $retorno['custoProd'],
            "valorVendasBruto" => $valorDescontoPromo
        );
        //return FRGeral::trataValor($valorDescontoPagamento,1);
    }
    //COLETA OS DADOS DO PRODUTO PELO ID
    public static function getDadosProduto($IDProduto){
        $SQL = <<<SQL
            SELECT 
            P.IDProduto,
            f.IDFornecedor,
            P.NUValorProduto,
            CASE WHEN promo.IDPromocao IS NULL THEN 0 ELSE promo.IDPromocao END as IDPromocao
            FROM produtos P
            INNER JOIN fornecedores f USING(IDFornecedor)
            LEFT JOIN promocionais promo USING(IDProduto)
            WHERE IDProduto = $IDProduto
        SQL;
        $return = mysqli_query(FRController::conectarDatabase(),$SQL);
        return mysqli_fetch_assoc($return) ;
    }
    //COLETA OS DADOS DO CLIENTE PELO ID
    public static function getSituacaoCliente($IDCliente){
        $SQL = <<<SQL
            SELECT 
            CASE WHEN d.VLDivida IS NOT NULL THEN d.VLDivida ELSE 0.00 END as divida,
            CASE WHEN c.NUCredito IS NOT NULL THEN c.NUCredito ELSE 0.00 END as credito
            FROM clientes cli
            LEFT JOIN devedores d USING(IDCliente) 
            LEFT JOIN crediarios c USING(IDCliente)
            WHERE cli.IDCliente = $IDCliente
        SQL;
        return mysqli_query(FRController::conectarDatabase(),$SQL); 
    }
    //PERGUNTA O DESCONTO DO METODO DE PAGAMENTO
    public static function getDescontoPagamento($valor,$pagamento){
        $tp = mysqli_query(FRController::conectarDatabase(),"SELECT TPDesconto,QTDesconto FROM pagamentos WHERE IDPagamento = $pagamento");
        $tipo = mysqli_fetch_assoc($tp);
        if($tipo){
            if($tipo['TPDesconto'] == 1){
                $desconto = $valor - ($tipo['QTDesconto']*$valor)/100 ;
            }elseif($tipo['TPDesconto'] == 2){
                $desconto = $valor - $tipo['QTDesconto'];
            }else{
                $desconto = $valor;
            }
        }else{
            $desconto = $valor;
        }
        return FRGeral::trataValor($desconto,0);
    }
}
//CLASS RELATORIOS
class Relatorios{

    public static function getFreguesiaServicos($IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        ordemservico.IDColaborador as idcol,
        IDOrdem as idord,
        ordemservico.IDCliente as idcli,
        COUNT(IDOrdem) as Quantidade,
        NMCliente as nome,
        CASE WHEN pagamentos.QTDesconto > 0 THEN
        CASE WHEN pagamentos.TPDesconto = '%' THEN
                SUM(VLBase) - (pagamentos.QTDesconto*SUM(VLBase))/100
            ELSE
                SUM(VLBase) - pagamentos.QTDesconto
            END
        ELSE
            SUM(VLBase)
        END as mobra,
        NMFilial,
        (SELECT
        SUM(VLVenda - NUCustoProduto)
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        WHERE IDColaborador IN(idcol) AND IDCliente IN(idcli) AND STInsumo = 1) as vendas,
        (SELECT
        SUM(VLVenda)
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        WHERE IDColaborador IN(idcol) AND IDCliente IN(idcli) AND STInsumo = 1) as vendasBrutas
        FROM ordemservico
        LEFT JOIN custosordem USING(IDOrdem)
        LEFT JOIN clientes ON(clientes.IDCliente = ordemservico.IDCliente)
        LEFT JOIN pagamentos USING(IDPagamento)
        LEFT JOIN produtos USING(IDProduto) 
        LEFT JOIN servicos USING(IDServico)
        LEFT JOIN filiais ON(servicos.IDFilial = filiais.IDFilial)
        WHERE filiais.IDFilial = $IDFilial
        GROUP BY NMCliente");
        return $SQL;
    }

    public static function getFrueguesiaProdutos($IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        NMCliente as nome,
        COUNT(IDVenda) as Quantidade,
        SUM(VLVenda - NUCustoProduto) as compras,
        SUM(VLVenda) as comprasBrutas
        FROM clientes
        LEFT JOIN vendas USING(IDCliente)
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        LEFT JOIN filiais ON(vendas.IDFilial = filiais.IDFilial)
        WHERE STInsumo = 0 AND filiais.IDFilial = $IDFilial AND STVenda = 1
        GROUP BY NMCliente");
        return $SQL;
    }

    //PEGA OS RELATORIOS DO PAINEL ADM
    public static function getAdminPanel(){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
            COUNT(IDContrato) as qtContratos,
            CASE WHEN TMPlano = 30 THEN SUM(VLPlano) END as mrr,
            CASE WHEN TMPlano = 30 THEN SUM(VLPlano)*12 END as arr,
            (SELECT COUNT(IDContrato) FROM contratos WHERE STContrato = 0) as qtInativos,
            (SELECT COUNT(IDContrato) FROM contratos WHERE IDPlano = 1) as starter,
            (SELECT COUNT(IDContrato) FROM contratos WHERE IDPlano = 2) as ecommerce,
            (SELECT COUNT(IDContrato) FROM contratos WHERE IDPlano = 3) as fiscal,
            (SELECT COUNT(IDContrato) FROM contratos WHERE IDPlano = 4) as ecommercefiscal
        FROM contratos INNER JOIN planos USING(IDPlano)");
        return mysqli_fetch_assoc($SQL);
    }
    //CLASS RELATORIOS PRODUTOS E SERVICOS
    public static function getCatAndServ($dado){
        if($dado=="filial"){
            $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' "; 
        }elseif($dado=="empresa"){
            $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' ";
        }else{
            $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$dado."' ";
        }
        $sqlCat = mysqli_query(FRController::conectarDatabase(),"SELECT 
        SUM(NUUnidadesVendidas) as vendas,
        DSCategoria as categoria
        FROM vendas
        INNER JOIN produtos USING(IDProduto)
        INNER JOIN categorias USING(IDCategoria)
        INNER JOIN filiais ON(filiais.IDFilial = categorias.IDFilial)
        INNER JOIN empresas USING(IDEmpresa)
        WHERE $where
        GROUP BY DSCategoria");

        $sqlServ = mysqli_query(FRController::conectarDatabase(),"SELECT 
        DSTipoServico as nome,
        COUNT(IDServico) as quantidade
        FROM servicos
        INNER JOIN ordemservico USING(IDServico)
        INNER JOIN filiais ON(filiais.IDFilial = servicos.IDFilial)
        INNER JOIN empresas USING(IDEmpresa)
        WHERE $where
        GROUP BY DSTipoServico");

        return array(
            "CAT" => $sqlCat,
            "SERV" => $sqlServ
        );
    }

    public static function getPags($IDFilial){
        $sqlCat = mysqli_query(FRController::conectarDatabase(),"SELECT 
        SUM(NUUnidadesVendidas) as vendas,
        NMPagamento as pagamento
        FROM vendas
        INNER JOIN produtos USING(IDProduto)
        INNER JOIN pagamentos ON(vendas.IDPagamento = pagamentos.IDPagamento)
        INNER JOIN filiais ON(filiais.IDFilial = pagamentos.IDFilial)
        WHERE filiais.IDFilial = $IDFilial
        GROUP BY pagamentos.IDPagamento");
        return $sqlCat;
    }

    public static function getPromos($IDFilial){
        $sqlCat = mysqli_query(FRController::conectarDatabase(),"SELECT 
        SUM(NUUnidadesVendidas) as vendas,
        NMPromo as promo
        FROM vendas
        INNER JOIN produtos USING(IDProduto)
        INNER JOIN promocoes ON(vendas.IDPromocao = promocoes.IDPromocao)
        INNER JOIN filiais ON(filiais.IDFilial = promocoes.IDFilial)
        WHERE filiais.IDFilial = $IDFilial AND NOW() >= promocoes.DTInicioPromo AND NOW() <= promocoes.DTTerminoPromo
        GROUP BY promocoes.NMPromo");
        return $sqlCat;
    }
    //PEGA OS RELATORIOS DO PAINEL DO CONTRATANTE
    public static function getVendas($dado,$data,$tipo){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $wheref = " ef.IDEmpresa = '".$_SESSION['login']['empresa']."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' ";
            $wherev = " ev.IDEmpresa = '".$_SESSION['login']['empresa']."' AND lv.IDFilial = '".$_SESSION['login']['filial']."' ";
            if(!empty($tipo)){
                if($tipo == "M"){
                    $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' AND DTVenda LIKE '%".$data."%' ";
                }else{
                    $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' AND DTVenda LIKE '%".$data."%' ";
                }
            }else{
                $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' ";
            } 
        }elseif($dado=="empresa"){
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial IN (SELECT IDFilial FROM filiais WHERE IDEmpresa = '".$idimpresa."' ) ";
            $wherev = " ev.IDEmpresa = '".$idimpresa."' AND lv.IDFilial IN (SELECT IDFilial FROM filiais WHERE IDEmpresa = '".$idimpresa."' ) ";
            if(!empty($tipo)){
                if($tipo == "M"){
                    $where = " IDEmpresa = '".$idimpresa."' AND DTVenda LIKE '%".$data."%' ";
                }else{
                    $where = " IDEmpresa = '".$idimpresa."' AND DTVenda LIKE '%".$data."%' ";
                }
            }else{
                $where = " IDEmpresa = '".$idimpresa."' ";
            } 
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$dado."' ";
            $wherev = " ev.IDEmpresa = '".$idimpresa."' AND lv.IDFilial = '".$dado."' ";
        }

        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
            SUM(p.NUValorProduto * v.NUUnidadesVendidas) as faturamentovendastotal,
            SUM(v.VLVenda - p.NUCustoProduto * v.NUUnidadesVendidas) as lucrovendastotal,
            (SELECT 
                SUM(NUValorProduto * NUUnidadesVendidas)
            FROM produtos INNER JOIN vendas USING(IDProduto) INNER JOIN filiais ff USING(IDFilial) INNER JOIN empresas ef USING(IDEmpresa) WHERE $wheref AND DATE_FORMAT(DTVenda,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') AND IDProduto NOT IN(SELECT IDProduto FROM custosordem)
            ) as faturamentovendashoje,
            (SELECT 
            SUM(VLVenda - NUCustoProduto * NUUnidadesVendidas)
            FROM produtos INNER JOIN vendas USING(IDProduto) INNER JOIN filiais lv USING(IDFilial) INNER JOIN empresas ev WHERE $wherev AND DATE_FORMAT(DTVenda,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') AND IDProduto NOT IN(SELECT IDProduto FROM custosordem)
            ) as lucrovendashoje
        FROM produtos p INNER JOIN vendas v USING(IDProduto) INNER JOIN filiais USING(IDFilial) INNER JOIN empresas USING(IDEmpresa) WHERE $where AND IDProduto NOT IN(SELECT IDProduto FROM custosordem)");
        return mysqli_fetch_assoc($SQL);
    }
    //GET CAT
    public static function getServicosHoje($IDFilial,$hoje){
        if($hoje){
            $where = "AND DATE_FORMAT(DTServico,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')";
        }else{
            $where = "";
        }
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        ordemservico.IDColaborador as idcol,
        IDOrdem as idord,
        DSTipoServico,
        CASE WHEN pagamentos.QTDesconto > 0 THEN
                    CASE WHEN pagamentos.TPDesconto = '%' THEN
                        SUM(VLBase) - (pagamentos.QTDesconto*SUM(VLBase))/100
                    ELSE
                        SUM(VLBase) - pagamentos.QTDesconto
                    END
                ELSE
                    SUM(VLBase)
                END as mobra,
        COUNT(IDServico) as Quantidade,
        (SELECT
        SUM(VLVenda - produtos.NUCustoProduto)
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        WHERE IDColaborador IN(idcol) AND STInsumo = 1) as insumos,
        (SELECT
        SUM(VLVenda)
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        WHERE IDColaborador IN(idcol) AND STInsumo = 1) as insumosBruto
        FROM ordemservico
        LEFT JOIN custosordem USING(IDOrdem)
        LEFT JOIN colaboradores ON(colaboradores.IDColaborador = ordemservico.IDColaborador)
        LEFT JOIN pagamentos USING(IDPagamento)
        LEFT JOIN produtos USING(IDProduto) 
        LEFT JOIN servicos USING(IDServico)
        LEFT JOIN clientes USING(IDCliente)
        LEFT JOIN filiais ON(servicos.IDFilial = filiais.IDFilial)
        WHERE servicos.IDFilial = $IDFilial $where
        GROUP BY DSTipoServico");
        return $SQL;
    }
    //PEGA AS VENDAS HOJE
    public static function getVendasHoje($IDFilial,$hoje){
        if($hoje){
            $where = "AND DATE_FORMAT(DTVenda,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')";
        }else{
            $where = "";
        }
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        COUNT(produtos.IDProduto) as Quantidade,
        SUM(VLVenda - NUCustoProduto) as produtos,
        SUM(VLVenda) as produtosBruto,
        NMProduto
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        LEFT JOIN filiais ON(vendas.IDFilial = filiais.IDFilial)
        WHERE STInsumo = 0 AND filiais.IDFilial = $IDFilial AND STVenda = 1 $where
        GROUP BY NMProduto");
        return $SQL;
    }
    //PEGA OS RELATORIOS DOS SERVIÇOS
    public static function getServicos($dado,$data,$tipo){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $wheref = " emp.IDEmpresa = '".$_SESSION['login']['empresa']."' AND fil.IDFilial = '".$_SESSION['login']['filial']."' ";
            $whereI = " ei.IDEmpresa = '".$_SESSION['login']['empresa']."' AND fi.IDFilial = '".$_SESSION['login']['filial']."' ";
            if(!empty($tipo)){
                if($tipo == "M"){
                    $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' AND DTSaida LIKE '%".$data."%' ";
                }else{
                    $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' AND DTSaida LIKE '%".$data."%' ";
                }
            }else{
                $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' ";
            } 
        }elseif($dado=="empresa"){
            $wheref = " emp.IDEmpresa = '".$idimpresa."' ";
            $whereI = " ei.IDEmpresa = '".$idimpresa."' ";
            if(!empty($tipo)){
                if($tipo == "M"){
                    $where = " IDEmpresa = '".$idimpresa."' AND DTSaida LIKE '%".$data."%' ";
                }else{
                    $where = " IDEmpresa = '".$idimpresa."' AND DTSaida LIKE '%".$data."%' ";
                }
            }else{
                $where = " IDEmpresa = '".$idimpresa."' ";
            } 
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
            $wheref = " emp.IDEmpresa = '".$idimpresa."' AND fil.IDFilial = '".$dado."' ";
            $whereI = " ei.IDEmpresa = '".$idimpresa."' AND fi.IDFilial = '".$dado."' ";
        }

        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        CASE WHEN NUValorProduto IS NOT NULL THEN
            SUM(NUValorProduto) + SUM(VLBase)
        ELSE
            SUM(VLBase)
        END as faturamentoservicos_total,
            CASE WHEN NUValorProduto IS NOT NULL THEN
                CASE WHEN pagamentos.QTDesconto > 0 THEN
                    CASE WHEN pagamentos.TPDesconto = '%' THEN
                        SUM(VLBase) + SUM(VLvenda) - (pagamentos.QTDesconto*SUM(VLBase) + SUM(VLVenda))/100
                    ELSE
                        SUM(VLBase) + SUM(VLVenda) - pagamentos.QTDesconto
                    END
                ELSE
                    SUM(VLVenda) + SUM(VLBase)
                END
            ELSE
                CASE WHEN pagamentos.QTDesconto > 0 THEN
                    CASE WHEN pagamentos.TPDesconto = '%' THEN
                        SUM(VLBase) - (pagamentos.QTDesconto*SUM(VLBase) + SUM(VLVenda))/100
                    ELSE
                        SUM(VLBase) - pagamentos.QTDesconto
                    END
                ELSE
                    SUM(VLBase)
                END
            END as lucroservicos_total,
            (SELECT 
                CASE WHEN NUValorProduto IS NOT NULL THEN
                    CASE WHEN pagamentos.QTDesconto > 0 THEN
                        CASE WHEN pagamentos.TPDesconto = '%' THEN
                            SUM(VLBase) + SUM(VLvenda) - (pagamentos.QTDesconto*SUM(VLBase) + SUM(VLVenda))/100
                        ELSE
                            SUM(VLBase) + SUM(VLVenda) - pagamentos.QTDesconto
                        END
                    ELSE
                        SUM(VLVenda) + SUM(VLBase)
                    END
                ELSE
                    CASE WHEN pagamentos.QTDesconto > 0 THEN
                        CASE WHEN pagamentos.TPDesconto = '%' THEN
                            SUM(VLBase) - (pagamentos.QTDesconto*SUM(VLBase) + SUM(VLVenda))/100
                        ELSE
                            SUM(VLBase) - pagamentos.QTDesconto
                        END
                    ELSE
                        SUM(VLBase)
                    END
                END
            FROM ordemservico 
            LEFT JOIN custosordem USING(IDOrdem) 
            LEFT JOIN pagamentos USING(IDPagamento)
            LEFT JOIN produtos USING(IDProduto) 
            LEFT JOIN servicos USING(IDServico) 
            LEFT JOIN vendas USING(IDProduto)
            LEFT JOIN promocoes USING(IDPromocao)
            LEFT JOIN promocionais USING(IDProduto)
            LEFT JOIN filiais fil ON(servicos.IDFilial = fil.IDFilial) 
            LEFT JOIN empresas emp USING(IDEmpresa) 
            WHERE $wheref AND STServico = 1 AND DATE_FORMAT(DTSaida,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')
            ) as lucroservicos_hoje,
            (SELECT
            CASE WHEN NUValorProduto IS NOT NULL THEN
                SUM(NUValorProduto) + SUM(VLBase)
            ELSE
                SUM(VLBase)
            END 
            FROM ordemservico 
            LEFT JOIN custosordem USING(IDOrdem) 
            LEFT JOIN produtos USING(IDProduto) 
            LEFT JOIN servicos USING(IDServico) 
            LEFT JOIN filiais as fi ON(servicos.IDFilial = fi.IDFilial) 
            LEFT JOIN empresas as ei USING(IDEmpresa) 
            WHERE $whereI AND STServico = 1 AND DATE_FORMAT(DTSaida,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')) as faturamentoservico_hoje
        FROM ordemservico 
        LEFT JOIN custosordem USING(IDOrdem) 
        LEFT JOIN pagamentos USING(IDPagamento)
        LEFT JOIN produtos USING(IDProduto) 
        LEFT JOIN servicos USING(IDServico) 
        LEFT JOIN vendas USING(IDProduto)
        LEFT JOIN promocoes USING(IDPromocao)
        LEFT JOIN promocionais USING(IDProduto)
        LEFT JOIN filiais ON(servicos.IDFilial = filiais.IDFilial) 
        LEFT JOIN empresas USING(IDEmpresa) 
        WHERE $where AND STServico = 1 ");
        return mysqli_fetch_assoc($SQL);
    }
    //FOLHA SALARIAL
    public static function getColaboradores($dado){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' "; 
        }elseif($dado=="empresa"){
            $where = " IDEmpresa = '".$idimpresa."' ";
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
        }
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT SUM(VLSalario) as salarios,COUNT(IDColaborador) as qtColaboradores FROM colaboradores INNER JOIN filiais USING(IDFilial) INNER JOIN empresas USING(IDEmpresa) WHERE $where");
        return mysqli_fetch_assoc($SQL);
    }
    //LISTA DE SERVIÇOS VENDIDOS
    public static function getVendasProdutos($IDEmpresa){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        NMColaborador,
        SUM(VLVenda) as produtos,
        NUPorcentagem,
        NMFilial
        FROM colaboradores
        LEFT JOIN vendas USING(IDColaborador)
        LEFT JOIN comissionados USING(IDColaborador)
        LEFT JOIN comissoes ON(comissoes.IDComissao = comissionados.IDComissao)
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        LEFT JOIN filiais ON(vendas.IDFilial = filiais.IDFilial)
        LEFT JOIN empresas ON(filiais.IDEmpresa = empresas.IDEmpresa)
        WHERE STInsumo = 0 AND empresas.IDEmpresa = $IDEmpresa AND STVenda = 1
        GROUP BY NMColaborador");
        return $SQL;
    }

    public static function getVendasServicos($IDEmpresa){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        ordemservico.IDColaborador as idcol,
        IDOrdem as idord,
        NMColaborador as nome,
        CASE WHEN pagamentos.QTDesconto > 0 THEN
                    CASE WHEN pagamentos.TPDesconto = '%' THEN
                        SUM(VLBase) - (pagamentos.QTDesconto*SUM(VLBase))/100
                    ELSE
                        SUM(VLBase) - pagamentos.QTDesconto
                    END
                ELSE
                    SUM(VLBase)
                END as vendas,
        NMFilial,
        CASE WHEN NUPorcentagem IS NULL THEN 0 ELSE NUPorcentagem END as porcentagem ,
        (SELECT
        SUM(VLVenda)
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        WHERE IDColaborador IN(idcol) AND STInsumo = 1) as produtos
        FROM ordemservico
        LEFT JOIN custosordem USING(IDOrdem)
        LEFT JOIN colaboradores ON(colaboradores.IDColaborador = ordemservico.IDColaborador)
        LEFT JOIN pagamentos USING(IDPagamento)
        LEFT JOIN produtos USING(IDProduto) 
        LEFT JOIN servicos USING(IDServico)
        LEFT JOIN filiais ON(servicos.IDFilial = filiais.IDFilial)
        LEFT JOIN empresas USING(IDEmpresa) 
        LEFT JOIN comissionados ON(ordemservico.IDColaborador = comissionados.IDColaborador)
        LEFT JOIN comissoes ON(comissionados.IDComissao = comissoes.IDComissao)
        WHERE IDEmpresa = $IDEmpresa
        GROUP BY NMColaborador");
        return $SQL;

    }
    //DESPESAS
    public static function getDespesas($dado){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' ";
        }elseif($dado=="empresa"){
            $where = " IDEmpresa = '".$idimpresa."' ";
            $wheref = " ef.IDEmpresa = '".$idimpresa."' ";
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$dado."' ";
        }

        $mesHoje = date('Y-m');

        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        COUNT(IDConta) as QTContas,
        SUM(VLConta) as VLDespesas,
        (SELECT
            SUM(VLConta)
        FROM contapagar INNER JOIN filiais USING(IDFilial) INNER JOIN empresas USING(IDEmpresa) WHERE $where AND DTExpedicaoConta LIKE '%$mesHoje%'
        ) as VLDespesasMes,
        (SELECT 
            COUNT(IDConta)
            FROM contapagar INNER JOIN filiais ff USING(IDFilial) INNER JOIN empresas ef USING(IDEmpresa) WHERE $wheref AND DTVencimentoConta <= DATE_ADD(NOW(), INTERVAL 3 DAY) ) as contasvencer
        FROM contapagar INNER JOIN filiais USING(IDFilial) INNER JOIN empresas USING(IDEmpresa) WHERE $where");
        return mysqli_fetch_assoc($SQL);
    }
    //COMPRAS 
    public static function getReposicoes($dado,$data,$tipo){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' ";
            if(!empty($tipo)){
                if($tipo == "M"){
                    $wheref = " ef.IDEmpresa = '".$_SESSION['login']['empresa']."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' AND DTReposicao = '%".$data."%' ";
                    $wherev = " ev.IDEmpresa = '".$_SESSION['login']['empresa']."' AND lv.IDFilial = '".$_SESSION['login']['filial']."' AND DTEntradaProduto = '%".$data."%' ";
                }else{
                    $wheref = " ef.IDEmpresa = '".$_SESSION['login']['empresa']."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' AND DTReposicao = '%".$data."%' ";
                    $wherev = " ev.IDEmpresa = '".$_SESSION['login']['empresa']."' AND lv.IDFilial = '".$_SESSION['login']['filial']."' AND DTEntradaProduto = '%".$data."%' ";
                }
            }else{
                $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' ";
                $wherev = " ev.IDEmpresa = '".$idimpresa."' AND lv.IDFilial = '".$_SESSION['login']['filial']."' ";
            } 
        }elseif($dado=="empresa"){
            $where = " IDEmpresa = '".$idimpresa."' ";
            if(!empty($tipo)){
                if($tipo == "M"){
                    $wheref = " IDEmpresa = '".$idimpresa."' AND DTReposicao LIKE '%".$data."%' ";
                    $wherev = " IDEmpresa = '".$idimpresa."' AND DTEntradaProduto LIKE '%".$data."%' ";
                }else{
                    $wheref = " IDEmpresa = '".$idimpresa."' AND DTReposicao LIKE '%".$data."%' ";
                    $wherev = " IDEmpresa = '".$idimpresa."' AND DTEntradaProduto LIKE '%".$data."%' ";
                }
            }else{
                $wheref = " IDEmpresa = '".$idimpresa."' ";
                $wherev = " IDEmpresa = '".$idimpresa."' ";
            }
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$dado."' ";
            $wherev = " ev.IDEmpresa = '".$idimpresa."' AND lv.IDFilial = '".$dado."' ";
        }

        $mesHoje = date('Y-m');

        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        SUM(NUCustoProduto)* QTCompra as comprasTotal,
        (SELECT 
            SUM(NUCustoProduto * QTCompra)
        FROM
        compras 
        LEFT JOIN produtos 
        USING(IDProduto)
        INNER JOIN fornecedores USING(IDFornecedor)
        INNER JOIN filiais as ff USING(IDFilial)
        INNER JOIN empresas as ef USING(IDEmpresa)
        WHERE $wheref
        ) as comprasHoje,
        (SELECT 
            SUM(NUCustoProduto * QTCompra)
        FROM
        compras 
        LEFT JOIN produtos 
        USING(IDProduto)
        INNER JOIN fornecedores USING(IDFornecedor)
        INNER JOIN filiais as ff USING(IDFilial)
        INNER JOIN empresas as ef USING(IDEmpresa)
        WHERE $wheref AND DTReposicao LIKE '%$mesHoje%'
        ) as comprasMes,
        (SELECT 
          SUM(NUCustoTotal)
        FROM
        produtos
        INNER JOIN fornecedores USING(IDFornecedor)
        INNER JOIN filiais as lv USING(IDFilial)
        INNER JOIN empresas as ev USING(IDEmpresa)
        WHERE $wherev AND DATE_FORMAT(DTEntradaProduto,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') 
        ) as comprasMercadoriaHoje,
        (SELECT 
          SUM(NUCustoTotal)
        FROM
        produtos
        INNER JOIN fornecedores USING(IDFornecedor)
        INNER JOIN filiais as lv USING(IDFilial)
        INNER JOIN empresas as ev USING(IDEmpresa)
        WHERE $wherev AND DTEntradaProduto LIKE '%$mesHoje%'
        ) as comprasMercadoriaMes,
        (SELECT 
          SUM(NUCustoTotal)
        FROM
        produtos
        INNER JOIN fornecedores USING(IDFornecedor)
        INNER JOIN filiais as lv USING(IDFilial)
        INNER JOIN empresas as ev USING(IDEmpresa)
        WHERE $wherev 
        ) as comprasMercadoria
        FROM
            produtos 
        LEFT JOIN compras 
        USING(IDProduto)
        INNER JOIN fornecedores USING(IDFornecedor)
        INNER JOIN filiais USING(IDFilial)
        INNER JOIN empresas USING(IDEmpresa)
        WHERE $where");
        return mysqli_fetch_assoc($SQL);
    }

    //POCENTAGEM DE COMISSÕES DE VENDAS DE PRODUTOS
    public static function getComissoesVendas($dado){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' ";
            $wherev = " ev.IDEmpresa = '".$idimpresa."' AND lv.IDFilial = '".$_SESSION['login']['filial']."' ";
        }elseif($dado=="empresa"){
            $where = " IDEmpresa = '".$idimpresa."' ";
            $wheref = " ef.IDEmpresa = '".$idimpresa."' ";
            $wherev = " ev.IDEmpresa = '".$idimpresa."' ";
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$dado."' ";
            $wherev = " ev.IDEmpresa = '".$idimpresa."' AND lv.IDFilial = '".$dado."' ";
        }

        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        SUM(VLVenda) as totalVendas,
        (
        SELECT 
            SUM(NUPorcentagem)
            FROM comissoes
            INNER JOIN comissionados USING(IDComissao)
            INNER JOIN filiais as ff USING(IDFilial)
            INNER JOIN empresas as ef USING(IDEmpresa)
        WHERE $wheref
        ) as sumPorcentagem
        FROM vendas
        INNER JOIN filiais USING(IDFilial)
        INNER JOIN empresas USING(IDEmpresa)
        WHERE IDColaborador IN(
            SELECT 
                IDColaborador 
            FROM comissionados
            INNER JOIN comissoes com USING(IDComissao)
            INNER JOIN filiais lv USING(IDFilial)
            INNER JOIN empresas ev USING(IDEmpresa)
            WHERE $wherev
        ) AND $where");
        return mysqli_fetch_assoc($SQL);
    }
    //COMISSOES SERVIÇOS
    public static function getComissoesServicos($dado){
        if(isset($_SESSION['login']['empresa'])){
            $idimpresa = $_SESSION['login']['empresa'];
        }else{
            $idimpresa = 0;
        }
        if($dado=="filial"){
            $where = " IDEmpresa = '".$_SESSION['login']['empresa']."' AND filiais.IDFilial = '".$_SESSION['login']['filial']."' "; 
            $wheref = " ef.IDEmpresa = '".$_SESSION['login']['empresa']."' AND ff.IDFilial = '".$_SESSION['login']['filial']."' ";
        }elseif($dado=="empresa"){
            $where = " IDEmpresa = '".$idimpresa."' ";
            $wheref = " ef.IDEmpresa = '".$idimpresa."' ";
        }else{
            $where = " IDEmpresa = '".$idimpresa."' AND filiais.IDFilial = '".$dado."' "; 
            $wheref = " ef.IDEmpresa = '".$idimpresa."' AND ff.IDFilial = '".$dado."' ";
        }
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
            CASE WHEN NUValorProduto IS NOT NULL THEN
                CASE WHEN pagamentos.QTDesconto > 0 THEN
                    CASE WHEN pagamentos.TPDesconto = '%' THEN
                        SUM(VLBase) + SUM(VLvenda) - (pagamentos.QTDesconto*SUM(VLBase) + SUM(VLVenda))/100
                    ELSE
                        SUM(VLBase) + SUM(VLVenda) - pagamentos.QTDesconto
                    END
                ELSE
                    SUM(VLVenda) + SUM(VLBase)
                END
            ELSE
                CASE WHEN pagamentos.QTDesconto > 0 THEN
                    CASE WHEN pagamentos.TPDesconto = '%' THEN
                        SUM(VLBase) - (pagamentos.QTDesconto*SUM(VLBase) + SUM(VLVenda))/100
                    ELSE
                        SUM(VLBase) - pagamentos.QTDesconto
                    END
                ELSE
                    SUM(VLBase)
                END
            END as totalServicos
        FROM ordemservico 
            LEFT JOIN custosordem USING(IDOrdem)
            LEFT JOIN pagamentos USING(IDPagamento)
            LEFT JOIN produtos USING(IDProduto) 
            LEFT JOIN servicos USING(IDServico)
            LEFT JOIN filiais ON(servicos.IDFilial = filiais.IDFilial)
            LEFT JOIN empresas USING(IDEmpresa) 
            LEFT JOIN vendas USING(IDProduto)
            LEFT JOIN promocoes USING(IDPromocao)
            LEFT JOIN promocionais USING(IDProduto)
        WHERE STServico = 1 AND ordemservico.IDColaborador IN(
        SELECT 
            IDColaborador 
        FROM comissionados
            INNER JOIN comissoes com USING(IDComissao)
            INNER JOIN filiais ff USING(IDFilial)
            INNER JOIN empresas ef USING(IDEmpresa)
            WHERE $wheref
        ) AND IDEmpresa = $where ");
        return mysqli_fetch_assoc($SQL);
    }
    //LISTA DAS FILIAIS COM LUCROS
    public static function getFiliaisLucro(){
        //$arrEmpresas = array();
        foreach(Contratos::getFiliais($_SESSION['login']['empresa']) as $e){
            //
            $relatoriosvendas = Relatorios::getVendas($e['IDFilial'],"","");
            $relatoriosservicos = Relatorios::getServicos($e['IDFilial'],"","");
            $relatorioscolaboradores = Relatorios::getColaboradores($e['IDFilial']);
            $relatoriosdespesas = Relatorios::getDespesas($e['IDFilial']);
            $relatoriosreps = Relatorios::getReposicoes($e['IDFilial'],"","");
            $relatorioscomissoesvendas= Relatorios::getComissoesVendas($e['IDFilial']);
            $relatoriosComissoesServicos= Relatorios::getComissoesServicos($e['IDFilial']);
            //
            $arrEmpresas[] = array(
                "Nome" => $e['NMFilial'],
                "faturamentoTotal" => $relatoriosreps['comprasMercadoria'],
                "lucroTotal" => $relatoriosservicos['lucroservicos_total'] + $relatoriosvendas['lucrovendastotal'],
                "faturamentoVendas" => $relatoriosvendas['faturamentovendastotal'],
                "faturamentoServicos" => $relatoriosservicos['faturamentoservicos_total'],
                "lucroServicos" => $relatoriosservicos['lucroservicos_total'],
                "lucroVendas" => $relatoriosvendas['lucrovendastotal']
            );
        }
        return $arrEmpresas;
    }
    //LISTA DE FILIAIS LUCRO POR TEMPO
    public static function getEmpresaLucroTempo($area,$tipo,$quanto){
        
        $tempos = array();
        if($tipo == "M"){
            for ($i = 0; $i <= $quanto; $i++) {
                $tempos[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
            }
        }else{
            for ($i = 0; $i <= $quanto; $i++) {
                $tempos[] = date("Y-m-d", strtotime( date( 'Y-m-d' )." -$i days"));
            }
        }

        foreach($tempos as $t){
            $relatoriosvendas = Relatorios::getVendas($area,$t,$tipo);
            $relatoriosservicos = Relatorios::getServicos($area,$t,$tipo);
            $relatoriosreps = Relatorios::getReposicoes($area,$t,$tipo);
            //
            $arrEmpresas[] = array(
                "tempo" => ($tipo == "M")? FRGeral::data($t,'m/Y') : FRGeral::data($t,'d/m'),
                "lucroTotal" => $relatoriosservicos['lucroservicos_total'] + $relatoriosvendas['lucrovendastotal'],
                "faturamentoTotal" => $relatoriosreps['comprasMercadoria']
            );
        }
        return $arrEmpresas;
    }
}
//CLASSE DE PRODUTOS
class Produtos{
    /** RETORNA LISTA DE PRODUTOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function sincronizaProdutos($id,$estoque){
        return mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET NUEstoqueProduto = '$estoque' WHERE IDProduto = '$id' ");
    }
    /** RETORNA LISTA DE PRODUTOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarProdutos($IDFilial){
        //
        $SQL = "SELECT 
        p.*,
        f.IDFilial,
        f.IDFornecedor,
        CASE WHEN p.IDProduto = promoc.IDProduto THEN
            promo.IDPromocao
        ELSE
            0
        END as IDPromocao
        FROM produtos p 
        INNER JOIN fornecedores f USING(IDFornecedor) 
        INNER JOIN categorias c USING (IDCategoria)
        LEFT JOIN promocionais as promoc USING(IDProduto)
        LEFT JOIN promocoes as promo USING(IDPromocao) 
        LEFT JOIN compras USING(IDProduto) 
        WHERE f.IDFilial = $IDFilial AND STInsumo = 0 AND p.STDelete IS NULL GROUP BY p.IDProduto";
        //
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }

    /** RETORNA RETORNA UM PRODUTO ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */

    public function listarProduto($IDProduto){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM produtos WHERE IDProduto = '$IDProduto' ");
        return $v_SQL;
    }

    /** EXCLUI UM PRODUTO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */

    public function excluirProduto($IDProduto){
        if(Vendas::confereVenda($IDProduto)){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET STDelete = 1 WHERE IDProduto = '$IDProduto' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM produtos WHERE IDProduto = '$IDProduto' ");
            
        }
       
        return $v_SQL;
    }
    
    public static function getCategorias($filial){
        return mysqli_query(FRController::conectarDatabase(),"SELECT * FROM categorias WHERE IDFilial = $filial");
    }

    public function setCompra($dados){
        extract($dados);
        return mysqli_query(FRController::conectarDatabase(),"INSERT INTO compras (IDProduto,QTCompra) VALUES ($Produto,$Quantidade)") && mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET NUCustoTotal = NUCustoTotal + $Custo WHERE IDProduto = $Produto");
    }

    public function getCompras($IDProduto){
        return mysqli_query(FRController::conectarDatabase(),"SELECT c.QTCompra,DATE_FORMAT(c.DTReposicao,'%d/%m/%Y %H:%i:%s') as DTRep,p.NUCustoProduto * c.QTCompra as NUCustoReposicao FROM compras c INNER JOIN produtos p USING(IDProduto) WHERE p.IDProduto = $IDProduto");
    }


    /** SALVA UM PRODUTO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarProduto($dados){
        extract($dados);
        $filial = $_SESSION['login']['filial'];
        $garantiaProduto = json_encode(array(
            "Tempo" => $garantia,
            "Quantidade" => $qtGarantia
        ));

        if($IDProduto){
            $v_SQL = "UPDATE produtos SET
            NMProduto = '$nome',
            NUEstoqueProduto = $estoque,
            NUEstoqueMinimo = $estoqueMinimo,
            NUCustoProduto = $custo,
            NUValorProduto = $valor,
            DSImagemProduto = '$imagem',
            NULucroProduto = '$lucro',
            DSGarantiaProduto = '$garantiaProduto',
            DTValidadeProduto = ".($validade==NULL || empty($validade) ? "NULL" : "'$validade'")."
            WHERE IDProduto = '$IDProduto' 
            ";
        }else{
            $catSql = mysqli_query(FRController::conectarDatabase(),"SELECT IDCategoria FROM categorias WHERE DSCategoria = '$categoria' ");
            $catSqlAssoc = mysqli_fetch_assoc($catSql);
            if($catSqlAssoc){
                $categoriaId = $catSqlAssoc['IDCategoria'];
            }else{
                $catInsert = mysqli_query(FRController::conectarDatabase(),"INSERT INTO categorias (DSCategoria,IDFilial) VALUES ('$categoria','$filial') ");
                if($catInsert){
                    $catSqlNew = mysqli_query(FRController::conectarDatabase(),"SELECT IDCategoria FROM categorias WHERE DSCategoria = '$categoria' ");
                    $catSqlAssocNew = mysqli_fetch_assoc($catSqlNew);
                    if($catSqlAssocNew){
                        $categoriaId = $catSqlAssocNew['IDCategoria'];
                    }
                }
            }

            $custototal = $custo*$estoque;

            $v_SQL = "INSERT INTO produtos (
                IDFornecedor,
                IDCategoria,
                NMProduto,
                NUEstoqueProduto,
                DSUnidadeProduto,
                DTValidadeProduto,
                NUCustoProduto,
                NUValorProduto,
                DSImagemProduto,
                DSCodigoProduto,
                NULucroProduto,
                DSGarantiaProduto,
                STInsumo,
                TPIdentificacao,
                NUEstoqueMinimo,
                NUCustoTotal
            )
            VALUES (
                '$fornecedor',
                '$categoriaId',
                '$nome',
                '$estoque',
                '$tipo',
                ".($validade==NULL ? "NULL" : "'$validade'").",
                '$custo',
                '$valor',
                '$imagem',
                '$codigo',
                '$lucro',
                '$garantiaProduto',
                '$insumo',
                '$identificacao',
                '$estoqueMinimo',
                '$custototal'
            )";
        }
        return mysqli_query(FRController::conectarDatabase(),$v_SQL);
    }
}
//CLASSE DE SERVICOS
Class Servicos{
    //CANCELA ORDEM
    public static function cancelaOrdem($dados){
        extract($dados);
        $aidi = implode(",",mysqli_fetch_assoc(mysqli_query(FRController::conectarDatabase(),"SELECT IDProduto FROM vendas WHERE IDOrdem = $ID")));
        mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET NUEstoqueProduto = produtos.NUEstoqueProduto + 1 WHERE produtos.IDProduto = $aidi");
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM vendas WHERE IDOrdem = $ID");
        return mysqli_query(FRController::conectarDatabase(),"UPDATE ordemservico SET STServico = 0 WHERE IDOrdem = $ID");
    }
    //MOSTRA A LISTA DE SERVIÇOS
    public static function getListaServicos($IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        ordemservico.IDColaborador as idcol,
        ordemservico.IDOrdem as idord,
        NMCliente,
        NMPagamento,
        QTDesconto,
        TPDesconto,
        NUCustoProduto,
        NUUnidadesVendidas,
        VLVenda,
        VLBase,
        DTServico,
        NMColaborador,
        CASE WHEN pagamentos.QTDesconto > 0 THEN
            CASE WHEN pagamentos.TPDesconto = '%' THEN
                    VLBase - (pagamentos.QTDesconto*VLBase)/100
            ELSE
                    VLBase - pagamentos.QTDesconto
                END
            ELSE
                VLBase
        END as mobra,
        NMFilial,
        DSTipoServico,
        (SELECT
        SUM(VLVenda)
        FROM vendas
        LEFT JOIN produtos ON(produtos.IDProduto = vendas.IDProduto)
        WHERE IDColaborador IN(idcol) AND STInsumo = 1) as insumos
        FROM ordemservico
        LEFT JOIN custosordem cu ON(cu.IDOrdem = ordemservico.IDOrdem)
        LEFT JOIN colaboradores ON(colaboradores.IDColaborador = ordemservico.IDColaborador)
        LEFT JOIN pagamentos USING(IDPagamento)
        LEFT JOIN vendas vn ON(vn.IDProduto = cu.IDProduto)
        LEFT JOIN produtos pr ON(pr.IDProduto = vn.IDProduto)
        LEFT JOIN servicos USING(IDServico)
        LEFT JOIN clientes ON(ordemservico.IDCliente = clientes.IDCliente)
        LEFT JOIN filiais ON(servicos.IDFilial = filiais.IDFilial)
        WHERE servicos.IDFilial = $IDFilial AND STServico = 1 GROUP BY idord
        ");
        return $SQL;
    }
    //CONFERE SE TEM ORDENS DE SERVIÇO NESSE SERVIÇO
    public static function confereOrdem($IDServico){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM ordemservico WHERE IDServico = $IDServico");
        return mysqli_fetch_assoc($SQL);
    }
    //INSUMOS
    public static function getInsumos($IDFilial){
        $SQL = "SELECT * FROM produtos p INNER JOIN fornecedores f USING(IDFornecedor) INNER JOIN categorias c USING (IDCategoria) LEFT JOIN compras USING(IDProduto) WHERE f.IDFilial = $IDFilial AND p.STInsumo = 1 AND p.STDelete IS NULL GROUP BY p.IDProduto ";
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
    //ORDENS DE SERVICO
    public static function getOrdens($IDFilial){
        return mysqli_query(FRController::conectarDatabase(),"SELECT
        s.DSTipoServico,
        cli.NUTelefoneCliente,
        cli.NMEmailCliente,
        cli.NMCliente,
        cli.IDCliente,
        o.IDColaborador,
        s.DSGarantiaServico,
        CASE WHEN o.IDColaborador = 0 THEN 'Você' ELSE c.NMColaborador END as NMColaborador,
        o.IDOrdem,
        o.DTSaida,
        o.DTServico,
        o.STServico
        FROM ordemservico o INNER JOIN servicos s USING(IDServico) LEFT JOIN colaboradores c USING(IDColaborador) INNER JOIN clientes cli USING(IDCliente) WHERE s.IDFilial = $IDFilial");
    }
    //SERVICOS
    public static function getServicos($IDFilial){
        return mysqli_query(FRController::conectarDatabase(),"SELECT * FROM servicos WHERE IDFilial = $IDFilial AND STDelete IS NULL");
    }
    public static function setCompra($dados){
        extract($dados);
        return mysqli_query(FRController::conectarDatabase(),"INSERT INTO compras (IDProduto,QTCompra) VALUES ($Insumo,$Quantidade)") && mysqli_query(FRController::conectarDatabase(),"UPDATE produtos SET NUCustoTotal = NUCustoTotal + $Custo");
    }
    //CRIA UM SERVIÇO
    public static function setServico($dados){
        extract($dados);
        $IDFilial = $_SESSION['login']['filial'];
        $garantiaJson = json_encode(array(
            "Tipo" => $tipoGarantia,
            "Tempo" => $tempoGarantia
        ));
        if($IDServico){
            $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE servicos SET 
                DSGarantiaServico = '$garantiaJson',
                VLBase = $valorBase WHERE IDServico = $IDServico
            ");
        }else{
            $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO servicos (VLBase,DSTipoServico,IDFilial,DSGarantiaServico) VALUES ('$valorBase','$tipoServico','$IDFilial','$garantiaJson')");
            
        }
        return $SQL;
    }
    //
    public static function getServico($IDServico){
        return mysqli_query(FRController::conectarDatabase(),"SELECT * FROM servicos WHERE IDServico = $IDServico");
    }
    //CRIA UMA ORDEM DE SERVIÇO
    public static function setOrdemServico($dados){
        extract($dados);
        $colaborador = Contratos::getColaboradorByUser($_SESSION['login']['dados']['id']);
        $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO ordemservico (IDServico,IDCliente,IDColaborador,DSOrdemServico,DSServico) VALUES ('$tipoOrdemServico','$nomeClienteServico','$colaborador','$previaServico','$descricaoServico')");
        return $SQL;
    }
    /** RETORNA LISTA DE CUSTOS
     * @type	function
     * @date	25/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getCustos($IDOrdem){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT pd.NMProduto,pd.IDProduto,co.NUQuantidade, CASE WHEN (SELECT COUNT(IDProduto) FROM
        custosordem 
        WHERE IDOrdem = $IDOrdem AND IDProduto = pd.IDProduto) > 0 THEN 1 ELSE 0 END as vinculo 
        FROM produtos pd LEFT JOIN custosordem co USING(IDProduto) LEFT JOIN fornecedores ON(pd.IDFornecedor = fornecedores.IDFornecedor) WHERE STInsumo = 1 AND NUEstoqueProduto > 0 AND IDFilial = '".$_SESSION['login']['filial']."' GROUP BY pd.IDProduto
         ");

        return $SQL;
    }

    public static function baixaServico($dados){
        extract($dados);
        $baixa = "UPDATE ordemservico SET DSNota = '$nota', DTSaida = NOW(), STServico = 1,IDPagamento = $pagamento WHERE IDOrdem = $ordem";
        $getOrdem = SELF::getOrdem(array(
            "Tipo"=>"saida",
            "IDFilial" => $_SESSION['login']['filial'],
            'IDOrdem' => $ordem
        ));
        //
        if(isset($getOrdem['maodeobra'])){
            $mobra = json_decode($getOrdem['maodeobra'],true);
            //GUARDA O PRODUTO 
            foreach($mobra as $m){
                $dadosProduto = Vendas::getDadosProduto($m['id']);
                $produto = array(
                    "IDProduto" => $m['id'],
                    "IDFornecedor" => $dadosProduto['IDFornecedor'],
                    "IDPromocao" => $dadosProduto['IDPromocao'],
                    "IDCliente" => $cliente,
                    "IDColaborador" => $colaborador,
                    "IDCaixa" => 0,
                    "NUUnidadesVendidas" => $m['quantidade'],
                    "IDFilial" => $_SESSION['login']['filial'],
                    "IDPagamento" => $pagamento,
                    'VLVenda' => $m['quantidade'] * FRGeral::trataEnvioVenda(Promocoes::confProdutoPromocional($m['id'],$m['valor'],$_SESSION['login']['filial'])),
                    'CDVenda' => "",
                    'IDOrdem' => $ordem
                );
                Vendas::setVenda($produto);
            }
        }
        return mysqli_query(FRController::conectarDatabase(),$baixa);
    }

    /** VINCULA MÃO DE OBRA COM MATERIA PRIMA
     * @type	function
     * @date	25/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function setCusto($dados){
        extract($dados);
        $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO custosordem (IDOrdem,IDProduto,NUQuantidade) VALUES ('$IDOrdem','$IDProduto','$NUQuantidade')");
        return $SQL;
    }

    /** APAGA OS CUSTOS COM MATERIA PRIMA
     * @type	function
     * @date	25/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function delCusto($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM custosordem WHERE IDOrdem = $ID");
        return $SQL;
    }
    //APAGA O SERVIÇO
    public static function delServico($ID){
        if(SELF::confereOrdem($ID)){
            $SQL = "UPDATE servicos SET STDelete = 1 WHERE IDServico = $ID ";
        }else{
            $SQL = "DELETE FROM servicos WHERE IDServico = $ID";
        }
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
    //APAGA A ORDEM DE SERVIÇO
    public static function delOrdemServico($ID){
        $SQL = "DELETE FROM ordemservico WHERE IDOrdem = $ID";
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
    //ORDEM DE SERVIÇO
    public static function getOrdem($dados){
      extract($dados);
      if($Tipo == "entrada"){
        $SQL = "
        SELECT 
          e.NMRazaoEmpresa as empresa,
          f.DSEnderecoJSON as endereco,
          c.NMCliente as cliente,
          f.NMFilial as filial,
          s.DSTipoServico as servico,
          os.DSOrdemServico as previa,
          os.DSServico as descricao,
          CASE WHEN os.IDColaborador = 0 THEN e.NMRazaoEmpresa ELSE col.NMColaborador END as atendente,
          os.IDOrdem as codigo,
          e.NUCnpjEmpresa as cnpj,
          os.DTServico as dataHora 
          FROM empresas e
          INNER JOIN filiais f USING(IDEmpresa)
          INNER JOIN clientes c USING(IDFilial)
          INNER JOIN ordemservico os USING(IDCliente)
          LEFT JOIN colaboradores as col USING(IDColaborador)
          INNER JOIN servicos s USING(IDServico)
          WHERE f.IDFilial = $IDFilial AND os.IDOrdem = $IDOrdem
        ";
      }else{
        $SQL = <<<SQL
            SELECT 
            e.NMRazaoEmpresa as empresa,
            f.DSEnderecoJSON as endereco,
            c.NMCliente as cliente,
            f.NMFilial as filial,
            s.DSTipoServico as servico,
            os.DSOrdemServico as previa,
            os.DSServico as descricao,
            col.NMColaborador as atendente,
            os.IDOrdem as codigo,
            os.DTSaida saida,
            os.DSNota mensagem,
            os.DTServico as dataHora,
            pag.QTParcelas as parcelas,
            pag.NUJuros as juros,
            pag.DSMetodo as metodo,
            (SELECT
            CONCAT('[',
                GROUP_CONCAT(
                '{'
                ,'"produto":"',prod.NMProduto,'"'
                ,',"valor":"',prod.NUValorProduto,'"'
                ,',"quantidade":"',custos.NUQuantidade,'"'
                ,',"id":"',prod.IDProduto,'"'
                ,'}' 
            SEPARATOR ','),
        ']')
        FROM custosordem custos INNER JOIN produtos prod USING(IDProduto) LEFT JOIN promocionais k USING(IDProduto) LEFT JOIN promocoes y USING(IDPromocao) WHERE custos.IDOrdem = $IDOrdem ) as maodeobra,
        e.NUCnpjEmpresa as cnpj,
        s.VLBase as mobra,
        pag.IDPagamento as id_pagamento
        FROM empresas e
        LEFT JOIN filiais f USING(IDEmpresa)
        LEFT JOIN clientes c USING(IDFilial)
        LEFT JOIN ordemservico os USING(IDCliente)
        LEFT JOIN colaboradores as col USING(IDColaborador)
        LEFT JOIN servicos s USING(IDServico)
        LEFT JOIN custosordem cst USING(IDOrdem)
        LEFT JOIN produtos prv USING(IDProduto)
        LEFT JOIN pagamentos pag USING(IDPagamento)
        WHERE f.IDFilial = $IDFilial AND os.IDOrdem = $IDOrdem
        SQL;
      }
      $retorno = mysqli_query(FRController::conectarDatabase(),$SQL);
      return mysqli_fetch_assoc($retorno);
    }
}
//CLASSE DE PONTOS DE VENDAS
class Pontos{

    public static function getVendas($IDCaixa){
        $SQL = <<<SQL
            SELECT
            CASE WHEN cupons.IDCliente = 0 THEN "Cliente não identificado" ELSE clientes.NMCliente END AS cliente,
            cupons.ANCupom
            FROM cupons LEFT JOIN clientes USING(IDCliente) WHERE IDCaixa = $IDCaixa
        SQL;
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }

    /** RETORNA LISTA DE PONTOS DE VENDA(CAIXAS)
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarPontos($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        c.*,
        CASE WHEN c.IDCaixa = ven.IDCaixa THEN
            CASE WHEN STCaixa = 0 THEN
                (SELECT SUM(VLVenda)
                FROM caixa
                LEFT JOIN vendas v USING(IDCaixa)
                WHERE caixa.IDFilial = $IDFilial 
                AND DTVenda > DTAberturaCaixa AND DTVenda < DTFechamentoCaixa)
            ELSE
                (SELECT SUM(VLVenda)
                FROM caixa
                LEFT JOIN vendas v USING(IDCaixa)
                WHERE caixa.IDFilial = $IDFilial 
                AND DTVenda > DTAberturaCaixa AND DTVenda < NOW())
            END
        ELSE
            0
        END as vendas
        FROM caixa c 
        LEFT JOIN vendas ven USING(IDCaixa)
        WHERE c.IDFilial = $IDFilial AND STDelete IS NULL GROUP BY c.IDCaixa ");
        return $v_SQL;
    }

    /** RETORNA UM CAIXA ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarPonto($IDCaixa){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM caixa WHERE IDCaixa = '$IDCaixa' ");
        return $v_SQL;
    }

    public static function confereVendaPonto($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM vendas WHERE IDCaixa = $ID");
        return mysqli_fetch_assoc($SQL);
    }

    /** EXCLUI UM CAIXA ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function excluirPonto($IDCaixa){
        if(SELF::confereVendaPonto($IDCaixa)){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE caixa SET STDelete = 1 WHERE IDCaixa = $IDCaixa");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM caixa WHERE IDCaixa = $IDCaixa ");
        }
        return $v_SQL;
    }

    /** SALVA UM CAIXA ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarPonto($dados){
        extract($dados);
        if($IDCaixa){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE caixa SET
            NMPdv = '$nomePdv',
            NMSenhaPDV = '$senhaPdv'
            WHERE IDCaixa = '$IDCaixa' 
            ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO caixa (
                IDFilial,
                NMPdv,
                NMSenhaPDV
            )
            VALUES (
                '".$_SESSION['login']['filial']."',
                '$nomePdv',
                '$senhaPdv'
            )
            ");
        }

        return $v_SQL;

    }
}
//CLASSE DE FORNECEDORES
class Fornecedores{


    /** RETORNA LISTA DE FORNECEDORES
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarFornecedores($IDFilial){
        // $v_IDUSER = $_SESSION["idUser"];
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM fornecedores WHERE IDFilial = '$IDFilial' AND STDelete IS NULL ");
        return $v_SQL;
    }

    /** EXCLUI UM FORNECEDOR
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
     public static function excluirFornecedor($ID,$confirmacao){
        $SQL1 = mysqli_query(FRController::conectarDatabase(),"SELECT IDProduto FROM produtos WHERE IDFornecedor = '$ID' AND NUEstoqueProduto > 0 ");
        $SQL2 = mysqli_query(FRController::conectarDatabase(),"SELECT IDFornecedor FROM vendas WHERE IDFornecedor = '$ID' ");
        
        if(mysqli_num_rows($SQL1) > 0){
            $retorno['erro'] = true;
            $retorno['mensagem'] = "Você não pode excluir esse fornecedor, pois nele ha produtos em estoque.";
        }else{
            $retorno['mensagem'] = "Deseja excluir esse fornecedor?";
            $retorno['erro'] = false;
            if($confirmacao == 1){
                if(mysqli_fetch_assoc($SQL2)){
                    mysqli_query(FRController::conectarDatabase(),"UPDATE fornecedores SET STDelete = 1 WHERE IDFornecedor = $ID");
                }else{
                    mysqli_query(FRController::conectarDatabase(),"DELETE FROM fornecedores WHERE IDFornecedor = $ID");
                }
            }
        }
        return json_encode($retorno);
    }


    /** RETORNA LISTA DE FORNECEDORES
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarFornecedor($IDFornecedor){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM fornecedores WHERE IDFornecedor = '$IDFornecedor' ");
        return $v_SQL;
    }
    
    /** SALVAR FORNECEDOR
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarFornecedor($dados){
        $IDFornecedor =  $dados['IDFornecedor'];
        $IDFilial = $_SESSION['login']['filial'];
        $nomeFornecedor = $dados['nomeFornecedor'];
        $emailFornecedor = $dados['emailFornecedor'];
        $telefoneFornecedor =  $dados["telefoneFornecedor"];
        $cepFornecedor = $dados["cepFornecedor"];
        $ufFornecedor = $dados['ufFornecedor'];
        $cidadeFornecedor = $dados['cidadeFornecedor'];
        $bairroFornecedor =  $dados["bairroFornecedor"];
        $ruaFornecedor = $dados["ruaFornecedor"];
        $numeroFornecedor = $dados['numeroFornecedor'];
        $complementoFornecedor = $dados['complementoFornecedor'];
        $endArr = array(
            "cep" => $cepFornecedor,
            "uf" => $ufFornecedor,
            "cidade" => $cidadeFornecedor,
            "bairro" => $bairroFornecedor,
            "rua" => $ruaFornecedor,
            "numero" => $numeroFornecedor,
            "complemento" => $complementoFornecedor
        );
        $endFornecedor = stripslashes(json_encode($endArr,JSON_UNESCAPED_UNICODE));
        if($IDFornecedor){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE fornecedores SET
            NMFornecedor = '$nomeFornecedor',
            DSEmailFornecedor = '$emailFornecedor',
            DSTelefoneFornecedor = '$telefoneFornecedor',
            DSEndFornecedor = '$endFornecedor'
            WHERE IDFornecedor = '$IDFornecedor' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO fornecedores (
                NMFornecedor,
                DSEmailFornecedor,
                DSTelefoneFornecedor,
                DSEndFornecedor,
                IDFilial
                ) 
                VALUES (
                '$nomeFornecedor',
                '$emailFornecedor',
                '$telefoneFornecedor',
                '$endFornecedor',
                '$IDFilial'
                ) 
                ");
        }
        return $v_SQL;
    }

}
//CLASSE DE CLIENTES
class Clientes{

    public static function getServicosCliente($ID){
        $SQL = <<<SQL
            SELECT 
            e.NMRazaoEmpresa as empresa,
            f.DSEnderecoJSON as endereco,
            c.NMCliente as cliente,
            f.NMFilial as filial,
            s.DSTipoServico as servico,
            os.DSOrdemServico as previa,
            os.DSServico as descricao,
            col.NMColaborador as atendente,
            os.IDOrdem as codigo,
            os.DTSaida saida,
            os.DSNota mensagem,
            os.DTServico as dataHora,
            pag.QTParcelas as parcelas,
            pag.NUJuros as juros,
            pag.DSMetodo as metodo,
            (SELECT
            CONCAT('[',
                GROUP_CONCAT(
                '{'
                ,'"produto":"',prod.NMProduto,'"'
                ,',"valor":"',prod.NUValorProduto,'"'
                ,',"quantidade":"',custos.NUQuantidade,'"'
                ,',"id":"',prod.IDProduto,'"'
                ,'}' 
            SEPARATOR ','),
        ']')
        FROM custosordem custos INNER JOIN produtos prod USING(IDProduto) LEFT JOIN promocionais k USING(IDProduto) LEFT JOIN promocoes y USING(IDPromocao) WHERE custos.IDOrdem = os.IDOrdem ) as maodeobra,
        e.NUCnpjEmpresa as cnpj,
        s.VLBase as mobra,
        pag.IDPagamento as id_pagamento
        FROM empresas e
        LEFT JOIN filiais f USING(IDEmpresa)
        LEFT JOIN clientes c USING(IDFilial)
        LEFT JOIN ordemservico os USING(IDCliente)
        LEFT JOIN colaboradores as col USING(IDColaborador)
        LEFT JOIN servicos s USING(IDServico)
        LEFT JOIN custosordem cst USING(IDOrdem)
        LEFT JOIN produtos prv USING(IDProduto)
        LEFT JOIN pagamentos pag USING(IDPagamento)
        WHERE os.IDCliente = $ID AND os.STServico = 1
        SQL;
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }
    public static function sincronizaCliente($dados){
        extract($dados);
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM clientes WHERE NUCpfCliente = '$NUCpfCliente' ");
        $cli = mysqli_fetch_assoc($SQL);
        if(!$cli){
            mysqli_query(FRController::conectarDatabase(),"INSERT INTO clientes (NMCliente,NMEmailCliente,NUTelefoneCliente,NUCpfCliente,IDFilial) VALUES('$NMCliente','$NMEmailCliente','$NUTelefoneCliente','$NUCpfCliente','$IDFilial')");
        }
    }

    public static function getCompras($IDCliente){
        $SQL = <<<SQL
            SELECT
            NMCliente,
            cupons.ANCupom
            FROM cupons LEFT JOIN clientes USING(IDCliente) WHERE IDCliente = $IDCliente
        SQL;
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }

    /** RETORNA OS DADOS DE CLIENTES PENDENTES OU NÃO
     * 
     * 
     * @type	function
     * @date	31/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getPendencias($IDCliente){
        $SQL1 = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM devedores WHERE IDCliente = $IDCliente ");
        $divida = mysqli_fetch_assoc($SQL1);
        if($divida){
            $dividadocliente = FRGeral::trataValor($divida['VLDivida'],0);
            echo "<h3 align='center'>Esse cliente tem uma divida de R$ $dividadocliente</h3>";
        }else{
            echo "<h3 align='center'>Não tem nenhuma notificação sobre esse cliente!</h3>";
        }
    }

    /** RETORNA LISTA DE CLIENTES
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarClientes($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        cli.*,
        CASE WHEN cli.IDCliente = devedores.IDCliente THEN
            devedores.VLDivida
        ELSE
            0
        END as divida
        FROM 
        clientes cli
        LEFT JOIN devedores USING(IDCliente) 
        WHERE IDFilial = '$IDFilial' ");
        return $v_SQL;
    }

    /** RETORNA LISTA DE CLIENTES DEVEDORES
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarDevedores($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT devedores.*,clientes.*,DATE_FORMAT(DTInicioDivida,'%d/%m/%Y %H:%i') as DTInicioDivida FROM devedores INNER JOIN clientes USING(IDCliente) WHERE IDFIlial = '$IDFilial' ");
        return $v_SQL;
    }

    /** SELECT DEVEDOR
     * 
     * 
     * @type	function
     * @date	19/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getSelectDevedores($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        clientes.NMCliente,clientes.IDCliente
        FROM clientes WHERE 
        IDFilial = '$IDFilial' 
        AND IDCliente NOT IN(
            SELECT IDCliente FROM crediarios INNER JOIN clientes USING(IDCliente) WHERE IDCliente = clientes.IDCliente AND IDFilial = '$IDFilial') AND 
            IDCliente NOT IN(
                SELECT IDCliente FROM devedores INNER JOIN clientes USING(IDCliente) WHERE IDCliente = clientes.IDCliente AND IDFilial = '$IDFilial'
                ) 
        ");
        return $v_SQL;
    }

    /** SELECT CREDIARIO
     * 
     * 
     * @type	function
     * @date	19/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getSelectCrediarios($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT 
        clientes.NMCliente,clientes.IDCliente FROM clientes WHERE 
        IDFilial = '$IDFilial' 
        AND IDCliente NOT IN(
            SELECT IDCliente FROM devedores INNER JOIN clientes USING(IDCliente) WHERE IDCliente = clientes.IDCliente AND IDFilial = '$IDFilial') 
            AND IDCliente NOT IN (
                SELECT IDCliente FROM crediarios WHERE IDCliente = clientes.IDCliente AND IDFilial = '$IDFilial'
                ) 
        ");
        return $v_SQL;
    }

    /** RETORNA LISTA DE CLIENTES COM CREDITO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarCrediarios($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT crediarios.*,DATE_FORMAT(DTInicioCredito,'%d/%m/%Y %H:%i') as DTInicioCredito,DATE_FORMAT(DTTerminoCredito,'%d/%m/%Y %H:%i') as DTTerminoCredito,clientes.* FROM crediarios INNER JOIN clientes USING(IDCliente) WHERE IDFilial = $IDFilial ");
        return $v_SQL;
    }

    /** RETORNA LISTA DE CLIENTES
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarCliente($IDCliente){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM clientes WHERE IDCliente = '$IDCliente' ");
        return $v_SQL;
    }

    /** RETORNA UM CLIENTE ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarDevedor($IDDevedor){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT devedores.*,clientes.* FROM devedores INNER JOIN clientes USING(IDCliente) WHERE IDDevedor = '$IDDevedor' ");
        return $v_SQL;
    }

    /** RETORNA UM CLIENTE COM CREDITO ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarCrediario($IDCrediario){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT crediarios.*,clientes.* FROM crediarios INNER JOIN clientes USING(IDCliente) WHERE IDCrediario = '$IDCrediario' ");
        return $v_SQL;
    }

    /** EXCLUI UM CLIENTE ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */

    public function excluirCliente($IDCliente,$confirma){
        $SQL1 = mysqli_query(FRController::conectarDatabase(),"SELECT IDDevedor FROM devedores WHERE IDCliente = '$IDCliente' ");
        $SQL2 = mysqli_query(FRController::conectarDatabase(),"SELECT IDCrediario FROM crediarios WHERE IDCliente = '$IDCliente' ");
        //
        $SQL3 = mysqli_fetch_assoc($SQL1);
        $SQL4 = mysqli_fetch_assoc($SQL2);
        if($confirma == 0){
            if($SQL3){
                $retorno['podeExcluir'] = false;
                $retorno['msg'] = "Você não pode excluir esse cliente pois ele tem uma dívida";
            }elseif($SQL4){
                $retorno['podeExcluir'] = false;
                $retorno['msg'] = "Você não pode excluir esse cliente pois ele tem créditos";
            }else{
                $retorno['podeExcluir'] = true;
                //mysqli_query(FRController::conectarDatabase(),"DELETE FROM clientes WHERE IDCliente = '$IDCliente' ");
            }
        }else{
            $retorno['podeExcluir'] = true;
            mysqli_query(FRController::conectarDatabase(),"DELETE FROM clientes WHERE IDCliente = '$IDCliente' ");
        }
        
        return json_encode($retorno);
    }

    /** RETORNA EXCLUI UM CLIENTE CREDIARIO ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function excluirCrediario($IDCrediario){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM crediarios WHERE IDCrediario = '$IDCrediario'  ");
        return $v_SQL;
    }

    /** EXCLUI UM DEVEDOR ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */

    public function excluirDevedor($IDDevedor){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM devedores WHERE IDDevedor = '$IDDevedor' ");
        return $v_SQL;
    }


    /** SALVA UM CLIENTE ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarCliente($dados){
        if(isset($_SESSION['login']['filial'])){
            $filal = $_SESSION['login']['filial'];
        }else{
            $filal = $dados['filial'];
        }
        if($dados['IDCliente']){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE clientes SET
            NMCliente = '".$dados['nomeCliente']."',
            NMEmailCliente = '".$dados['emailCliente']."',
            NUTelefoneCliente = '".$dados['telefoneCliente']."'
            WHERE IDCliente = '".$dados['IDCliente']."' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO clientes (
                NMCliente,
                NMEmailCliente,
                NUTelefoneCliente,
                NUCpfCliente,
                IDFilial
                ) 
                VALUES (
                '".$dados['nomeCliente']."',
                '".$dados['emailCliente']."',
                '".$dados['telefoneCliente']."',
                '".$dados['cpfCliente']."',
                '".$filal."'
                ) 
                ");
        }
        return $v_SQL;
    }

    /** SALVA UM CREDIARIO ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarCrediario($dados){
        if($dados['IDCrediario']){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE crediarios SET
            NUCredito = '".$dados['creditoCrediario']."',
            DTTerminoCredito = '".$dados['creditoAte']."'
            WHERE IDCrediario = '".$dados['IDCrediario']."' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO crediarios (
                IDCliente,
                NUCredito,
                DTTerminoCredito
                ) 
                VALUES (
                '".$dados['nomeCrediario']."',
                '".$dados['creditoCrediario']."',
                '".$dados['creditoAte']."'
                ) 
                ");
        }
        return $v_SQL;
    }

    /** ADICIONA UM DEVEDOR
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarDevedor($dados){
        if($dados['IDDevedor']){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE devedores SET
            VLDivida = '".$dados['valorDivida']."'
            WHERE IDDevedor = '".$dados['IDDevedor']."' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO devedores (
                IDCliente,
                VLDivida
                ) 
                VALUES (
                '".$dados['nomeDevedor']."',
                '".$dados['valorDivida']."'
                ) 
                ");
        }
        return $v_SQL;
    }


}
//CLASSE DE PROMOÇÕES
class Promocoes{

    /** RETORNA LISTA DE PROMOCOES
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarPromocoes($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM promocoes WHERE IDFilial = '$IDFilial' AND STDelete IS NULL ");
        return $v_SQL;
    }

    /** RETORNA UMA PROMOCAO ESPECIFICA
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function listarPromocao($IDPromocao){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM promocoes WHERE IDPromocao = '$IDPromocao' ");
        return $v_SQL;
    }

    public static function confVendaPromo($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM vendas WHERE IDPromocao = $ID");
        return mysqli_fetch_assoc($SQL);
    }

    /** EXCLUI UMA PROMOCAO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function excluirPromocao($IDPromocao){
        if(SELF::confVendaPromo($IDPromocao)){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE promocoes SET STDelete = 1 WHERE IDPromocao = $IDPromocao ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM promocoes WHERE IDPromocao = '$IDPromocao' ") && SELF::delPromocional($IDPromocao);
        }
        return $v_SQL;
    }

    /** SALVA UMA PROMOCAO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarPromocao($dados){
        if($dados['tipoPromo'] == "%"){
            $NUDescontoPromo = intval($dados['descontoPromo']);
        }else{
            $NUDescontoPromo = FRGeral::trataValor($dados['descontoPromo'],1);
        }
        if($dados['IDPromocao']){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE promocoes SET
            NMPromo = '".$dados['nomePromo']."',
            DTInicioPromo = '".$dados['inicioPromo']."',
            DTTerminoPromo = '".$dados['fimPromo']."',
            NUDescontoPromo = '".$NUDescontoPromo."',
            TPDesconto = '".$dados['tipoPromo']."'
            WHERE IDPromocao = '".$dados['IDPromocao']."' 
            ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO promocoes (
                NMPromo,
                DTInicioPromo,
                DTTerminoPromo,
                NUDescontoPromo,
                TPDesconto,
                IDFilial
            )
            VALUES(
                '".$dados['nomePromo']."',
                '".$dados['inicioPromo']."',
                '".$dados['fimPromo']."',
                '".$NUDescontoPromo."',
                '".$dados['tipoPromo']."',
                '".$_SESSION['login']['filial']."'
            )
            ");
        }

        return $v_SQL;

    }
    /** RETORNA LISTA DE PRODUTOS PROMOCIONAIS OU NÃO
     * @type	function
     * @date	17/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getPromocional($IDPromocao){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT NMProduto,IDProduto, CASE WHEN (SELECT COUNT(IDProduto) FROM
        promocionais 
        WHERE IDPromocao = $IDPromocao AND IDProduto = produtos.IDProduto) > 0 THEN 1 ELSE 0 END as vinculo 
        FROM produtos LEFT JOIN fornecedores USING(IDFornecedor) 
        WHERE IDProduto NOT IN (SELECT IDProduto FROM promocionais WHERE IDPromocao != $IDPromocao) AND fornecedores.IDFilial = '".$_SESSION['login']['filial']."' ");
        return $SQL;

    }

    /** VINCULA PRODUTOS COM AS PROMOCOES
     * @type	function
     * @date	17/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function setPromocional($dados){
        $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO promocionais (IDPromocao,IDProduto) VALUES ('".$dados['IDPromocao']."','".$dados['IDProduto']."')");
        return $SQL;
    }

    /** APAGA OS PROMOCIONAIS DE UMA PROMOCAO
     * @type	function
     * @date	18/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function delPromocional($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM promocionais WHERE IDPromocao = $ID");
        return $SQL;
    }

    /** CONFERE SE OS PRODUTOS SAO PROMOCIONAIS OU NÃO
     * @type	function
     * @date	18/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function confProdutoPromocional($IDProduto,$valorProduto,$IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
            promocoes.NUDescontoPromo,
            promocoes.TPDesconto,
            promocoes.NMPromo
            FROM 
            promocoes
            INNER JOIN
            promocionais
            USING(IDPromocao)
            WHERE
            NOW() >= promocoes.DTInicioPromo AND NOW() <= promocoes.DTTerminoPromo
            AND
            promocoes.IDFilial = '$IDFilial'
            AND
            promocionais.IDProduto = $IDProduto
            GROUP BY promocoes.IDPromocao
        ");

        if(mysqli_num_rows($SQL) > 0){
            $desc = mysqli_fetch_assoc($SQL);
            if($desc['TPDesconto'] == '%'){
                $desconto = $valorProduto - ($desc['NUDescontoPromo']*$valorProduto)/100;
            }else{
                $desconto = $valorProduto - $desc['NUDescontoPromo'];
            }
        }else{
            $desconto = $valorProduto;
        }
        // return $SQL;
        return $desconto;
    }


}
//CLASSE DE COMISSOES
class Comissoes{
    public static function getComissoes($IDFilial){
        return mysqli_query(FRController::conectarDatabase(),"SELECT * FROM comissoes WHERE IDFilial = $IDFilial");
    }
    //
    public static function delComissao($IDComissao){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM comissoes WHERE IDComissao = '$IDComissao' ") && SELF::delComissionado($IDComissao);
        return $v_SQL;
    }
    //
    public static function setComissao($dados){
        extract($dados);
        $filial = $_SESSION['login']['filial'];
        if($IDComissao){
            $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE comissoes SET NMComissao = '$nomeComissao', NUPorcentagem = '$porcentagemComissao' WHERE IDComissao = '$IDComissao' ");
        }else{
            $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO comissoes (NMComissao,TPComissao,NUPorcentagem,IDFilial) VALUES ('$nomeComissao','$tipoComissao','$porcentagemComissao','$filial')");
        }
        return $SQL;
    }
    //
    public static function getComissao($IDComissao){
        return mysqli_query(FRController::conectarDatabase(),"SELECT * FROM comissoes WHERE IDComissao = $IDComissao");
    }
    //
    /** RETORNA LISTA DE COLABORADORES COMISSIONADOS OU NÃO
     * @type	function
     * @date	24/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getComissionados($IDComissao){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT NMColaborador,IDColaborador, CASE WHEN (SELECT COUNT(IDColaborador) FROM
        comissionados 
        WHERE IDComissao = $IDComissao AND IDColaborador = colaboradores.IDColaborador) > 0 THEN 1 ELSE 0 END as vinculo 
        FROM colaboradores 
        WHERE IDCOlaborador NOT IN (SELECT IDColaborador FROM comissionados WHERE IDComissao != $IDComissao) ");
        return $SQL;
    }

    /** VINCULA COLABORADORES A COMISSOES
     * @type	function
     * @date	24/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function setComissionado($dados){
        extract($dados);
        $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO comissionados (IDComissao,IDColaborador) VALUES ('$IDComissao','$IDColaborador')");
        return $SQL;
    }

    /** APAGA OS COMISSIONADOS
     * @type	function
     * @date	24/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function delComissionado($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM comissionados WHERE IDComissao = $ID");
        return $SQL;
    }
    
}
//CLASSE DE PAGAMENTOS
class Pagamentos{

    public static function getDadosParcelas($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT NUJuros,QTParcelas,DSMetodo FROM pagamentos INNER JOIN vendas USING(IDPagamento) INNER JOIN cupons USING(CDVenda) WHERE pagamentos.IDPagamento = $ID");
        return mysqli_fetch_assoc($SQL);
    }

    public static function getDadosParcelasPag($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT NUJuros,QTParcelas,DSMetodo FROM pagamentos WHERE IDPagamento = $ID");
        return mysqli_fetch_assoc($SQL);
    }

    public static function jurosParcelas($valor,$parcelas,$juros){
        $x = $valor/$parcelas;
        $y = $x + ($juros/100)*$x;
        $z = array(
            "parcelas" => $parcelas,
            "valorParcela" => $y,
            "valorFinal" => $y*$parcelas
        );
        return $z;
    }

    public static function taxaMaquininha($valor,$taxa){
        $x = $valor + ($taxa/100)*$valor;
        return $x;
    }

    
    /** RETORNA LISTA DE PAGAMENTOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarPagamentos($IDFilial){
        // $v_IDUSER = $_SESSION["idUser"];
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM pagamentos WHERE IDFilial= '$IDFilial' AND STDelete IS NULL ");
        return $v_SQL;
    }

    public static function confVendaPagamento($ID){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM vendas WHERE IDPagamento = $ID");
        return mysqli_fetch_assoc($SQL);
    }

    /** EXCLUI UM PAGAMENTO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function excluirPagamento($IDPagamento){
        if(SELF::confVendaPagamento($IDPagamento)){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE pagamentos SET STDelete = 1 WHERE IDPagamento = '$IDPagamento' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM pagamentos WHERE IDPagamento = '$IDPagamento' ");
        }
        return $v_SQL;
    }

    /** RETORNA UM PAGAMENTO ESPECIFICO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarPagamento($IDPagamento){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM pagamentos WHERE IDPagamento = '$IDPagamento' ");
        return $v_SQL;
    }
    
    /** SALVA UM PAGAMENTO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarPagamento($dados){
        $IDPagamento =  $dados['IDPagamento'];
        $IDFilial = $_SESSION['login']['filial'];
        $nomeMetodo= $dados['nomeMetodo'];
        $metodoMetodo =  $dados["metodoMetodo"];
        $parcelasPagamento = $dados["parcelasMetodo"];
        $TPDesconto = $dados['tipoMetodo'];
        $NUJuros = $dados['jurosMetodo'];
        if($TPDesconto == "1"){
            $descontoMetodo = intval($dados['descontoMetodo']);
        }else{
            $descontoMetodo = FRGeral::trataValor($dados['descontoMetodo'],1);
        }
        if($IDPagamento){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE pagamentos SET
            NMPagamento = '$nomeMetodo',
            QTDesconto = '$descontoMetodo',
            DSMetodo = '$metodoMetodo',
            QTParcelas = '$parcelasPagamento',
            TPDesconto = '$TPDesconto',
            NUJuros = '$NUJuros'
            WHERE IDPagamento = '$IDPagamento' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO pagamentos (
                NMPagamento,
                QTDesconto,
                DSMetodo,
                QTParcelas,
                TPDesconto,
                IDFilial,
                NUJuros
                ) 
                VALUES (
                '$nomeMetodo',
                '$descontoMetodo',
                '$metodoMetodo',
                '$parcelasPagamento',
                '$TPDesconto',
                '$IDFilial',
                '$NUJuros'
                ) 
                ");
        }
        return $v_SQL;
    }
}
//CLASSE DE FINANCEIRO
class Financeiro{

    /** RETORNA LISTA DE DESPESAS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function listarPagar($IDFilial){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM contapagar WHERE IDFilial = '$IDFilial' ");
        return $v_SQL;
    }

    /** RETORNA LISTA DE DESPESAS
     * 
     * 
     * @type	function
     * @date	20/02/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function pagarConta($ID){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE contapagar SET STConta = 1 WHERE IDConta = '$ID' ");
        return $v_SQL;
    }

    /** RETORNA EXCLUI DESPESA
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function excluirContaPagar($IDConta){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM contapagar WHERE IDConta = '$IDConta' ");
        return $v_SQL;
    }

    /** RETORNA UMA CONTA A PAGAR
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function mostrarContaPagar($IDConta){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM contapagar WHERE IDConta = '$IDConta' ");
        return $v_SQL;
    }

    /** SALVA UMA CONTA A PAGAR
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function salvarContaPagar($dados){
        if($dados['IDContaPagar']){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE contapagar SET
            NMConta = '".$dados['nomeContaPagar']."',
            DTVencimentoConta = '".$dados['vencimentoContaPagar']."',
            VLConta = '".$dados['valorContaPagar']."',
            DSJustificativaConta = '".$dados['justificativaContaPagar']."'
            WHERE IDConta = '".$dados['IDContaPagar']."' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO contapagar (
                NMConta,
                DTVencimentoConta,
                VLConta,
                DSJustificativaConta,
                STConta,
                IDFilial
                ) 
                VALUES (
                '".$dados['nomeContaPagar']."',
                '".$dados['vencimentoContaPagar']."',
                '".$dados['valorContaPagar']."',
                '".$dados['justificativaContaPagar']."',
                '0',
                '".$_SESSION['login']['filial']."'
                ) 
                ");
        }
        return $v_SQL;
    }

}
//CLASS EMPRESAS
class Contratos{

    public static function getPlanos(){
        $SQL = "SELECT * FROM planos";
        return mysqli_query(FRController::conectarDatabase(),$SQL);
    }

    public static function getColaboradorByUser($IDUsuario){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT IDColaborador FROM colaboradores INNER JOIN usuarios USING(IDColaborador) WHERE usuarios.IDUsuario = $IDUsuario ");
        $return = mysqli_fetch_assoc($SQL);
        if($return){
            return $return['IDColaborador'];
        }else{
            return 0;
        }
    }

    /** RETORNA LISTA DE EMPRESAS
     * 
     * 
     * @type	function
     * @date	01/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getContratos(){
        if(in_array($_SESSION['login']['nivel'],["2.5","2"])){
            $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM contratos INNER JOIN planos USING(IDPlano) WHERE IDCriador = '".$_SESSION['login']['dados']['id']."' ");
        }else{
            $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM contratos INNER JOIN planos USING(IDPlano) ");
        }
        return $SQL;
    }

    public static function setColaborador($dados){
        extract($dados);
        if($IDColaborador){
            $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE colaboradores SET 
                NMColaborador = '$nome',
                NMCargoColaborador = '$cargo',
                NMEmailColaborador = '$email',
                VLSalario =  '$salario'
                WHERE IDColaborador =$IDColaborador
            ");
        }else{
            $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO colaboradores 
            (NMColaborador,NMCargoColaborador,NUCpfColaborador,VLSalario,DTAdmissao,IDFilial,NMEmailColaborador)
            VALUES
            ('$nome','$cargo','$cpf','$salario','$admissao','$filial','$email')
            ");
        }
        return $SQL;
    }

    /** RETORNA LISTA DE EMPRESAS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
     public static function getFiliais($IDEmpresa){
        $SQL = "SELECT f.*,SUM(c.VLSalario) as folhaSalarial FROM filiais as f LEFT JOIN colaboradores c USING(IDFilial) WHERE f.IDEmpresa = $IDEmpresa GROUP BY f.IDFilial ORDER BY f.IDFilial ";
        return mysqli_query(FRController::conectarDatabase(),$SQL);
     }

     public static function getFilial($IDFilial){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT f.*,SUM(c.VLSalario) as folhaSalarial FROM filiais as f LEFT JOIN colaboradores c USING(IDFilial) WHERE IDFilial = $IDFilial ");
        return mysqli_fetch_assoc($SQL);
     }

     /** RETORNA LISTA DE COLABORADORES
     * 
     * 
     * @type	function
     * @date	03/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getColaboradores($IDEmpresa){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT
        c.*,
        f.NMFilial,
        f.IDFilial,
        u.DTUltimoAcesso
        FROM colaboradores c
        LEFT JOIN filiais f USING(IDFilial)
        LEFT JOIN usuarios u USING(IDColaborador)
        WHERE f.IDEmpresa = $IDEmpresa ORDER BY c.IDColaborador ");
        return $SQL;
     }

     public static function getColaborador($IDColaborador){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM colaboradores WHERE IDColaborador = '$IDColaborador' ");
        return mysqli_fetch_assoc($SQL);
     }

    /** RETORNA TODOS OS CONTRATOS
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getAllContratos(){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM contratos ");
        return $SQL;
    }

    /** RETORNA UMA EMPRESA
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public static function getContrato($ID){
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM contratos WHERE IDContrato = '$ID' ");
        return mysqli_fetch_assoc($v_SQL);
    }

    public function delColaborador($dados){
        extract($dados);
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM colaboradores WHERE IDColaborador = '$IDColaborador' ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM usuarios WHERE IDColaborador = '$IDColaborador' ");
        return $v_SQL;
    }

    /** RETORNA UMA EMPRESA
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function delContrato($dados){
        extract($dados);
        //FILIAIS PARA EXCLUSÃO DE PRODUTOS
        $filiais = mysqli_query(FRController::conectarDatabase(),"SELECT IDFilial FROM filiais INNER JOIN empresas USING(IDEmpresa) INNER JOIN contratos USING(IDContrato) WHERE IDContrato = $IDContrato ");
        $filiais_id = array();
        foreach($filiais as $f){
            array_push($filiais_id,$f['IDFilial']);
        }
        $IDFiliais = implode(',',$filiais_id);
        //EXCLUSÃO DOS DADOS DO CONTRATO,EMPRESA,FILIAIS,PRODUTOS,SERVIÇOS ETC...
        $v_SQL = mysqli_query(FRController::conectarDatabase(),"DELETE FROM contratos WHERE IDContrato = $IDContrato ")&
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM colaboradores,usuarios LEFT JOIN usuarios USING(IDColaborador) WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM caixa WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM categorias WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM clientes,devedores,crediarios LEFT JOIN devedores USING(IDCliente) LEFT JOIN crediarios USING(IDCrediario) WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM contas WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM cupons WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM empresas WHERE IDFilial IN($IDContrato) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM filiais WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM fornecedores,produtos LEFT JOIN produtos USING(IDFornecedor) WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM servicos,ordemservico LEFT JOIN ordemservico USING(IDServico) WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM pagamentos WHERE IDFilial IN($IDFiliais) ") &
        mysqli_query(FRController::conectarDatabase(),"DELETE FROM promocoes,promocionais USING(IDPromocao) WHERE IDFilial IN($IDFiliais) ");
        return $v_SQL;
    }

    /** MUDA UMA EMPRESA DE ESTADO
     * 
     * 
     * @type	function
     * @date	04/10/2022
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function changeStatus($ID,$ST){
        if($ST == 1){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE contratos SET STContrato = 0 WHERE IDContrato = '$ID'   ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE contratos SET STContrato = 1 WHERE IDContrato = '$ID'   ");
        }
        return $v_SQL;
    }

    public function changeColaborador($dados){
        extract($dados);
        if(is_array($ID) && is_array($atualStatus)){
            $implode_id = implode(',',$ID);
            switch($mtd){
                case "blqAll":
                    $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE colaboradores SET STAcesso = 0 WHERE IDColaborador IN($implode_id)   ");
                break;
                case "dlqAll":
                    $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE colaboradores SET STAcesso = 1 WHERE IDColaborador IN($implode_id)   ");
                break;
            }
        }else{
            if($atualStatus == 1){
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE colaboradores SET STAcesso = 0 WHERE IDColaborador = '$ID'   ");
            }else{
                $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE colaboradores SET STAcesso = 1 WHERE IDColaborador = '$ID'   ");
            }
        }
        return $v_SQL;
    }

    /** SALVA UMA FILIAL
     * 
     * 
     * @type	function
     * @date	02/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */

     public static function setFilial($dados){
        $IDContrato = (isset($_SESSION['login']['contrato']) ? $_SESSION['login']['contrato'] : 0 );
        $IDEmpresa = Contratos::getEmpresa($IDContrato);
        extract($dados);
        $endjson = json_encode(array(
            "cep" => $cep,
            "uf" => $uf,
            "rua" => $rua,
            "cidade" => $cidade,
            "bairro" => $bairro,
            "numero" => $numero
        ),JSON_UNESCAPED_UNICODE);
        if($IDFilial){
            $SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE filiais SET DSEnderecoJSON ='$endjson', NMFilial = '$nome',NUTelefoneFilial = '$telefone' WHERE IDFilial = '$IDFilial' ");
        }else{
            $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO filiais (IDEmpresa,DSEnderecoJSON,NMFilial,NUTelefoneFilial) VALUES ('$IDEmpresa','$endjson','$nome','$telefone') ");
        }
        return $SQL;
     }

    /** SALVA UMA EMPRESA
     * 
     * 
     * @type	function
     * @date	01/07/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function setEmpresa($dados){
        extract($dados);
        $CNF = mysqli_fetch_assoc(mysqli_query(FRController::conectarDatabase(),"SELECT IDEmpresa FROM empresas WHERE NUCnpjEmpresa = '$cnpj' "));
        if($CNF){
            $retorno['status'] = false;
        }else{
            $SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO 
            empresas (IDContrato,NMFantasiaEmpresa,NMRazaoEmpresa,NUCnpjEmpresa)
            VALUES
            ('$contrato','$fantasia','$razao','$cnpj')
            ");
            $retorno['sql'] = $SQL;
            $retorno['status'] = true;
        }
        
        return json_encode($retorno);
    }

    public static function getEmpresa($contrato){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM empresas WHERE IDContrato = $contrato");
        $fetch = mysqli_fetch_assoc($SQL);
        if($fetch){
           return $fetch['IDEmpresa'];
        }else{
           return "0";
        }
        
    }

    public static function getSelectColUser(){
        $SQL = mysqli_query(FRController::conectarDatabase(),"SELECT IDColaborador,NMColaborador,NMEmailColaborador FROM colaboradores INNER JOIN filiais USING(IDFilial) WHERE IDColaborador NOT IN(SELECT IDColaborador FROM usuarios ) AND IDEmpresa = '".$_SESSION['login']['empresa']."'");
        return $SQL;
    }

    public static function getDadosEmpresa($IDEmpresa,$IDUsuario){
        if($IDEmpresa != 0){
            $empresa = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM empresas WHERE IDEmpresa = $IDEmpresa");
            $dados['empresa'] = mysqli_fetch_assoc($empresa);
        }else{
            $empresa = "Painel de controle";
        }
        $usuario = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE IDUsuario = $IDUsuario");
        $dados['usuario'] = mysqli_fetch_assoc($usuario);
        return $dados;
    }

    public static function getDadosFilial($IDFilial,$IDUsuario){
        $filial = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM filiais WHERE IDFilial = $IDFilial");
        $usuario = mysqli_query(FRController::conectarDatabase(),"SELECT * FROM usuarios WHERE IDUsuario = $IDUsuario");
        $dados['filial'] = mysqli_fetch_assoc($filial);
        $dados['usuario'] = mysqli_fetch_assoc($usuario);
        return $dados;
    }
    
    /** SALVA UM CONTRATO
     * 
     * 
     * @type	function
     * @date	26/06/2023
     * @since	1.0.1
     *
     * @param	VAR|ARRAY|OBJ
     * @return	OBJ|ARRAY
     */
    public function setContrato($dados){
        extract($dados);
        $endereco = array(
            "cep" => $cep,
            "uf" => $uf,
            "cidade" => $cidade,
            "rua" => $rua,
            "bairro" => $bairro,
            'numero' => $numero
        );
        if($IDContrato){
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"UPDATE contratos SET 
            NMContratante = '$contratante', 
            NMEmailContratante = '$email' ,
            NUTelefoneContato = '$telefone',
            IDPlano = '$plano',
            DSEndContrato = '".stripslashes(json_encode($endereco,JSON_UNESCAPED_UNICODE))."'
            WHERE IDContrato = '$IDContrato' ");
        }else{
            $v_SQL = mysqli_query(FRController::conectarDatabase(),"INSERT INTO contratos 
                (IDPlano,DSEndContrato,NMContratante,NMEmailContratante,NUCpfContratante,NUTelefoneContato,IDCriador) 
                VALUES
                ('".$plano."','".json_encode($endereco,JSON_UNESCAPED_UNICODE)."','".$contratante."','".$email."','".$cpf."','".$telefone."','".$_SESSION['login']['dados']['id']."') 
            ");
        }
        return $v_SQL;
    }
}
///FIM DAS CLASSES
////INSTANCIAMENTO DE TODAS AS CLASSES
//INSTANCIAMENTO CLASS AUTENTICAÇÃO
$token = new Autenticacao;
//INSTANCIAMENTO CLASS EMPRESAS
$empresas = new Contratos;
//INSTANCIAMENTO CLASS USUARIOS
$usuarios = new Usuarios;
//INSTANCIAMENTO CLASS FORNECEDORES
$fornecedores = new Fornecedores;
//INSTANCIAMENTO CLASS PAGAMENTOS
$pagamentos = new Pagamentos;
//INSTANCIAMENTO CLASS FINANCEIRO
$financeiro = new Financeiro;
//INSTANCIAMENTO CLASS CLIENTES
$clientes = new Clientes;
//INSTANCIAMENTO CLASS PONTOS
$pontos = new Pontos;
//INSTANCIAMENTO CLASS PRODUTOS
$produtos = new Produtos;
//INSTANCIAMENTO CLASS PROMOÇÕES
$promocoes = new Promocoes;