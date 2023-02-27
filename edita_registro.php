<!--Desenvolvido por Arthur Amorelli-->
<?php

require_once('db.class.php');
$objDb = new db();
$link = $objDb -> conecta_mysql();

$nome_produto = $_POST['nome_produto'];
$valore = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$id_produto = $_POST['id_produto'];
$inf = isset($_GET['inf']) ? $_GET['inf'] : 0;
$arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : 0;
$descricao = addslashes($_POST['descricao']);

	/*
	inf = 1 -> edita produto
	*/

	$valor = str_replace(",",".", $valore);



	if ($inf == 1) {

		if ($arquivo['size'] > 2097152 && $arquivo != 0) {
			header('location: index.php?sucesso=3');
			die();
		}

		if ($arquivo[name] != 0) {

			if ($arquivo['error']) {
				header('location: index.php?sucesso=4');
				var_dump($arquivo);
				die();
			}
		}

		

		$pasta = "img_produtos/";
		$nomeDoArquivo = $arquivo['name'];
		$novoNomeDoArquivo = uniqid();
		$extensao = strtolower(pathinfo($nomeDoArquivo,PATHINFO_EXTENSION));

		if ($extensao != null) {
			if ($extensao != "png" && $extensao != "jpg") {
			//echo "oi". $extensao;
			header('location: index.php?sucesso=5');
			die();
			}
		}

		

		$path = $pasta . $novoNomeDoArquivo . "." . $extensao;
		$guarda_arquivo = move_uploaded_file($arquivo["tmp_name"], $path);
		$nomeComExt = $novoNomeDoArquivo . ".". $extensao;

		

		if ($arquivo[name] != null) {
			$sql = "UPDATE tb_produto SET nome_produto = '$nome_produto', valor = $valor, quantidade = $quantidade, path = '$path', nome_arquivo = '$nomeComExt' WHERE id_produto = $id_produto ";
			echo $arquivo[name];
		}else{
			$sql = "UPDATE tb_produto SET nome_produto = '$nome_produto', valor = $valor, quantidade = $quantidade WHERE id_produto = $id_produto ";
		}

		mysqli_query($link, $sql);

		if ($descricao != null) {
			$sql = "UPDATE tb_produto SET descricao = '$descricao' WHERE id_produto = $id_produto ";
		}
		
		if(mysqli_query($link, $sql)){
			header('location: index.php?');
			
		} else{
			echo "Erro ao executar a query";
			
		}

	}

?>