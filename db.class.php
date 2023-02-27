<!--Desenvolvido por Arthur Amorelli-->
<?php

class db{

	// host
	private $host = 'localhost';
	//usuario
	private $usuario = 'root';
	//senha
	private $senha ='';
	//banco de dados
	private $database ='db_alcool';

	public function conecta_mysql(){

		//criar a conexao
		$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

		// ajusta o charset de comunicação entre a aplcação e o bd
		mysqli_set_charset($con, 'utf-8');

		//verificar se houve erro de conexao

		if(mysqli_connect_errno()){
			echo 'Erro ao tentar se conectar com o banco:' . mysqli_connect_error();
		}

		return $con;

	}
}	

?>