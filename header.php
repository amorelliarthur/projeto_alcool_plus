<?php 
$url = "$_SERVER[REQUEST_URI]";
$index = "index.php";
$pedidos = "pedidos.php";
$cadastro_pf = "cadastro_pf.php";
$cadastro_pj = "cadastro_pj.php";
$lista_produtos = "lista_produtos.php";
$finalizar_compra = "finalizar_compra.php";
$inf = 0;

if (mb_strpos($url, $index, 9) == true) {
	$inf = 1;
}else if (mb_strpos($url, $pedidos, 9) == true) {
	$inf = 2;
}else if (mb_strpos($url, $cadastro_pf, 9) == true) {
	$inf = 3;
}else if (mb_strpos($url, $cadastro_pj, 9) == true) {
	$inf = 4;
}else if (mb_strpos($url, $lista_produtos, 9) == true) {
	$inf = 5;
}else if (mb_strpos($url, $finalizar_compra, 9) == true) {
	$inf = 6;
}


?>
<header><!-- inicio cabeçalho -->
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">

		<div class="container">

			<a href="index.php" class="navbar-brand"><img src="img/Alcool.png" width="140"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alterna navegação">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="nav_top navbar-nav ml-auto mt-2 mt-lg-0">
					<li class="nav_top nav-item">
						<a href="pedidos.php">Pedidos</a>
					</li>
					<li class="nav_top nav-item dropdown" <?= $nivel == 1 ? 'style="display:none"': '' ?>>
						<a class=" dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Cadastro
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" <?= $cad != 1 ? 'style="display:none"': '' ?> href="<?= $cad == 1 ? 'cadastro_pf.php': '#' ?>">Pessoa física</a>
							<a class="dropdown-item" <?= $cad != 1 ? 'style="display:none"': '' ?> href="<?= $cad == 1 ? 'cadastro_pj.php': '#' ?>">Pessoa Jurídica</a>
							<!--<div class="dropdown-divider"></div> -->
							<a class="dropdown-item" <?= $nivel != 2 ? 'style="display:none"': '' ?> href="<?= $nivel != 2 ? '#': 'cadastro_produto.php' ?>">Produtos</a>
							
						</div>
					</li>
					<?php 

					if ($autenticado == 'NAO') { ?>
						
						<li class="nav_top nav-item dropdown">
							<a class="dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Login
							</a>
							<form method="post" action="<?= $autenticado != 'SIM' ? 'valida_acesso.php?' : ''  ?>" class="dropdown-menu p-2 dropdown-menu-right " style="width: 300px;">
								<div class="form-group" <?= $autenticado == 'SIM' ? 'style="display: none"' : '' ?>>
									<label>Endereço de email</label>
									<input name="email" type="email" class="form-control" id="email" placeholder="email@exemplo.com" required="requiored">
								</div>
								<div class="form-group" <?= $autenticado == 'SIM' ? 'style="display: none"' : '' ?>>
									<label>Senha</label>
									<input name="senha" type="password" class="form-control" id="senha" placeholder="Senha" required="requiored">
								</div>
								<input type="hidden" name="inf" value="<?= $inf ?>">
								
								<button type="submit" class="btn btn-primary form-control" <?= $autenticado == 'SIM' ? 'style="display: none"' : '' ?> id="btn_login">Entrar</button>								
							</form>
						</li>

					<?php }else{ ?>

						<li class="nav_top nav-item">
							<a href="logoff.php">LOGOUT</a>
						</li>

					<?php  }

					?>
					
				</ul>

				<font color="#6495ED"><?= $email_usuario ?></font>	
				
			</div>
		</div>
	</nav>

	<?php 

	if ($erro == 1) { ?>
		<div class="alert alert-warning alert-dismissible fade show container mt-1" role="alert">
			<strong>Falha de login!</strong> Usuário e ou senha inválido(s).
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }

	?>

	<?php 

	if ($sucesso == 1) { ?>
		<div class="alert alert-success alert-dismissible fade show container mt-1" role="alert">
			<strong>Feito!</strong> Usuário cadastrado com sucesso!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }else if ($sucesso == 2) { ?>
		<div class="alert alert-success alert-dismissible fade show container mt-1" role="alert">
			<strong>Feito!</strong> Produto cadastrado com sucesso!
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }else if ($sucesso == 3) { ?>
		<div class="alert alert-danger alert-dismissible fade show container mt-1" role="alert">
			<strong>Falha!</strong> Imagem muito grande! Max: 2MB
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }else if ($sucesso == 4) { ?>
		<div class="alert alert-danger alert-dismissible fade show container mt-1" role="alert">
			<strong>Falha!</strong> Erro ao salvar imagem.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }else if ($sucesso == 5) { ?>
		<div class="alert alert-danger alert-dismissible fade show container mt-1" role="alert">
			<strong>Falha!</strong> Apenas arquivos .jpg ou .png
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }

	if ($pass == 1) { ?>
		<div class="alert alert-danger alert-dismissible fade show container mt-1" role="alert">
			<strong>Falha!</strong> Entre com uma senha segura.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php }

	?>

</header><!-- fim cabeçalho -->


