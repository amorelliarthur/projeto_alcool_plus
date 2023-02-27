<?php
$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
session_start();

$email_usuario = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 4;
$sucesso = isset($_GET['sucesso']) ? $_GET['sucesso'] : 0;

if($nivel == 3 || $nivel == 4){
	$cad = 1;
}else{
	$cad = 0;
}

require_once('db.class.php');

$objDb = new db();
$link = $objDb -> conecta_mysql();

ini_set('display_errors', FALSE);

$itens_por_pag = 6;

$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
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

		function ListaE(){
			$.post("lista_estabelecimentos.php",{cidade: $('#cidades option:selected').text()},function(data){
				$('#ofertas').html(data);
			});
		}

		/*$(document).ready(() => {
			
			$('#btn_edita').on('click', (e) => {
				e.preventDefault();
				$('#div_edita').slideToggle();
			})
			
		})*/

		function mostrarDetalhes(id){
			$('#produto' + id).slideToggle();
		}

		// mascara para valor
		
		$(document).ready(function()
		{
			$('.preco').mask('#.##0,00', {reverse: true});
		});

		</script>

	</head>
	<body>

		<?php include('header.php') ?>

		<section><!-- inicio ofertas -->
			
			<div class="container">

				<div class="row">

					<?php 

					if($nivel == 1 || $nivel == 4){ ?>

						<div class="card-principal">
							<div class="card">
								<div class="card-header">
									<h4> Lojas </h4>
								</div>
								
								<div class="card-body">

									<form class="input-group-apend ">

										<?php

										require_once('db.class.php');
										
										$objDb = new db();
										$link = $objDb -> conecta_mysql();

										$sql = "SELECT * FROM tb_pj group by cidade";

										$resultado_id = mysqli_query($link, $sql);

										?>

										<select id="cidades" class="form-control col-sm-6" name="cidades" style="margin-bottom: 20px;" onchange="ListaE()">
											<option>-- Selecione a cidade --</option>
											<?php 
											while ($linha = mysqli_fetch_array($resultado_id)){
												$cidade = $linha['cidade'];
												echo "<option value='$cidade'> $cidade</option>";
											}
											?>
										</select>

									</form>

									<div id='ofertas'></div>

								</div>

							</div>
						</div>

						<?php 

					}else if ($nivel == 2) {?>

						<div class="card-principal">
							<div class="card">
								<div class="card-header">
									<h4> Produtos </h4>
								</div>

								<div class="card-body"><?php
								
								$sql = "SELECT * from tb_pj where id_usuario = $id_usuario";
								if($resultado_id = mysqli_query($link,$sql)){
									$dados_pj = mysqli_fetch_array($resultado_id);
									$id_pj = $dados_pj['id_pj'];
								}

								$sql = "SELECT * from tb_produto where id_pj = $id_pj group by id_produto desc";
								if($resultado_id = mysqli_query($link,$sql)){
									$produtos = "";
									$contproduto = 1;
									while ($linha = mysqli_fetch_array($resultado_id)) {

										$valor = str_replace(".",",", $linha[valor]);
										$produtos.='<div class="card mb-3 bg-light">
										<form method="post" action="exclui_registro.php?&inf=1">
										<div class="card-body">
										
										<h5 class="card-title">'.$linha[nome_produto].'</h5>
										<h6 class="card-subtitle mb-2 text-muted">'.$linha[quantidade].' unidades</h6>
										<p class="card-text">Valor: R$ '.$valor.'</p>	
										<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />
										
										</div>
										
										<div class="row  m-1">
										<div class="col-sm-6 col-md-3 col-xl-2 pb-2">
										
										<button type="submit" class="btn btn-danger form-control"> Excluir </button>
										</div>
										
										<div class="col-sm-6 col-md-3 col-xl-2">
										<button type="button" class="btn btn-primary form-control" id="btn_edita2" onclick="mostrarDetalhes('.$contproduto.')">
										Editar
										</button><br><br>
										</div>	
										</div>
										</form>															
										<div class="card-body" id="produto'.$contproduto.'" style="display:none">
										<div class="card">																	
										<div class="card-body">
										<form enctype="multipart/form-data" method="post" action="edita_registro.php?&inf=1">
										<div class="form-group col-md-6">
										<label>Produto:</label>
										<input type="text" value="'.$linha[nome_produto].'" class="form-control" name="nome_produto" required="requiored">
										</div>    
										<div class="form-group col-md-6">
										<label>Valor:</label>
										<input type="numeric" value="'.$valor.'"  class="form-control preco" name="valor" required="requiored">
										</div>
										
										<div class="form-group col-md-6 col-xl-6">
										<label>Quantidade:</label>
										<input type="number" min="1" value="'.$linha[quantidade].'"  class="form-control"  name="quantidade" required="requiored">
										</div>
										<div class="form-group col-md-6">
										<label>Descrição do produto:</label>
										<textarea type="text" maxlength="500" value="'.$linha[descricao].'" class="form-control" style="max-height:250px;" id="descricao" name="descricao" ></textarea>
										
										</div>
										
										<span class="form-group col-md-6">
										<label>Imagem:</label>
										</span>

										<div class="form-group col-md-6">
										<input type="file"  class="custom-file-input form-control ml-3 mr-3" id="imagem_produto" name="arquivo">
										<label class="custom-file-label ml-3 mr-3" for="imagem_produto">PNG ou JPG - Tamanho Max 2MB</label>
										</div>		
										<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />		                  						               
										
										<div class="col-sm-6 col-md-3 col-xl-2">
										<button type="submit" class="btn btn-success form-control">Salvar                     
										</button> 
										
										</div>
										</form>
										</div>
										</div>
										</div>
										
										</div>';

										$contproduto++;
										
									}
									echo $produtos; 
									
								}

							}else if ($nivel == 3) { ?>
								<div class="card-principal">
									<div class="card">
										<div class="card-header" id="nav-tab" role="tablist">
											<ul class="nav nav-tabs card-header-tabs justify-content-center">
												<li class="nav-item">
													<a class="nav-link active" id="nav-cliente-tab" data-toggle="tab" href="#nav-cliente" role="tab" aria-controls="nav-cliente">CLIENTES</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="nav-estab-tab" data-toggle="tab" href="#nav-estab" role="tab" aria-controls="nav-estab">ESTABELECIMENTOS</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="nav-produto-tab" data-toggle="tab" href="#nav-produto" role="tab" aria-controls="nav-produto">PRODUTOS</a>
												</li>							      
											</ul>
										</div>

										<div class="tab-content" id="nav-tabContent">
											<div class="card-body tab-pane fade show active" id="nav-cliente" role="tabpanel" aria-labelledby="nav-cliente-tab">
												
												<?php 

												$sql = "SELECT * from tb_pf group by id_pf desc";
												if($resultado_id = mysqli_query($link,$sql)){		
													
													while ($linha = mysqli_fetch_array($resultado_id)) {

														$clientes.='<div class="card mb-3 bg-light">
														<div class="card-body">
														<h6 class="card-subtitle mb-2 text-muted">ID: '.$linha[id_pf].'</h6>
														<h5 class="card-title">'.$linha[nome_pf].'</h5>
														<h6 class="card-subtitle mb-2">CPF: '.$linha[cpf].'</h6>
														<h6 class="card-subtitle mb-2"> Cidade: '.$linha[cidade].'</h6>
														<h6 class="card-subtitle mb-2">Prioridade de compra: '.$linha[prioridade].'</h6>
														
														</div>
														<form method="post" action="exclui_registro.php?&inf=2">
														<div class="row m-2">
														
														<input type="hidden" name="id_pf" value="'.$linha[id_pf].'" />
														<input type="hidden" name="id_usuario" value="'.$linha[id_usuario].'" />
														<div class="col-sm-12 col-md-3 col-xl-2 mb-2 mb-2">
														
														<button type="submit" class="btn btn-danger form-control"> Excluir </button>
														</div>
														</form>	
														</div>
														</form>
														</div>';								            
													}
													
													echo $clientes;										
													
												}
												?>
												
											</div>

											<div class="card-body tab-pane fade" id="nav-estab" role="tabpanel" aria-labelledby="nav-estab-tab">
												
												<?php 

												$sql = "SELECT * from tb_pj group by id_pj desc";
												if($resultado_id = mysqli_query($link,$sql)){		
													
													while ($linha = mysqli_fetch_array($resultado_id)) {

														$pj.='<div class="card mb-3 bg-light">
														<div class="card-body">
														<h6 class="card-subtitle mb-2 text-muted">ID: '.$linha[id_pj].'</h6>
														<h5 class="card-title">'.$linha[nome_pj].'</h5>
														<h6 class="card-subtitle mb-2">CNPJ: '.$linha[cnpj].'</h6>
														<h6 class="card-subtitle mb-2"> Cidade: '.$linha[cidade].'</h6>
														
														</div>
														<form method="post" action="exclui_registro.php?&inf=4">
														<input type="hidden" name="id_pj" value="'.$linha[id_pj].'" />
														<input type="hidden" name="id_usuario" value="'.$linha[id_usuario].'" />
														<div class="row m-2">
														<div class="col-sm-12 col-md-3 col-xl-2 mb-2 mb-2">
														<button type="submit" class="btn btn-danger form-control"> Excluir </button>
														</div>
														
														</div>
														</form>
														</div>';								            
													}
													
													echo $pj;										
													
												}
												?>

											</div>

											<div class="card-body tab-pane fade" id="nav-produto" role="tabpanel" aria-labelledby="nav-produto-tab">
												
												<?php 

												$sql = "SELECT * from tb_produto, tb_pj where tb_produto.id_pj = tb_pj.id_pj group by id_produto desc";
												if($resultado_id = mysqli_query($link,$sql)){		
													
													while ($linha = mysqli_fetch_array($resultado_id)) {

														$produto.='<div class="card mb-3 bg-light">
														<div class="card-body">
														<h6 class="card-subtitle mb-2 text-muted">ID: '.$linha[id_produto].'</h6>
														<h5 class="card-title">'.$linha[nome_produto].'</h5>
														<h5 class="card-title">'.$linha[nome_pj].'</h5>
														<h6 class="card-subtitle mb-2">CNPJ: '.$linha[cnpj].'</h6>
														<h6 class="card-subtitle mb-2"> Cidade: '.$linha[cidade].'</h6>
														<h6 class="card-subtitle mb-2 text-muted"> Unidades: '.$linha[quantidade].'</h6>
														
														</div>
														<form method="post" action="exclui_registro.php?&inf=1">
														<input type="hidden" name="id_produto" value="'.$linha[id_produto].'" />
														<div class="row m-2">
														<div class="col-sm-12 col-md-3 col-xl-2 mb-2 mb-2">
														<button type="submit" class="btn btn-danger form-control"> Excluir </button>
														</div>
														</form>	
														</div>
														</div>';								            
													}
													
													echo $produto;										
													
												}
												?>

											</div>
											
										</div>
									</div>
								</div>	

							<?php }

							?>

						</div>
					</div>
				</div>
				<?php ?>		          
			</div>
		</div>
	</section><!-- fim ofertas -->
	
	<section>
		<div class="container">
			
			<?php 
			ini_set('display_errors', FALSE);			            		
			if ($nivel == 1) {
				
				$sql = "SELECT * FROM tb_pf where id_usuario = $id_usuario";
				if($resultado_id = mysqli_query($link,$sql)){
					$dados_estabelecimento = mysqli_fetch_array($resultado_id);
					$cidade = trim($dados_estabelecimento['cidade']);
				}?>

				<div class="row">
					<div class="card-principal">
						<div class="card">
							<div class="card-header"><h5>Principais ofertas em <?= $cidade ?></h5></div>
							<div class="card-body"> 
								<div class="card-columns"><?php 



								$sql = "SELECT * from tb_produto, tb_pj where tb_produto.id_pj=tb_pj.id_pj and tb_pj.cidade =  '".$cidade."' group by tb_produto.id_produto";
								$produtos = mysqli_query($link,$sql);

								$row_cnt = mysqli_num_rows($produtos);													
													$num_pags = ceil($row_cnt/$itens_por_pag); // define o numero de pag.
													$inicio = $itens_por_pag*$pag-$itens_por_pag;

													//echo "quantidade no banco: ". $row_cnt."<br/>";
													//echo "num pag: ". $num_pags."<br/>";
													//echo "inicio: ". $inicio."<br/>";	

													$sql = "SELECT * from tb_produto, tb_pj where tb_produto.id_pj=tb_pj.id_pj and tb_pj.cidade =  '".$cidade."' group by tb_produto.id_produto limit ".$inicio." , ".$itens_por_pag." ";
													

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
																<h6 class="card-title">'.$linha[nome_pj].' </a></h6>										  
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

												<nav>
													<ul class="pagination pagination-sm justify-content-center">
														<li class="page-item <?= $num_pags < 2 || $pag == 1 ? 'disabled' : '' ?>" >
															<a class="page-link" href="index.php?pag=1">Início</a>
														</li>
														<?php for ($i=1; $i < $num_pags+1 ; $i++) { ?>
															
															<li class="page-item <?= $pag == $i ? "active" : "" ?>"><a class="page-link" href="index.php?pag=<?= $i; ?>"><?= $i; ?></a></li>

														<?php } ?>
														
														<li class="page-item <?= $num_pags < 2 || $pag == $num_pags ? 'disabled' : '' ?>" >
															<a class="page-link" href="index.php?pag=<?= $num_pags ?>">Fim</a>
														</li>
													</ul>
												</nav>

											</div>
										</div>	            		
									</div>	            	
								</div>
							</div>
						<?php }?>
					</section>

					<?php include('footer.php') ?> 
					
					
					<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
					<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


				</body>	

				</html>