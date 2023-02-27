<!--Desenvolvido por Arthur Amorelli-->
<?php
ini_set('display_errors', FALSE);

require_once('db.class.php');

$cidade = trim($_POST['cidade']);


$objDb = new db();
$link = $objDb -> conecta_mysql();

    // verificar se cidade existe

$sql = "SELECT * from tb_pj where cidade = '$cidade' ";
$resultado_id = mysqli_query($link, $sql);

   /* if(mysqli_num_rows($resultado_id) == 0){
        echo '<font style="color:#FF0000"> Erro ao tentar localizar o registro de cidade</font>';
        exit;
    }*/

    if($resultado_id){

        $dados_estabelecimento = array();

        while ($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)) {
            
            $dados_estabelecimento[] = $linha;
        }

        $retorna_est = '';
        
        foreach ($dados_estabelecimento as $estabelecimento) {
         
            
            $retorna_est.="<div class='card mb-3 bg-light'>
            <div class='card-body' >
            <h5 id='ofertas' class='card-title'>
            <a href='lista_produtos.php?id=".$estabelecimento[id_pj]."' target='_self'>" . $estabelecimento[nome_pj] . "</a>
            </h5>
            </div>
            </div>";
        }
        echo $retorna_est;

    }    

?>