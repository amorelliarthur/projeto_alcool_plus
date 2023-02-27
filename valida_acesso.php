<!--Desenvolvido por Arthur Amorelli-->
<?php

session_start();

require_once('db.class.php');

$email = $_POST['email'];
$senha = md5($_POST['senha']);
$inf = $_POST['inf'];
	//echo $inf;

$sql = "SELECT * FROM tb_usuario WHERE email = '$email' AND senha = '$senha'";

$objDb = new db();
$link = $objDb -> conecta_mysql();

$resultado_id = mysqli_query($link, $sql);

if($resultado_id){

	$dados_usuario = mysqli_fetch_array($resultado_id);

	if(isset($dados_usuario['email'])){
		
		$_SESSION['email'] = $dados_usuario['email'];
		$_SESSION['id_usuario'] = $dados_usuario['id_usuario'];
		$_SESSION['nivel'] = $dados_usuario['nivel'];
		$_SESSION['autenticado'] = 'SIM';

		header('location: index.php');

	} else{
		if ($inf == 0 || $inf == 1 || $inf == 5) {
			header('location: index.php?erro=1');
		}else if ($inf == 2) {
			header('location: pedidos.php?erro=1');
		}else if ($inf == 3) {
			header('location: cadastro_pf.php?erro=1');
		}else if ($inf == 4) {
			header('location: cadastro_pj.php?erro=1');
		}else if ($inf == 6) {
			header('location: cadastro_pf.php?erro=1');
		}
		
	}

} else {

	echo "Usuario não cadastrado!";
}


?>