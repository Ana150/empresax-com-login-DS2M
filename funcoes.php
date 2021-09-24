<?php

function lerArquivo($nomeArquivo)
{
    $arquivo = file_get_contents($nomeArquivo);

    $jsonArray = json_decode($arquivo);

    return $jsonArray;
}

function buscarFuncionario($funcionarios, $first_name)
{

    $funcionariosFiltro = [];

    foreach ($funcionarios as $funcionario) {
        if (
            strpos($funcionario->first_name, $first_name) !== false
            ||
            strpos($funcionario->last_name, $first_name) !== false
            ||
            strpos($funcionario->department, $first_name) !== false
        ) {
            $funcionariosFiltro[] = $funcionario;
        }
    }

    return $funcionariosFiltro;
}

function adicionarFuncionario($nomeArquivo, $novoFuncionario)
{
    $funcionarios = lerArquivo($nomeArquivo);

    $funcionarios[] = $novoFuncionario;

    $json = json_encode($funcionarios);

    file_put_contents($nomeArquivo, $json);
}

function deletarFuncionario($nomeArquivo, $idFuncionario)
{
    $funcionarios = lerArquivo($nomeArquivo);

    foreach ($funcionarios as $chave => $funcionario) {
        if ($funcionario->id == $idFuncionario) {
            unset($funcionarios[$chave]);
        }
    }
    $json = json_encode(array_values($funcionarios));

    file_put_contents($nomeArquivo, $json);
}

function buscarFuncionarioPorId($nomeArquivo, $idFuncionario)
{
    $funcionarios = lerArquivo($nomeArquivo);

    foreach ($funcionarios as $funcionario) {
        if ($funcionario->id == $idFuncionario) {
            return $funcionario;
        }
    }
    return false;
}

function editarFuncionario($nomeArquivo, $funcionarioEditado){
    $funcionarios = lerArquivo($nomeArquivo);

    foreach ($funcionarios as $chave => $funcionario) {
        if ($funcionario->id == $funcionarioEditado['id']) {
            $funcionarios[$chave] = $funcionarioEditado;
        }
    }
    $json = json_encode(array_values($funcionarios));

    file_put_contents($nomeArquivo, $json);
}
//FUNÇÕES PARA VALIDAÇÃO DO USUARIO

//parametros da função:
//1 - usuario vindo do form
//2 - senha vindo do form
//3 - dados do arquivo json de usuario e senha

function realizarLogin($usuario, $senha, $dados)
{

    foreach ($dados as $dado) {

        if ($dado->usuario == $usuario && $dado->senha == $senha) {

            //VARIÁVEIS DE SESSÃO:
            $_SESSION["usuario"] = $dado->usuario;
            $_SESSION["id"] = session_id();
            $_SESSION["data_hora"] = date('d/m/Y - h:i:s');

            header('location: empresaIndex.php');
            exit;
        }
    }

    header('location: index.php');
}

function verificarLogin()
{
    if ($_SESSION['id'] != session_id() || (empty($_SESSION['id']))) {
        header('location: index.php');
    }
}

function finalizarLogin(){
    session_unset();
    session_destroy();

    header('location: index.php');
}



