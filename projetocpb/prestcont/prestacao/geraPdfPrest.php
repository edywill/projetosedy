<?php 
session_start();
$_SESSION['pendAprov']='';
$_SESSION['codValida']='';
require('../../fpdf/fpdf.php');
	  require "../../conectsqlserver.php";
	  require "../../sav/conectsqlserversav.php";
	  require "../../conect.php";
	  include "../../sav/funcoesGerais.php";
	  if(!empty($_GET['gest'])){
		$sqlSavImpressaoGestor=mysql_fetch_array(mysql_query("SELECT savregistros.*,prestsav.obs AS detalhamento,prestsav.status AS situacaoPrest FROM savregistros LEFT JOIN prestsav ON prestsav.savid=savregistros.id WHERE prestsav.id='".$_GET['gest']."'"));
		  $_SESSION['numSav']=$sqlSavImpressaoGestor['id'];
		  $_SESSION['numCiSav']=$sqlSavImpressaoGestor['numci'];
		   $_SESSION['detalhaPrestSav']=$sqlSavImpressaoGestor['detalhamento'];	  
		  }
	  $numSav=$_SESSION['numSav'];
	  $numCi=$_SESSION['numCiSav'];
	  $sqlDadosProcesso=mysql_fetch_array(mysql_query("SELECT * FROM savdiarias WHERE idsav='".$numSav."'"));
	  $autorizacao=$sqlDadosProcesso['nautor'];
	  $processo=$sqlDadosProcesso['numproc'];
	  $numDias=number_format($sqlDadosProcesso['qtddias'],1,',','.');
	  $vlTot="R$".number_format($sqlDadosProcesso['valortotal'],2,',','.');
	  
	  //Buscar assinatura e geração de dados
	  
	  include "../../sav/buscaDadosImpressao.php";
	  //Buscar Dados de Aprovação
	  $sqlDadosAprov=mysql_query("SELECT * FROM prestsavaprov WHERE idprest='".$_GET['gest']."'");
	  $presi='';
	  $super='';
	  $prestacao='';
	  while($objDadosAprov=mysql_fetch_object($sqlDadosAprov)){
		  if(!empty($objDadosAprov->apsuper)){
			  $super=1;
			  $presi=1;
			  }
		  if(!empty($objDadosAprov->apprest) || $sqlSavImpressaoGestor['situacaoPrest']=='fi'){
			  $prestacao=1;
			  }
		  }
	  if($super==1){
			$assinadoSuper="Assinado Eletronicamente";
			}
			if($presi==1){
		     $assinadoPresi="Assinado Eletronicamente";
			}
			if($prestacao==1){
			$_SESSION['pendAprov']=0;	
				};
		 $hash=geraSenha(15);
		 $_SESSION['codValida']=$hash;
class PDF extends FPDF
{
   //Método Header que estiliza o cabeçalho da página
   function Header() {
      //insere e posiciona a imagem/logomarca
      $this->Image('../../imagens/logoDocumento2.png',94,12,20);

      //Informa a fonte, seu estilo e seu tamanho     
      $this->AddFont('Verdana');
	 $this->SetFont('Arial','B',12);

      //Informa o tamanho do box que receberá o cabeçalho
      //o texto que ele conterá, suas bordas e o alinhaento do texto
	  //$this->Cell(155,20,utf8_decode("Relatório de Visualização dos Recibos de PagamentoMês: ".$_POST['mesCh']." / ".$_POST['anoCh']),1,0,'C');
   }

