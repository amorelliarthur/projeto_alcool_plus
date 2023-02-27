<?php

require_once('db.class.php');
$objDb = new db();
$link = $objDb -> conecta_mysql();
ini_set('display_errors', FALSE);

$erro_cpf = isset($_GET['erro_cpf']) ? $_GET['erro_cpf'] : 0;
$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
$erro_senha = isset($_GET['erro_senha']) ? $_GET['erro_senha'] : 0;
$erro_cpf2 = isset($_GET['erro_cpf2']) ? $_GET['erro_cpf2'] : 0;
$sucesso = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;
$id_pj = isset($_POST['id_pj']) ? $_POST['id_pj'] : 0;
$id_produto = isset($_POST['id_produto']) ? $_POST['id_produto'] : 0;


session_start();

$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';

$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';
$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : '4';

if ($autenticado == 'SIM' && $nivel != 1) {
	header('location: index.php?');
}

if($nivel == 3 || $nivel == 4){
	$cad = 1;
}else{
	$cad = 0;
}

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

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

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

		<section><!-- inicio cadastro pf  -->
			
			<div class="container">    
				<div class="row">

					<div class="card-principal">
						<div class="card">
							<div class="card-header">
								<h4> Finalizar compra </h4>
							</div>
							
							<div class="card-body">
								
								<div class="card mb-3 bg-light">

									<div class="card-body">
										
										<?php

										
										$sql = "SELECT * from tb_produto where id_produto = $id_produto and id_pj = $id_pj";
										
										$resultado_produtos = mysqli_query($link,$sql);
										$produto = "";
										$linha = mysqli_fetch_array($resultado_produtos);
										$valor = str_replace(".",",", $linha[valor]);
										
										$produto.='<form method="post" action="registro_pedido.php">
										<div class="row">
										<div class="col-sm-6 mb-2">
										<div style="height: 20rem;" class="card">
										<div class="card-body">
										<img style="height: 17.5rem;" class="card-img" src="img_produtos/'.$linha[nome_arquivo].'" alt="Imagem do card">
										</div>
										
										</div>
										</div>

										<div class="col-sm-6 mb-2">
										<div style="height: 20rem;" class="card text-left" >
										<div class="card-body">
										<h3 class="card-title">'.$linha[nome_produto].'</h3>
										<h6 class="card-subtitle mb-2 text-muted">Restam '.$linha[quantidade].' unidades</h6>
										<br>
										<h5 class="card-subtitle">R$ '.$valor.' / unidade</h5>	
										<input type="hidden" name="id_pj" value="'.$linha[id_pj].'" />
										<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />
										<input type="hidden" name="valor" value="'.$linha[valor].'" />
										<input type="hidden" name="quantidade" value="'.$linha[quantidade].'" />
										</div>

										<div class="row justify-content-end pr-4 pl-4 ">

										<div class="form-group col-sm-12 col-md-12 col-xl-4 ">							                
										<input type="number" min="1" max="2" placeholder="Quantidade"  class="form-control" id="quantidade_compra" name="quantidade_compra" required="requiored">
										</div>
										</div>

										<div class="row justify-content-end pr-4 pl-4">    
										<div class="mb-4 col-sm-12 col-md-12 col-xl-6 ">
										<button type="submit" class="btn btn-success form-control">
										Finalizar Compra
										</button>
										</div> 
										</div>


										

										</div>
										</div>
										</div>

										<div class="card">
										<div class="card-body">
										
										<div class="card-text" >

										<h6 class="card-subtitle mb-2">Descrição do produto: </h6>

										<p> '.$linha[descricao].' </p>
										</div>
										</div>
										
										</div>
										</div>

										</div>
										</form>';
										
										echo $produto; 
										?>


									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

			</div>

		</section> <!--  Fim cadastro pf -->
		
		<?php include('footer.php') ?>              
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		
	</body>	
	</html>