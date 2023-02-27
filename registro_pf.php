<!--Desenvolvido por Arthur Amorelli-->
<?php

require_once('db.class.php');

$nome_pf = $_POST['nome_pf'];
$sobrenome_pf = $_POST['sobrenome_pf'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$cidade = $_POST['cidade'];
$autenticado = isset($_SESSION['autenticado']) ? $_SESSION['autenticado'] : 'NAO';
$hipertensao = isset($_POST['hipertensao']) ? 's' : 'n';
$asma = isset($_POST['asma']) ? 's' : 'n';
$diabet = isset($_POST['diabet']) ? 's' : 'n';
$fuma = isset($_POST['fuma']) ? 's' : 'n';
$password = $_POST['senha'];
$senha = md5($password);
$senha2 = md5($_POST['senha2']);

$objDb = new db();
$link = $objDb -> conecta_mysql();

if (strlen($cpf) < 14) {
	$erro_cpf2.="erro_cpf2=1&";
	header('location: cadastro_pf.php?'.$erro_cpf2);
	die();
}

	//confirmação da senha
$erro_senha = "";

if ($senha != $senha2) {
	$erro_senha.="erro_senha=1&";
	header('location: cadastro_pf.php?'.$erro_senha);
	die();
}

$prioridade = 0;

if ($hipertensao == 's') {
	$prioridade = ++$prioridade;
}
if ($asma == 's') {
	$prioridade = ++$prioridade;
}
if ($diabet == 's') {
	$prioridade = ++$prioridade;
}	
if ($fuma == 's') {
	$prioridade = ++$prioridade;
}

	// verificar se cpf já existe

$cpf_existe = false;

$sql = "SELECT * from tb_pf where cpf = '$cpf'";
if($resultado_id = mysqli_query($link,$sql)){

	$dados_usuario = mysqli_fetch_array($resultado_id);

	if (isset($dados_usuario['cpf'])) {
		$cpf_existe = true;
	}

} else{
	echo 'Erro ao tentar localizar o registro de usuário';
}

if($cpf_existe){

	$retorno_get = '';

	if($cpf_existe){
		$retorno_get.="erro_cpf=1&";
	}

	header('location: cadastro_pf.php?'.$retorno_get);
	die();
}

	//verificar se email ja existe.
$email_existe = false;
$sql = "SELECT * from tb_usuario where email = '$email'";
if($resultado_id = mysqli_query($link,$sql)){

	$dados_usuario = mysqli_fetch_array($resultado_id);

	if (isset($dados_usuario['email'])) {
		$email_existe = true;
	}

} else{
	echo 'Erro ao tentar localizar o registro';
}

if($email_existe){

	$retorno_get_email = '';

	if($email_existe){
		$retorno_get_email.="erro_email=1&";
	}

	header('location: cadastro_pf.php?'.$retorno_get_email);
	die();
}

	// verifica força da senha
	$forca = 0;

	if(strlen($password) >= 4 && strlen($password) <= 7){
		$forca +=  10;
	}else if(strlen($password) > 7){
		$forca += 25;
	}

	if (strlen($password) >= 5 && preg_match('/[a-z]/', $password)) {
		$forca += 10;
	}
	if (strlen($password) >= 6 && preg_match('/[A-Z]/', $password)) {
		$forca += 20;
	}
	if (strlen($password) >= 7 && preg_match('/[!@#$%&*;?]/', $password)) {
		$forca += 25;
	}

	if ($forca < 70) {
		header('location: cadastro_pf.php?pass=1');
		die();
	}


$pass = urlencode($password);
//$username = strtolower($nome_pf).strtolower($sobrenome_pf);
 
	//INICIA O CURL ------ core_user_create_users
$curl = curl_init();

$urlWebservice='https://moodle.inatel.br/eadinatel/arthur/webservice/rest/server.php?wstoken=cfc9b0796d320149f5cd81afcb0f729d&wsfunction=core_user_create_users&moodlewsrestformat=json&users[0][username]='.$email.'&users[0][password]='.$pass.'&users[0][firstname]='.$nome_pf.'&users[0][lastname]='.$sobrenome_pf.'&users[0][email]='.$email.'';
$useragent = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36";

	//echo $urlWebservice . '<br>';

	//DEFINE AS CONFIG
curl_setopt_array($curl, [
	CURLOPT_URL            => $urlWebservice,
	CURLOPT_CUSTOMREQUEST  => "POST",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_USERAGENT      => $useragent,
	CURLOPT_SSL_VERIFYPEER => false		

]);

	//EXECUTA A REQUISIÇÃO
$response = curl_exec($curl);
$json = json_decode($response, true);
	/*
	//echo stripslashes($response);
	var_dump($json);
	echo '<pre>';
	print_r($json);
	echo '<pre>';
	/*
	echo '<pre>';
	print_r(curl_getinfo($curl));
	echo '<pre>';
	*/

	$id_estudante= $json[0][id];

	if($errno = curl_errno($curl)) {
		$error_message = curl_strerror($errno);
		echo "<br>"."cURL error ({$errno}):\n {$error_message}";
	}else{
		//echo "<br>"."nao houve erro! <br>";
	}
    
	//FECHA A CONEXÃO
	curl_close($curl);


	//INICIA O CURL ------ enrol_manual_enrol_users
	$ch = curl_init();

	$urlWebservice2='https://moodle.inatel.br/eadinatel/arthur/webservice/rest/server.php?wstoken=cfc9b0796d320149f5cd81afcb0f729d&wsfunction=enrol_manual_enrol_users&moodlewsrestformat=json&enrolments[0][roleid]=5&enrolments[0][userid]='.$id_estudante.'&enrolments[0][courseid]=3';
	$useragent = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36";

	//DEFINE AS CONFIG
	curl_setopt_array($ch, [
		CURLOPT_URL            => $urlWebservice2,
		CURLOPT_CUSTOMREQUEST  => "POST",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_USERAGENT      => $useragent,
		CURLOPT_SSL_VERIFYPEER => false		

	]);

	//EXECUTA A REQUISIÇÃO
	$resposta = curl_exec($ch);
	$json2 = json_decode($resposta, true);
	
	//FECHA A CONEXÃO
	curl_close($ch);


$sql = "INSERT INTO tb_usuario(email, senha, nivel) VALUES ('$email', '$senha', '1') ";

mysqli_query($link, $sql);

$idUsuario = mysqli_insert_id($link);


$sql = "INSERT INTO tb_pf(nome_pf,sobrenome_pf, cpf, cidade, hipertensao, asma, diabet, fuma, prioridade, id_usuario) VALUES ('$nome_pf', '$sobrenome_pf', '$cpf', '$cidade', '$hipertensao', '$asma', '$diabet', '$fuma', '$prioridade',$idUsuario) ";


	//executar a query
if(mysqli_query($link, $sql)){

	header('location: cadastro_pf.php?sucesso=1');
		
	} else{
		echo "Erro ao registrar";
	}

	?>