   //Método Footer que estiliza o rodapé da página
   function Footer() {

      //posicionamos o rodapé a 1cm do fim da página
      //$this->SetY(-10);
      
      //Informamos a fonte, seu estilo e seu tamanho
     // $this->AddFont('Verdana');
	  $this->SetFont('Arial','I',8);
      //Informamos o tamanho do box que vai receber o conteúdo do rodapé
      //e inserimos o número da página através da função PageNo()
      //além de informar se terá borda e o alinhamento do texto
	  $this->ln(10);
	if($_SESSION['pendAprov']==0){
	$this->Cell(0,10,utf8_decode('Para verificar a autenticidade, acesse: http://www.cpb.org.br/intranetcpb/verifica e informe o código: '.$_SESSION['codValida'].''),0,0,'C');
	}else{
		$this->Cell(0,10,utf8_decode('DOCUMENTO PENDENTE DE APROVAÇÃO DOS GESTORES.'),0,0,'C');
		}
	$this->Image('../../sav/css/rodape_sav.png',30,245,180,55);
   }

}
//Criamos o objeto da classe PDF
$pdf=new PDF();
$pdf->AliasNbPages();
//Inserimos a página
	  $pdf->AddPage();
	  $pdf->SetMargins(20,45,20);
	  $pdf->SetFont('Arial','B',12);
	  $pdf->Ln(10);
	  $pdf->Ln(10);
	  $pdf->Ln(10);
	  //$pdf->Cell(85,10,"",0,'C');
	  $pdf->Cell(0,10,"ANEXO IV",0,0,'C');
	  $pdf->Ln(5);
	  //$pdf->Cell(58,10,"",0,'C');
	  $pdf->Cell(0,10,utf8_decode("COMITÊ PARALÍMPICO BRASILEIRO"),0,0,'C');
	  $pdf->Ln(10);
//apontamos a fonte que será utilizada no texto

