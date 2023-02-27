<?php

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;


session_start();

$acesso = $_SESSION['nivel'];

if ($acesso != 2) {
	header('Location: index.php');
}

$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';

$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 4;

if($nivel == 3 || $nivel == 4){
	$cad = 1;
}else{
	$cad = 0;
}

$id_usuario = $_SESSION['id_usuario'];

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

		// mascara para valor
		
		$(document).ready(function()
		{
			$('#valor').mask('#.##0,00', {reverse: true});
		});

		
	</script>

</head>
<body>
	<?php include('header.php') ?>

	<section><!-- inicio cadastro produto  -->

		
		
		<div class="container">    
			<div class="row">

				<div class="card-principal">
					<div class="card">
						<div class="card-header">
							<h4> Cadastro produto </h4>
						</div>
						
						<div class="card-body">
							
							<div class="card mb-3 bg-light">

								<div class="card-body">
									<form enctype="multipart/form-data" method="post" action="registro_produto.php" id="formcadastrar">
										<div class="form-group col-md-6">
											<label>Produto:</label>
											<input type="text" placeholder="" class="form-control" id="nome" name="nome_produto" required="requiored">
										</div>    
										<div class="form-group col-md-6">
											<label>Valor:</label>
											<input type="text" placeholder=""  class="form-control" id="valor" name="valor" required="requiored">
										</div>
										
										<div class="form-group col-md-6">
											<label>Quantidade:</label>
											<input type="number" min="1" placeholder=""  class="form-control" id="quantidade" name="quantidade" required="requiored">
										</div>

										<div class="form-group col-md-6">
											<label>Descrição do produto:</label>
											<textarea type="text" maxlength="500" class="form-control" style="max-height:250px;" id="descricao" name="descricao" required="requiored"></textarea>
										</div>
										
										<span class="form-group col-md-6">
											<label>Imagem:</label>
										</span>

										<div class="form-group col-md-6">
											<input type="file" class="custom-file-input form-control ml-3 mr-3" id="imagem_produto" required="requiored" name="arquivo">
											<label class="custom-file-label ml-3 mr-3" for="imagem_produto">PNG ou JPG - Tamanho Max 2MB</label>
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

	</section> <!--  Fim cadastro produto -->
	
	<?php include('footer.php') ?>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


</body>	
</html>