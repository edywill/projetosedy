<?php 
//Colocar link para conexão com o banco
require ("conexaobd/conectbd.php");

$sqlUsers = "SELECT * FROM email";
$queryUsers = pg_query($sqlUsers);
$sqlInfo = "SELECT * FROM info";
$queryInfo = pg_query($sqlInfo);

$file_path = 'exportdnitmovel.csv';
$dados='';
$dados.="//Dados de usuarios\n";
$dados.="TRUNCATE TABLE email;\n";
while($objUsers=pg_fetch_object($queryUsers)){
	$dados.="INSERT INTO email(id_email,email,ip,nome,telefones,obs,cod,dt,enviado,alloy_id,desativado) VALUES(".trim($objUsers->id_email).",'".trim($objUsers->email)."','".trim($objUsers->ip)."','".trim($objUsers->nome)."','".trim($objUsers->telefones)."','".trim($objUsers->obs)."','".trim($objUsers->cod)."','".trim($objUsers->dt)."','".trim($objUsers->enviado)."','".trim($objUsers->alloy_id)."','".trim($objUsers->desativado)."');\n";
	}
$dados.="//Dados de Ocorrencias\n";
$dados.="TRUNCATE TABLE info;\n";
while($objInfo=pg_fetch_object($queryInfo)){
	$dados.="INSERT INTO info(id,lat,long,alt,dist,a1,a2,a3,a5,a6,a7,a9,a10,a11,rod,km,uf,dt,foto,cod,enviado,alloy_id,av,tel) VALUES(".trim($objInfo->id).",'".trim($objInfo->lat)."','".trim($objInfo->long)."','".trim($objInfo->alt)."','".trim($objInfo->dist)."',".trim($objInfo->a1).",".trim($objInfo->a2).",".trim($objInfo->a3).",".trim($objInfo->a5).",".trim($objInfo->a6).",".trim($objInfo->a7).",".trim($objInfo->a9).",".trim($objInfo->a10).",".trim($objInfo->a11).",'".trim($objInfo->rod)."','".trim($objInfo->km)."','".trim($objInfo->uf)."','".trim($objInfo->dt)."','".trim($objInfo->foto)."',,'".trim($objInfo->cod)."',".trim($objInfo->enviado).",,'".trim($objInfo->alloy_id)."','".trim($objInfo->av)."','".trim($objInfo->tel)."');\n";
	}
if(fwrite($file=fopen($file_path,'w+'),$dados)) {  
fclose($file);  
set_time_limit(0);
$aquivoNome = $file_path;
$arquivoLocal = $aquivoNome; 

$novoNome = $aquivoNome;

// Configuramos os headers que serão enviados para o browser
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="'.$novoNome.'"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($aquivoNome));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');

// Envia o arquivo para o cliente
readfile($aquivoNome);
}else{
	echo "Erro ao gerar o arquivo";
	}
?>