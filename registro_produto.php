<!--Desenvolvido por Arthur Amorelli-->
<?php

require_once('db.class.php');

session_start();

$objDb = new db();
$link = $objDb -> conecta_mysql();

$nome_produto = $_POST['nome_produto'];
$valore = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$id_usuario = $_SESSION['id_usuario'];
$arquivo = $_FILES['arquivo'];
$descricao = addslashes($_POST['descricao']);

$valor = str_replace(",",".", $valore);

if ($arquivo['size'] > 2097152) {
	header('location: cadastro_produto.php?sucesso=3');
	die();
}
if ($arquivo['error']) {
	header('location: cadastro_produto.php?sucesso=4');
	die();
}

$pasta = "img_produtos/";
$nomeDoArquivo = $arquivo['name'];
$novoNomeDoArquivo = uniqid();
$extensao = strtolower(pathinfo($nomeDoArquivo,PATHINFO_EXTENSION));

if ($extensao != "png" && $extensao != "jpg") {
	header('location: cadastro_produto.php?sucesso=5');
	die();
}

$path = $pasta . $novoNomeDoArquivo . "." . $extensao;
$guarda_arquivo = move_uploaded_file($arquivo["tmp_name"], $path);
$nomeComExt = $novoNomeDoArquivo . ".". $extensao;

	/*if ($deu_certo) {
		echo "Deu certo carai";
	}else{
		echo "deu ruim";
	}*/

	//verificar se pj existe
	
	$sql = "SELECT * from tb_pj where id_usuario = $id_usuario";

	if($resultado_id = mysqli_query($link,$sql)){

		$dados_estabelecimento = mysqli_fetch_array($resultado_id);

		if (isset($dados_estabelecimento['id_pj'])) {
			$id_pj = $dados_estabelecimento['id_pj'];
		}else{
			
			header('location: cadastro_pj.php?');
			die();
		}
	} 
	/*echo '<pre>';
	var_dump($_FILES);
	echo '</pre>';
	if (isset($_FILES['arquivo'])) {
		echo "arquivo enviado";
	}*/
	
	$sql = "INSERT INTO tb_produto(nome_produto, valor, quantidade, id_pj, path, nome_arquivo, descricao) VALUES ('$nome_produto', '$valor', '$quantidade', $id_pj, '$path', '$nomeComExt', '$descricao') ";
	
	//echo $id_pj;
	//echo $sql;

	//executar a query

	if(mysqli_query($link, $sql)){

		header('location: cadastro_produto.php?sucesso=2');

	} else{
		echo "Erro ao registrar o produto";
		
		echo $sql;
	}

?>