//Aquí escribimos lo que deseamos mostrar...
	  $altura=5;
	  $altura2=9;
	  $largura=30;
	  $contador=0;
	   $pdf->SetAutoPageBreak(true,43);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(204,204,204);
	  $pdf->Cell(0, $altura, utf8_decode("PRESTAÇÃO DE CONTAS DE VIAGEM A SERVIÇO"), 0, 0, 'C',true);
	  $pdf->Ln();
	  $pdf->Cell(0, $altura, utf8_decode("( ".$dirigente." )  DIRIGENTE			( ".$funcionario." )  FUNCIONÁRIO"), 0, 0, 'C',true);
	  //$pdf->Cell(0, $altura2, $conteudoCab1, 0, 0, 'C',true); 
	  $pdf->Ln(8);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("I - DADOS DO PROCESSO:"), 0, 0, 'C',true);
	  $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	 $pdf->SetFont('Arial','B',11);
	 $pdf->Cell(30, $altura, utf8_decode(" Nº. Processo: "), 0, 0, 'L',false);
	 $pdf->SetFont('Arial','',11);
	 $pdf->Cell(0, $altura, $processo, 0, 0, 'L',false);
		$pdf->Ln(6);
	 $pdf->SetFont('Arial','B',11);
	 $pdf->Cell(30, $altura, utf8_decode(" Autorização: "), 0, 0, 'L',false);
	 $pdf->SetFont('Arial','',11);
	 $pdf->Cell(0, $altura, utf8_encode($autorizacao)."/2015", 0, 0, 'L',false);
	   $pdf->Ln(8);
	 
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("II - DADOS DO VIAJANTE:"), 0, 0, 'C',true);
	   $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(16, $altura, utf8_decode(" Nome: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['nomeFuncSav']), 0, 0, 'L',false);
	  $pdf->Ln(5);
	   $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(16, $altura, utf8_decode(" Cargo: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['cargoSav']), 0, 0, 'L',false);
	  $pdf->Ln(8);
	  
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("III - VIAGEM REALIZADA:"), 0, 0, 'C',true);
	  $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(10, $altura, utf8_decode(""), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(32, $altura, utf8_decode("Trecho"), 0, 0, 'C',false);
	  $pdf->Cell(45, $altura, utf8_decode("Data"), 0,0, 'C',false);
	  $pdf->Cell(20, $altura, utf8_decode("Horário"), 0, 0, 'C',false);
	  $pdf->Cell(40, $altura, utf8_decode("Vôo"), 0, 0, 'C',false);
	  $pdf->Cell(10, $altura, utf8_decode("Cia Aérea"), 0, 0, 'C',false);	
	  
	  $sqlPassagemImp=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  $countPassagemImpContador=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){
	  
	  if($objPassagemImp->inter<>'itn'){
		  $sqlTrechoNacImpIda=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->origem."'"));
				  $sqlTrechoNacImpVolta=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->destino."'"));
				  $idaImpressao=$sqlTrechoNacImpIda['uf'];
				  $voltaImpressao=$sqlTrechoNacImpVolta['uf'];
				  }else{
					  $idaImpressao=$objPassagemImp->origem;
				  	  $voltaImpressao=$objPassagemImp->destino;
					  }
		$horarioViagem='';
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($countPassagemImpContador<$countPassagemImp){
	  $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id ASC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$horarioViagem=$sqlPassagemRegistro['horario'];
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("IDA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(30, $altura,  $idaImpressao." x ".$voltaImpressao, 0,'C',false);
	  $pdf->Cell(30, $altura, utf8_decode($objPassagemImp->dtida), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($ciaaerea), 0, 0, 'C',false);	
		  }else{
			  $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id DESC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$horarioViagem=$sqlPassagemRegistro['horario'];
			$pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("VOLTA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(30, $altura,  $idaImpressao." x ".$voltaImpressao, 0,'C',false);
	  $pdf->Cell(30, $altura, utf8_decode($objPassagemImp->dtida), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($ciaaerea), 0, 0, 'C',false);	
			}
	 	}else{
			for($i=0;$i<=1;$i++){
			   if($i==0){	
			   $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id ASC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$horarioViagem=$sqlPassagemRegistro['horario'];	   
$pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("IDA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(30, $altura,  $idaImpressao." x ".$voltaImpressao, 0,'C',false);
	  $pdf->Cell(30, $altura, utf8_decode($objPassagemImp->dtida), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($ciaaerea), 0, 0, 'C',false);	
			   }else{
				   $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id DESC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$horarioViagem=$sqlPassagemRegistro['horario'];
$pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("VOLTA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(30, $altura,  $voltaImpressao." x ".$idaImpressao, 0,'C',false);
	  $pdf->Cell(30, $altura, utf8_decode($objPassagemImp->dtvolta), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(25, $altura, utf8_decode($ciaaerea), 0, 0, 'C',false);					  
				   }
			   }
			}
	  }
	  
$pdf->Ln(8);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("IV - DIÁRIAS:"), 0, 0, 'C',true);
	   $pdf->Ln(8);
	   $pdf->SetTextColor(0,0,0);
	   $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode("Nº. DE DIÁRIAS RECEBIDAS: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, $numDias, 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode("VALOR TOTAL: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, $vlTot, 0, 0, 'L',false);
	   
	   $pdf->Ln(8);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("V - DEVOLUÇÃO DO BILHETE:"), 0, 0, 'C',true);
	  $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','',11);
	  $sqlPassagemImp=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  $countPassagemImpContador=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){
	  if($objPassagemImp->inter<>'itn'){
		  $sqlTrechoNacImpIda=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->origem."'"));
				  $sqlTrechoNacImpVolta=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->destino."'"));
				  $idaImpressao=$sqlTrechoNacImpIda['uf'];
				  $voltaImpressao=$sqlTrechoNacImpVolta['uf'];
				  }else{
					  $idaImpressao=$objPassagemImp->origem;
				  	  $voltaImpressao=$objPassagemImp->destino;
					  }
		$horarioViagem='';		
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($countPassagemImpContador<$countPassagemImp){
	  $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id ASC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$loc=$sqlPassagemRegistro['loc'];
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(35, $altura, "Voo: ".utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(45, $altura, "LOC: ".utf8_decode($loc), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, "Cia: ".utf8_decode($ciaaerea), 0, 0, 'C',false);
	  $pdf->Cell(40, $altura,  "Trecho: ".$idaImpressao." / ".$voltaImpressao, 0,'C',false);
		  }else{
			  $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id DESC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$loc=$sqlPassagemRegistro['loc'];
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(35, $altura, "Voo: ".utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(45, $altura, "LOC: ".utf8_decode($loc), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, "Cia: ".utf8_decode($ciaaerea), 0, 0, 'C',false);
	  $pdf->Cell(40, $altura,  "Trecho: ".$idaImpressao." / ".$voltaImpressao, 0,'C',false);
			}
	 	}else{
			for($i=0;$i<=1;$i++){
			   if($i==0){	
			   $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id ASC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$loc=$sqlPassagemRegistro['loc'];
			  $pdf->Ln(5);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(35, $altura, "Voo: ".utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(45, $altura, "LOC: ".utf8_decode($loc), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, "Cia: ".utf8_decode($ciaaerea), 0, 0, 'C',false);
	  $pdf->Cell(40, $altura,  "Trecho: ".$idaImpressao." / ".$voltaImpressao, 0,'C',false);
			   }else{
				   $sqlPassagemRegistro=mysql_fetch_array(mysql_query("SELECT prestsavvoo.*,cia.nome FROM prestsavvoo LEFT JOIN cia ON cia.id=prestsavvoo.cia WHERE idpass='".$objPassagemImp->id."' ORDER BY id DESC"));
		$voo=$sqlPassagemRegistro['voo'];
		$ciaaerea=$sqlPassagemRegistro['nome'];
		$loc=$sqlPassagemRegistro['loc'];
				   $pdf->Ln(5);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(35, $altura, "Voo: ".utf8_decode($voo), 0, 0, 'C',false);
	  $pdf->Cell(45, $altura, "LOC: ".utf8_decode($loc), 0, 0, 'C',false);
	  $pdf->Cell(35, $altura, "Cia: ".utf8_decode($ciaaerea), 0, 0, 'C',false);
	  $pdf->Cell(40, $altura,  "Trecho: ".$voltaImpressao." / ".$idaImpressao, 0,'C',false);			  
				   }
			   }
			}
	  }
	  
	  $pdf->Ln(8);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("VI - RESUMO DAS ATIVIDADES DESENVOLVIDAS NO DECORRER DO DESLOCAMENTO:"), 0, 0, 'L',true);
	   $pdf->Ln(8);
	   $pdf->SetFont('Arial','',11);
	   $pdf->SetTextColor(0,0,0);
	   $pdf->MultiCell(0, 4,  $_SESSION['detalhaPrestSav'], 0);
	   $pdf->Ln(4);
	  $pdf->SetFont('Times','I',8);
	  $pdf->SetTextColor(155,155,155);
	  $pdf->Cell(40, $altura, "", 0, 0, 'C',false);
	   $pdf->Cell(90, $altura, utf8_decode("Assinado Eletronicamente"), 0, 0, 'C',false);
	   $pdf->Ln(5);
	   $pdf->SetFont('Arial','B',11);
	   $pdf->SetTextColor(0,0,0);
	   $pdf->Cell(35, $altura, "", 0, 0, 'C',false);
	   $pdf->Cell(95, $altura, utf8_decode($_SESSION['nomeFuncSav']), 0, 0, 'C',false);
	    $pdf->Ln(5);
	  $pdf->SetFont('Arial','',10);
	  $pdf->Cell(35, $altura, "", 0, 0, 'C',false);
	  $pdf->Cell(100, $altura, utf8_decode("VIAJANTE"), 0, 0, 'C',false);
	  
	   $pdf->Ln(6);
	  $pdf->SetFont('Times','I',8);
	  $pdf->SetTextColor(155,155,155);
	   $pdf->Cell(90, $altura, utf8_decode($assinadoSuper), 0, 0, 'C',false);
	   $pdf->Cell(85, $altura, utf8_decode($assinadoPresi), 0, 0, 'C',false);
	   $pdf->Ln(5);
	   $pdf->SetFont('Arial','B',11);
	   $pdf->SetTextColor(0,0,0);
	   $pdf->Cell(95, $altura, utf8_decode($superintendente), 0, 0, 'C',false);
	  $pdf->Cell(90, $altura,utf8_decode("".$presidente), 0,'C',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','',10);
	  $pdf->Cell(100, $altura, utf8_decode("PROPONENTE"), 0, 0, 'C',false);
	  $pdf->Cell(107, $altura,utf8_decode("  AUTORIZAÇÃO DA PRESIDÊNCIA"), 0,'C',false);
ob_start ();
$pdf->Output('SAV '.$_SESSION['numSav'].'.pdf','I');

?>