<?php

require_once('db.class.php');
$objDb = new db();
$link = $objDb -> conecta_mysql();	

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
$prox_compra_dia = isset($_GET['prox_compra_dia']) ? $_GET['prox_compra_dia'] : 0;
$prioridade = isset($_GET['prioridade']) ? $_GET['prioridade'] : 0;
session_start();

$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';

$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 4;
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario']: ''; 

if($nivel == 3 || $nivel == 4){
	$cad = 1;
}else{
	$cad = 0;
}

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

		<section><!-- inicio pedidos -->
			
			<div class="container">    
				<div class="row">

					<div class="card-principal">
						<div class="card">
							<div class="card-header">
								<h4> Pedidos </h4>
							</div>
							
							<div class="card-body">
								<?php 
								if($prox_compra_dia != 0){
									//echo "Faltam".$prox_compra_dia."dias para sua prox compra";

									?>
									<div class="card mb-3 bg-light">
										<div class="card-body">
											<h5 class="card-title">Compra não efetuada!</h5>
											<h6 class="card-title"> Faltam <?= $prox_compra_dia ?> dias para você poder realizar a próxima	 compra</h6>
											
										</div>
									</div>

									<?php

								}

								if ($prioridade == 2) {
									?>
									<div class="card mb-3 bg-light">
										<div class="card-body">
											<h5 class="card-title">Compra não efetuada!</h5>
											<h6 class="card-title"> Desculpe, você não tem prioridade para realizar essa compra!</h6>
											
										</div>
									</div>

									<?php
								}

								?>
								<?php 
								ini_set('display_errors', FALSE);
								if ($nivel == 1) {
									$sql = "SELECT * from tb_pf where id_usuario = $id_usuario";
									if($resultado_id = mysqli_query($link,$sql)){
										
										$dados_pf = mysqli_fetch_array($resultado_id);
										$id_pf = $dados_pf['id_pf'];
										
										$sql = "SELECT * from tb_pj, tb_produto, tb_pf, tb_pedido where tb_pedido.id_pf=tb_pf.id_pf and tb_pedido.id_pj=tb_pj.id_pj and tb_pedido.id_produto=tb_produto.id_produto and tb_pf.id_pf = " . $id_pf . " group by tb_pedido.id_pedido order by tb_pedido.id_pedido desc";
										if($resultado_id = mysqli_query($link,$sql)){
											$pedidos = "";
											while ($linha = mysqli_fetch_array($resultado_id)) {
												
												$data_compra = strtotime($linha[data]);
								        	//echo $data_compra;
								        	//$data = strtotime(date('Y/m/d'));
												$valor = str_replace(".",",", $linha[valor]);
												$pedidos.='<div class="card mb-3 bg-light">
												<div class="card-body">
												<h6 class="card-subtitle mb-2 text-muted">Número do pedido: '.$linha[id_pedido].'</h6>
												<h6 class="card-subtitle mb-2 text-muted">'.$linha[data].'</h6>
												<h5 class="card-title">'.$linha[nome_produto].'</h5>
												<h5 class="card-title">'.$linha[nome_pj].'</h5>
												<h6 class="card-subtitle mb-2 text-muted">Quantidade: '.$linha[quantidade].'</h6>
												<p class="card-text">Valor: R$ '.$valor.'</p>
												
												</div>
												</div>';								            
											}
											
											echo $pedidos;
											
										}
									}
								} if($nivel == 2){

									$sql = "SELECT * from tb_pj where id_usuario = $id_usuario";
									if($resultado_id = mysqli_query($link,$sql)){
										$dados_pj = mysqli_fetch_array($resultado_id);
										$id_pj = $dados_pj['id_pj'];

										$sql = "select * from tb_pj, tb_produto, tb_pf, tb_pedido where tb_pedido.id_pf=tb_pf.id_pf and tb_pedido.id_pj=tb_pj.id_pj and tb_pedido.id_produto=tb_produto.id_produto and tb_pj.id_pj=".$id_pj." group by tb_pedido.id_pedido desc; ";
										if($resultado_id = mysqli_query($link,$sql)){
											$pedidos = "";
											while ($linha = mysqli_fetch_array($resultado_id)) {
												
												$valor = str_replace(".",",", $linha[valor]);
												$pedidos.='<div class="card mb-3 bg-light">
												<div class="card-body">
												<h6 class="card-subtitle mb-2 text-muted">Número do pedido: '.$linha[id_pedido].'</h6>
												<h6 class="card-subtitle mb-2 text-muted">'.$linha[data].'</h6>
												<h5 class="card-title">'.$linha[nome_pf].'</h5>
												<h5 class="card-title">'.$linha[nome_produto].'</h5>
												<h6 class="card-subtitle mb-2 text-muted">Quantidade: '.$linha[quantidade].'</h6>
												<p class="card-text">Valor: R$ '.$valor.'</p>
												
												</div>
												<form method="post" action="exclui_registro.php?&inf=3">
												<input type="hidden" name="id_pedido" value="'.$linha[id_pedido].'" />
												<input type="hidden" name="quantidade" value="'.$linha[quantidade].'" />
												<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />
												<input type="hidden" name="id_pf" value="'.$linha[id_pf].'" />
												<div class="row m-2">
												<div class="col-sm-12 col-md-3 col-xl-2 mb-2">
												<button type="submit" class="btn btn-danger form-control"> Cancelar pedido </button>
												</div>															
												</div>
												</form>
												</div>';								            
											}
											
											echo $pedidos;
											
										}

									}
								} if($nivel == 3){

									$sql = "select * from tb_pj, tb_produto, tb_pf, tb_pedido where tb_pedido.id_pf=tb_pf.id_pf and tb_pedido.id_pj=tb_pj.id_pj and tb_pedido.id_produto=tb_produto.id_produto group by tb_pedido.id_pedido desc";
									if($resultado_id = mysqli_query($link,$sql)){
										$pedidos = "";
										while ($linha = mysqli_fetch_array($resultado_id)) {
											
											$valor = str_replace(".",",", $linha[valor]);
											$pedidos.='<div class="card mb-3 bg-light">
											<div class="card-body">
											<h6 class="card-subtitle mb-2 text-muted">Número do pedido: '.$linha[id_pedido].'</h6>
											<h6 class="card-subtitle mb-2 text-muted">'.$linha[data].'</h6>
											<h5 class="card-title">'.$linha[nome_pf].'</h5>
											<h6 class="card-title">'.$linha[nome_pj].'</h6>
											<h6 class="card-title">'.$linha[nome_produto].'</h6>
											<h6 class="card-subtitle mb-2 text-muted">Quantidade: '.$linha[quantidade].'</h6>
											<p class="card-text">Valor: R$ '.$valor.'</p>

											</div>

											<form method="post" action="exclui_registro.php?&inf=3">
											<input type="hidden" name="id_pedido" value="'.$linha[id_pedido].'" />
											<input type="hidden" name="quantidade" value="'.$linha[quantidade].'" />
											<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />
											<input type="hidden" name="id_pf" value="'.$linha[id_pf].'" />
											<div class="row m-2">
											<div class="col-sm-12 col-md-3 col-xl-2 mb-2">
											<button type="submit" class="btn btn-danger form-control"> Cancelar pedido </button>
											</div>															
											</div>
											</form>
											</div>';								            
										}
										
										echo $pedidos;
										
									}
								}

								?>

							</div>
							<!--<div class="card-footer text-muted"></div>--> 
						</div>
					</div>
				</div>
			</div>
		</div>	

	</section><!-- fim pedidos -->

	<?php include('footer.php') ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body>	
</html>