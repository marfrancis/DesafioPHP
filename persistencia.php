<?php 
// Antes de qualquer coisa a gente verifica que a sessão está ativa
@session_start();
$arquivo = 'produtos.json';

// Essa primeira função é responsável por abrir um arquivo e jogar o conteúdo dele para a sessão
function jsonToSession() {
	// Por uma questão de escopo a gente precisa definir a variável arquivo em global
	global $arquivo;
	// Perguntamos se o arquivo existe
	if(file_exists($arquivo)) {
		// Caso exista pegamos o conteúdo dele e fazemos unserialize
		$json = file_get_contents($arquivo);
		// Isso é necessário para que a string armazenada no arquivo volte a ser um vetor
		$json = unserialize($json);
		// Depois colocamos essa informação na sessão
		$_SESSION['produtos'] = $json;
	} else {
		// O código vai cair aqui caso arquivo não exista e nesse caso coloca na seção um vetor vazio indicando que não existem produtos
		$_SESSION['produtos'] = [];
	}
}

// E essa função faz o trabalho inverso
function sessionToJson() {
	global $arquivo;
	// Perguntamos se na sessão existe uma posição chamada ["produtos"]
	if(isset($_SESSION['produtos'])) {
		// Se existir a gente pega da sessão depois serializa esse conteúdo e salva no arquivo
		$json = $_SESSION['produtos'];
		$json = serialize($json);
		file_put_contents($arquivo, $json);
	} else {
		// Se não existir essa posição na sessão então salvamos no arquivo um vetor vazio serializado
		file_put_contents($arquivo, serialize([]));
	}
}
