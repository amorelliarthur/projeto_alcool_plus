<?php
require_once('db.class.php');
$objDb = new db();
$link = $objDb -> conecta_mysql();

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
session_start();

$id_pj = isset($_GET['id']) ? $_GET['id'] : 0;


$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';

$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 4;

if($nivel == 3 || $nivel == 4){
	$cad = 1;
}else{
	$cad = 0;
}

$itens_por_pag = 6;

$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;

$sucesso = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;
$pass = isset($_GET['pass']) ? $_GET['pass'] : 0;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<link rel="icon" href="img/icon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Alcool+</title>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<script>
		$(document).ready(function(){
				//verificar se campos foram preenchidos
				$('#btn_login').click(function(){

					if($('#email').val() == ''){
						alert('Preencha o campo email!')
					} else if($('#senha').val() == ''){
						alert('Preencha o campo senha!')
					}
				})
				
			});

		
		</script>

	</head>
	<body>
		<?php include('header.php') ?>

		<section><!-- inicio lista produtos -->
			
			<div class="container">    
				<div class="row">

					<div class="card-principal">
						<div class="card">
							<div class="card-header">

								<?php

								ini_set('display_errors', FALSE);
								
								$sql = "SELECT * FROM tb_pj where id_pj = $id_pj";
								
								if($resultado_id = mysqli_query($link,$sql)){

									$dados_estabelecimento = mysqli_fetch_array($resultado_id);

									if (isset($dados_estabelecimento['nome_pj'])) {
										$nome_pj = $dados_estabelecimento['nome_pj'];
										
									}else{
										
										header('location: index.php?');
									}
								}	
								?>

								<h4>  <?= $nome_pj ?> </h4>
							</div>
							<div class="card-body">
								<div class="card-columns"><?php 
								
								$sql = "select * from tb_produto where id_pj=" . $id_pj ;
								$produtos = mysqli_query($link,$sql);
							$row_cnt = mysqli_num_rows($produtos); // quantidade total no banco
							$num_pags = ceil($row_cnt/$itens_por_pag); // define o numero de pag.
							$inicio = $itens_por_pag*$pag-$itens_por_pag;

							//echo "quantidade no banco: ". $row_cnt."<br/>";
							//echo "num pag: ". $num_pags."<br/>";
							//echo "inicio: ". $inicio."<br/>";	

							$sql = "select * from tb_produto where id_pj= $id_pj limit $inicio , $itens_por_pag";
								//echo $sql."<br/>";
								//echo "pag: ".$pag;

							if($resultado_produtos = mysqli_query($link,$sql)){
								
								$produtos = "";
								while ($linha = mysqli_fetch_array($resultado_produtos)) {
									
									if ($linha[quantidade] > 0) {
										$valor = str_replace(".",",", $linha[valor]);
										
										$produtos.='<form method="post" action="finalizar_compra.php">
										<div class="card mb-3 bg-light">
										<img style="height: 13rem;" class="card-img-top" src="img_produtos/'.$linha[nome_arquivo].'" alt="Imagem de capa do card">
										<div class="card-body">
										<h5 class="card-title">'.$linha[nome_produto].' </a></h5>										  
										<p class="card-text">R$ '.$valor.'</p>
										<input type="hidden" name="id_pj" value="'.$linha[id_pj].'" />
										<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />
										</div>
										
										<div class="col-12">
										<button type="submit" class="btn btn-primary form-control">
										Comprar
										</button><br><br>
										</div>  
										</div>
										</form>';
									}	
								}
								echo $produtos;

							}else{
								echo "<br>nao executou a query!";
							}?>														
						</div>
						
					</div>
					
					<nav>
						<ul  class="paginacao pagination pagination-sm justify-content-center">
							<li class="paginacao page-item <?= $num_pags < 2 || $pag == 1 ? 'disabled' : '' ?>" >
								<a class="paginacao page-link" href="lista_produtos.php?id=<?= $id_pj ?>&pag=1">Início</a>
							</li>
							<?php for ($i=1; $i < $num_pags+1 ; $i++) { ?>
								
								<li class="paginacao page-item <?= $pag == $i ? "active" : "" ?>"><a class="page-link" href="lista_produtos.php?id=<?= $id_pj ?>&pag=<?= $i; ?>"><?= $i; ?></a></li>

							<?php } ?>
							
							
							<li class="paginacao page-item <?= $num_pags < 2 || $pag == $num_pags ? 'disabled' : '' ?>" >
								<a class="paginacao page-link" href="lista_produtos.php?id=<?= $id_pj ?>&pag=<?= $num_pags ?>">Fim</a>
							</li>
						</ul>
					</nav>

				</div>
			</div>
		</div>
	</div>	

</section><!-- fim lista produtos -->

<?php include('footer.php') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body>	
</html>