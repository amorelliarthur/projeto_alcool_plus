	<!--Desenvolvido por Arthur Amorelli-->
	<?php
	
	require_once('db.class.php');
	$objDb = new db();
	$link = $objDb -> conecta_mysql();

	$id_produto = $_POST['id_produto'];
	$id_usuario = $_POST['id_usuario'];
	$id_pf = $_POST['id_pf'];
	$id_pj = $_POST['id_pj'];
	$id_pedido = $_POST['id_pedido'];
	$quantidade = $_POST['qtd'];
	$inf = isset($_GET['inf']) ? $_GET['inf'] : 0;
	
		/*
		inf = 1 -> apaga produto
		inf = 2 -> apaga pf
		inf = 3 -> apaga pedido
		inf = 4 -> apaga pj
		*/

		if ($inf == 1) {
			$sql = "DELETE from tb_produto where id_produto = $id_produto";
			if(mysqli_query($link, $sql)){
				header('location: index.php?');
			} else{
				echo "Erro ao executar a query";
			}
		}else if ($inf == 2) {

			$sql = "DELETE from tb_usuario where id_usuario = $id_usuario";
			if(mysqli_query($link, $sql)){
				header('location: index.php?');
			} else{
				echo "Erro ao executar a query";
			}

			$sql = "DELETE from tb_pf where id_pf = $id_pf";
			if(mysqli_query($link, $sql)){
				header('location: index.php?');
			} else{
				echo "Erro ao executar a query";
			}
		}else if ($inf == 3) {

			$sql = "DELETE from tb_pedido where id_pedido = $id_pedido";
			if(mysqli_query($link, $sql)){

				header('location: pedidos.php?');
			} else{
				echo "Erro ao executar a query";
			}

			$sql = "SELECT * from tb_produto where id_produto = $id_produto";
			$resultado_produtos = mysqli_query($link,$sql);
			$linha = mysqli_fetch_array($resultado_produtos);
			$quantidade_produto = $linha['quantidade'];

			$nova_quantidade = $quantidade_produto + $quantidade;

			$sql = "UPDATE tb_produto SET quantidade = $nova_quantidade where id_produto = $id_produto ";
			if(mysqli_query($link, $sql)){
				header('location: pedidos.php?');
			} else{
				echo "Erro ao executar a query";
			}
			$sql = "UPDATE tb_pf SET ultima_compra = 0 where id_pf = $id_pf ";
			if(mysqli_query($link, $sql)){
				header('location: pedidos.php?');
			} else{
				echo "Erro ao executar a query";
			}
		}else if ($inf == 4) {
			
			$sql = "DELETE from tb_usuario where id_usuario = $id_usuario";
			if(mysqli_query($link, $sql)){
				header('location: index.php?');
			} else{
				echo "Erro ao executar a query";
			}

			$sql = "DELETE from tb_pj where id_pj = $id_pj";
			if(mysqli_query($link, $sql)){
				header('location: index.php?');
			} else{
				echo "Erro ao executar a query";
			}

		}

	?>