<?php 
$conn = mysql_connect("dbmy0035.whservidor.com", "aednit_2", "drupal11aednit") or die("Impossível conectar");
mysql_select_db("aednit_2", $conn);
  mysql_query("SET NAMES 'utf8'");
  mysql_query('SET character_set_connection=utf8');
  mysql_query('SET character_set_client=utf8');
  mysql_query('SET character_set_results=utf8');
$sql1=mysql_query("SELECT du.uid,
du.name,du.mail AS email,
cargo.field_cargo_value AS cargo,
dtadm.field_dataadmdnit_value as dtAdm,
dtnas.field_datanasc_value as dtnasc,
endereco.field_endereco_value as endereco,
cidade.field_enderecocidade_value as cidade,
uf.field_enderecouf_value as uf,
nome.field_nome_value AS nome,
sexo.field_sexo_value AS sexo,
teltrabalho.field_teltrabalho_value AS teltrabalho
FROM drupal_users AS du LEFT JOIN (
drupal_field_data_field_cargo AS cargo,
drupal_field_data_field_dataadmdnit AS dtadm,
drupal_field_data_field_datanasc AS dtnas,
drupal_field_data_field_endereco AS endereco,
drupal_field_data_field_enderecocidade AS cidade,
drupal_field_data_field_enderecouf AS uf,
drupal_field_data_field_nome AS nome,
drupal_field_data_field_sexo AS sexo,
drupal_field_data_field_teltrabalho AS teltrabalho)
ON(
cargo.entity_id=du.uid AND
dtadm.entity_id=du.uid AND
dtnas.entity_id=du.uid AND
endereco.entity_id=du.uid AND
cidade.entity_id=du.uid AND
uf.entity_id=du.uid AND
nome.entity_id=du.uid AND
sexo.entity_id=du.uid AND
teltrabalho.entity_id=du.uid
)") or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
<tr><td>ID</td><td>Usuario</td><td>Email</td><td>Cargo</td><td>Data admissão</td><td>Data Nascimento</td><td>Endereço</td><td>Cidade</td><td>Complemento</td><td>Nº</td><td>UF</td><td>lotação</td><td>matricula DNIT</td><td>Nome</td><td>Sexo</td><td>Siape</td><td> Celular</td><td> Residencial </td><td>Trabalho</td></tr>
<?php
echo mysql_num_rows($sql1);
while($obj1=mysql_fetch_object($sql1)){
	
	if(!empty($obj1->name) && $obj1->name<> "admin"){
	$complemento='';
	$celular='';
	$residencial='';
	$siape='';
	$numero='';
	$lotacao='';
	$matdnit='';
	
	$selectComplemento=mysql_query("SELECT field_enderecocomplemento_value AS comp FROM drupal_field_data_field_enderecocomplemento WHERE entity_id=".$obj1->uid."");
	$resComplemento=mysql_fetch_array($selectComplemento);
	if(!empty($resComplemento)){
		$complemento=$resComplemento['comp'];
		}
	
	$selectNumero=mysql_query("SELECT field_endereconumero_value AS numero FROM drupal_field_data_field_endereconumero WHERE entity_id=".$obj1->uid."");
	$resNumero=mysql_fetch_array($selectNumero);
	if(!empty($resNumero)){
		$numero=$resNumero['numero'];
		}
		
	$selectCelular=mysql_query("SELECT field_telcelular_value AS celular FROM drupal_field_data_field_telcelular WHERE entity_id=".$obj1->uid."");
	$resCelular=mysql_fetch_array($selectCelular);
	if(!empty($resCelular)){
		$celular=$resCelular['celular'];
		}
		
		$selectResidencial=mysql_query("SELECT field_telresidencial_value AS residencial FROM drupal_field_data_field_telresidencial WHERE entity_id=".$obj1->uid."");
	$resResidencial=mysql_fetch_array($selectResidencial);
	if(!empty($resResidencial)){
		$residencial=$resResidencial['residencial'];
		}
		//SIAPE
		$selectSiape=mysql_query("SELECT field_siape_value AS siape FROM drupal_field_data_field_siape WHERE entity_id=".$obj1->uid."");
	$resSiape=mysql_fetch_array($selectSiape);
	if(!empty($resSiape)){
		$siape=$resSiape['siape'];
		}
		//Lotacao
		$selectLot=mysql_query("SELECT field_lotacao_value AS lotacao FROM drupal_field_data_field_lotacao WHERE entity_id=".$obj1->uid."");
	$resLot=mysql_fetch_array($selectLot);
	if(!empty($resLot)){
		$lotacao=$resLot['lotacao'];
		}
		//MatDNIT
		$selectMat=mysql_query("SELECT field_matdnit_value AS matdnit FROM drupal_field_data_field_matdnit WHERE entity_id=".$obj1->uid."");
	$resMat=mysql_fetch_array($selectMat);
	if(!empty($resMat)){
		$matdnit=$resMat['matdnit'];
		}
		
	echo "<tr><td>".$obj1->uid."</td><td>".$obj1->name."</td><td>".$obj1->email."</td><td>".$obj1->cargo."</td><td>".date('d/m/Y', strtotime($obj1->dtAdm))."</td><td>".date('d/m/Y', strtotime($obj1->dtnasc))."</td><td>".$obj1->endereco."</td><td>".$obj1->cidade."</td>";
	
	echo "<td>".$complemento."</td>";
	
	echo "<td>".$numero."</td>";
    
	echo "<td>".$obj1->uf."</td>";
	
	echo "<td>".$lotacao."</td>";
	
	echo "<td>".$matdnit."</td>";
	
	echo "<td>".$obj1->nome."</td><td>".$obj1->sexo."</td>";
	
	echo "<td>".$siape."</td>";
	
	echo "<td>".$celular."</td>";
	
	echo "<td>".$residencial."</td>";
	
	echo "<td>".$obj1->teltrabalho."</td></tr>";
	}
	}
?>
</table>
</body>
</html>