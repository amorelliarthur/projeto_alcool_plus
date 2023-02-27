<!--Desenvolvido por Arthur Amorelli-->
<?php

require_once('db.class.php');

$nome_prop = $_POST['nome_prop'];
$sobrenome_prop = $_POST['sobrenome_prop'];
$nome_pj = $_POST['nome_pj'];
$email = $_POST['email'];
$cnpj = $_POST['cnpj'];
$cidade = $_POST['cidade'];
$password = $_POST['senha'];
$senha = md5($password);
$senha2 = md5($_POST['senha2']);

$objDb = new db();
$link = $objDb -> conecta_mysql();

if (strlen($cnpj) < 14) {
	$erro_cnpj2.="erro_cnpj2=1&";
	header('location: cadastro_pj.php?'.$erro_cnpj2);
	die();
}

	//confirmação da senha
$erro_senha = "";

if ($senha != $senha2) {
	$erro_senha.="erro_senha=1&";
	header('location: cadastro_pj.php?'.$erro_senha);
	die();
}

	// verificar se cnpj já existe

$cnpj_existe = false;

$sql = "SELECT * from tb_pj where cnpj = '$cnpj'";
if($resultado_id = mysqli_query($link,$sql)){

	$dados_estabelecimento = mysqli_fetch_array($resultado_id);

	if (isset($dados_estabelecimento['cnpj'])) {
		$cnpj_existe = true;
	}

} else{
	echo 'Erro ao tentar localizar o registro de estabelecimento';
}

if($cnpj_existe){

	$retorno_get = '';

	if($cnpj_existe){
		$retorno_get.="erro_cnpj=1&";
	}

	header('location: cadastro_pj.php?'.$retorno_get);
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

	header('location: cadastro_pj.php?'.$retorno_get_email);
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
	header('location: cadastro_pj.php?pass=1');
	die();
	}



$pass = urlencode($password);

		//INICIA O CURL
$curl = curl_init();

$urlWebservice='https://moodle.inatel.br/eadinatel/arthur/webservice/rest/server.php?wstoken=cfc9b0796d320149f5cd81afcb0f729d&wsfunction=core_user_create_users&moodlewsrestformat=json&users[0][username]='.$email.'&users[0][password]='.$pass.'&users[0][firstname]='.$nome_prop.'&users[0][lastname]='.$sobrenome_prop.'&users[0][email]='.$email.'';
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
$id_estudante= $json[0][id];
		/*		
		var_dump($json);
		echo '<pre>';
		print_r($json);
		echo '<pre>';
		
		echo '<pre>';
		print_r(curl_getinfo($curl));
		echo '<pre>';
		*/
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

		$urlWebservice2='https://moodle.inatel.br/eadinatel/arthur/webservice/rest/server.php?wstoken=cfc9b0796d320149f5cd81afcb0f729d&wsfunction=enrol_manual_enrol_users&moodlewsrestformat=json&enrolments[0][roleid]=5&enrolments[0][userid]='.$id_estudante.'&enrolments[0][courseid]=4';
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


	$sql = "INSERT INTO tb_usuario(email, senha, nivel) VALUES ('$email', '$senha', '2') ";

	mysqli_query($link, $sql);

	$idUsuario = mysqli_insert_id($link);

	$sql = "INSERT INTO tb_pj(nome_prop, sobrenome_prop, nome_pj, cnpj, cidade, id_usuario) VALUES ('$nome_prop', '$sobrenome_prop', '$nome_pj','$cnpj', '$cidade', $idUsuario)";


	//executar a query

		if(mysqli_query($link, $sql)){

			header('location: cadastro_pj.php?sucesso=1');

		} else{
			echo "Erro ao registrar";
		}

	?>