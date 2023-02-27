<!--Desenvolvido por Arthur Amorelli-->
<?php

require_once('db.class.php');

session_start();

$id_pj = isset($_POST['id_pj']) ? $_POST['id_pj'] : 0;
$id_produto = isset($_POST['id_produto']) ? $_POST['id_produto'] : 0;
$valor = isset($_POST['valor']) ? $_POST['valor'] : 0;
$quantidade_produto = isset($_POST['quantidade']) ? $_POST['quantidade'] : 0;
$id_usuario = $_SESSION['id_usuario']; 
$quantidade_compra = $_POST['quantidade_compra'];


$valor_compra = $quantidade_compra*$valor;

$objDb = new db();
$link = $objDb -> conecta_mysql();

	//verificar se pf existe

$sql = "SELECT * from tb_pf where id_usuario = $id_usuario";
if($resultado_id = mysqli_query($link,$sql)){

	$dados_pf = mysqli_fetch_array($resultado_id);

	if (isset($dados_pf['id_pf'])) {
		$id_pf = $dados_pf['id_pf'];
		$ultima_compra = $dados_pf['ultima_compra'];
		$prioridade = $dados_pf['prioridade'];

	}else{
		header('location: cadastro_pf.php?');
		die();
	}
} else{
	header('location: cadastro_pf.php?');
	die();
}

	//verificar compra 15/15	

$compra = 0;
if ($ultima_compra == 0) {
	$ultima_compra = strtotime(date('Y/m/d'));
	$compra = 1;
}else{
	$data_atual = strtotime(date('Y/m/d'));
		//echo 'data atual:'.$data_atual.'<br>';
		//echo 'ultima compra:'.$ultima_compra.'<br>';
	$prox_compra = ($ultima_compra + 1296000);
	$prox_compra_seg = $prox_compra - $data_atual;
	$prox_compra_dia = ($prox_compra_seg/86400);
		//echo 'data prox compra:'.$prox_compra.'<br>';
		//echo 'data prox compra:'.$prox_compra_seg.'<br>';
	if ($prox_compra_dia <= 0) {
		$compra = 1;
		$ultima_compra = strtotime(date('Y/m/d'));
	}else{
		$prox_compra_seg = $prox_compra - $data_atual;
		$prox_compra_dia = ($prox_compra_seg/86400);
		header('location: pedidos.php?prox_compra_dia='.$prox_compra_dia);			
		die();
	}		
}

	//verificar se há prioridade para compra

$prio = 0;
if ($quantidade_produto >= 5) {
	$prio = 1;
}else if ($quantidade_produto == 4 && $prioridade >= 1) {
	$prio = 1;
}else if ($quantidade_produto == 3 && $prioridade >= 2) {
	$prio = 1;
}else if($quantidade_produto == 2 && $prioridade >= 3){
	$prio = 1;
}else if ($quantidade_produto == 1 && $prioridade == 4) {
	$prio = 1;
	$quantidade_compra = 1;
}else{
	header('location: pedidos.php?prioridade=2&');			
	die();
}

if($compra == 1 && $prio == 1){

	$sql = "INSERT INTO tb_pedido(id_pf, id_pj, id_produto, quantidade, valor) VALUES ($id_pf, $id_pj, $id_produto, $quantidade_compra, $valor_compra)";

	mysqli_query($link, $sql);

	$sql = "UPDATE tb_pf SET ultima_compra = $ultima_compra where id_pf = $id_pf ";

	mysqli_query($link, $sql);

	$nova_quantidade = $quantidade_produto - $quantidade_compra;
	
	$sql = "UPDATE tb_produto SET quantidade = $nova_quantidade where id_produto = $id_produto ";
	
		//executar a query

	if(mysqli_query($link, $sql)){

		header('location: pedidos.php?');

	} else{
		echo "Erro ao registrar o pedido";
	}
}
?>