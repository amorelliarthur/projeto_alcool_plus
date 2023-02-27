	<?php

	$erro_cnpj = isset($_GET['erro_cnpj']) ? $_GET['erro_cnpj'] : 0;
	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
	$erro_senha = isset($_GET['erro_senha']) ? $_GET['erro_senha'] : 0;
	$erro_cnpj2 = isset($_GET['erro_cnpj2']) ? $_GET['erro_cnpj2'] : 0;
	$sucesso = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;
	$erro_email = isset($_GET['erro_email']) ? $_GET['erro_email'] : 0;
	$pass = isset($_GET['pass']) ? $_GET['pass'] : 0;
	
	session_start();

	$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';

	$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';
	$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : '4';

	if ($autenticado == 'SIM' && $nivel != 3) {
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

			$(document).ready(function(){
				//verificar força da senha				
				$('.forca_senha').keyup(function(){
					var senha = $(this).val();
					var forca = 0;

					if (senha.length <1) {
						forca = 0;
					}
					
					if((senha.length >= 4) && (senha.length <= 7)){
						forca += 10;
					}else if(senha.length > 7){
						forca += 25;
					}

					if((senha.length >= 5) && (senha.match(/[a-z]+/))){
						forca += 10;
					}

					if((senha.length >= 6) && (senha.match(/[A-Z]+/))){
						forca += 20;
					}

					if((senha.length >= 7) && (senha.match(/[!@#$%&*;?]/))){
						forca += 25;
					}

					/*if(senha.match(/([1-9]+)\1{1,}/)){
						forca += -25;
					}*/

					mostrarForca(forca);

				});
				
			});

			function mostrarForca(forca){
				//document.getElementById("impForcaSenha").innerHTML = "Força: " + forca;

				if (forca == 0) {
					document.getElementById("erroSenhaForca").innerHTML = "";
				}
				if(forca > 1 && forca < 30 ){
					document.getElementById("erroSenhaForca").innerHTML = "<div><span style='color: #ff0000'>Fraca</span><hr style='border-color: #ff0000; text-align: left;' class='col-2'></div>";
				}else if((forca >= 30) && (forca < 50)){
					document.getElementById("erroSenhaForca").innerHTML = "<div><span style='color: #FF8C00'>Média</span><hr style='border-color: #FF8C00' class='col-4'></div>";
				}else if((forca >= 50) && (forca < 70)){
					document.getElementById("erroSenhaForca").innerHTML = "<div><span style='color: #0000FF'>Forte</span><hr style='border-color: #0000FF' class='col-8'></div>";
				}else if((forca >= 70) && (forca < 100)){
					document.getElementById("erroSenhaForca").innerHTML = "<div><span style='color: #008000'>Segura</span><hr style='border-color: #008000' class='col-11'></div>";
				}
			}

			//mascara cnpj

			$(document).ready(function () { 
				var $CampoCnpj = $("#cnpj");
				$CampoCnpj.mask('00.000.000/0000-00', {reverse: true});
			});

		</script>

	</head>
	<body>
		<?php include('header.php') ?>

		<section><!-- inicio cadastro pj  -->
			
			<div class="container">    
				<div class="row">

					<div class="card-principal">
						<div class="card">
							<div class="card-header">
								<h4> Cadastro pessoa Jurídica </h4>
							</div>
							
							<div class="card-body">
								
								<div class="card mb-3 bg-light">

									<div class="card-body">
										
										<form method="post" action="registro_pj.php">
											<div class="form-group col-md-6">
												<label>Nome do Proprietario:</label>
												<input type="text" placeholder="" class="form-control" id="nome_prop" name="nome_prop" required="requiored">
											</div>
											<div class="form-group col-md-6">
												<label>Sobrenome:</label>
												<input type="text" placeholder="" class="form-control" id="sobrenome_prop" name="sobrenome_prop" required="requiored">
											</div>
											<div class="form-group col-md-6">
												<label>Nome do Estabelecimento:</label>
												<input type="text" placeholder="" class="form-control" id="nome_pj" name="nome_pj" required="requiored">
											</div>   
											<div class="form-group col-md-6">
												<label>email:</label>
												<input type="email" placeholder=""  class="form-control" id="email" name="email" required="requiored">
												<?php
												if($erro_email){
													echo '<font style="color:#FF0000"> Este email já existe</font>';
												}
												?>
											</div> 
											<div class="form-group col-md-6">
												<label>CNPJ:</label>
												<input type="text" maxlength="18"  class="form-control" id="cnpj" name="cnpj" required="requiored">

												<?php
												if($erro_cnpj){
													echo '<font style="color:#FF0000"> Este CNPJ já existe</font>';
												}
												if($erro_cnpj2){
													echo '<font style="color:#FF0000"> Entre com um CNPJ válido</font>';
												}
												?>

											</div>
											<div class="form-group col-md-6">
												<label>Cidade:</label>
												<input type="text" placeholder="" class="form-control" id="cidade" name="cidade" required="requiored" >
											</div> 

											<div class="form-group col-md-6">
												<label>Senha:</label>
												<input type="password" minlength="8" maxlength="30" class="form-control forca_senha" id="senha" name="senha" required="requiored">
												
											</div>

											<div class="col-md-6 ">
												<div id="impForcaSenha"></div>  
												<div id="erroSenhaForca"></div>  
											</div>

											<div class="form-group col-md-6 ">
												<label>Confirmar senha:</label>
												
												<input type="password" minlength="8" maxlength="30" class="form-control" id="senha2" name="senha2" required="requiored" >
												<?php 
												if ($erro_senha == 1) {
													echo '<font style="color:#FF0000"> Erro na senha, tente novamente.</font>';
												}
												?>
											</div>
											
											<div class="col-sm-6 col-md-3 col-xl-2">
												<button type="submit" class="btn btn-primary form-control">Cadastrar
												</button>
											</div>
										</form>
									</div>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
		</section><!-- fim cadastro pj --> 
		
		<?php include('footer.php') ?>              
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


	</body>	
	</html>