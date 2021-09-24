<?php
session_start();
//importando os arquivos de funçoes
require_once('./funcoes.php');

//recebendo os dados do formulario
if (isset($_POST['txt_usuario'])) {
    $usuario = $_POST['txt_usuario'];
    $senha = $_POST['txt_senha'];


    realizarLogin($usuario, $senha, lerArquivo('dados/usuarios.json'));
} else if ($_GET['logout']) {
    finalizarLogin();
}
