<?php 
session_start();
$_SESSION['pendAprov']='';
$_SESSION['codValida']='';
require('../fpdf/fpdf.php');
	  require "../conectsqlserver.php";
	  require "conectsqlserversav.php";
	  require "../conect.php";
	  include "funcoesGerais.php";
	  if(!empty($_GET['gest'])){
		 $_SESSION['numSav']=$_GET['gest'];
		  $sqlSavImpressaoGestor=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$_SESSION['numSav']."'"));
		  $_SESSION['numCiSav']=$sqlSavImpressaoGestor['numci'];	  
		  }
	  $numSav=$_SESSION['numSav'];
	  $numCi=$_SESSION['numCiSav'];
	  include "buscaDadosImpressao.php";
class PDF extends FPDF
{
   //Método Header que estiliza o cabeçalho da página
   function Header() {
      //insere e posiciona a imagem/logomarca
      $this->Image('../imagens/logoDocumento2.png',94,12,20);

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
	$this->Image('css/rodape_sav.png',30,245,180,55);
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
	  $pdf->Cell(0,10,"ANEXO I",0,0,'C');
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
	  $pdf->Cell(0, $altura, utf8_decode("SOLICITAÇÃO DE VIAGENS E PASSAGENS"), 0, 0, 'C',true);
	  $pdf->Ln();
	  $pdf->Cell(0, $altura, utf8_decode("( ".$dirigente." )  DIRIGENTE			( ".$funcionario." )  FUNCIONÁRIO"), 0, 0, 'C',true);
	  //$pdf->Cell(0, $altura2, $conteudoCab1, 0, 0, 'C',true); 
	  $pdf->Ln(8);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("I - DADOS DO PROPONENTE:"), 0, 0, 'L',true);
	  $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(16, $altura, utf8_decode(" Nome: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($superintendente), 0, 0, 'L',false);
	   $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(16, $altura, utf8_decode(" Cargo: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode("SUPERINTENDENTE"), 0, 0, 'L',false);
	   $pdf->Ln(8);
	 
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("II - DADOS DO VIAJANTE:"), 0, 0, 'L',true);
	   $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(16, $altura, utf8_decode(" Nome: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['nomeFuncSav']), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(13, $altura, utf8_decode(" CPF: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['cpfSav']), 0, 0, 'L',false);
	  $pdf->Ln(5);
	   $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(16, $altura, utf8_decode(" Cargo: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['cargoSav']), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(17, $altura, utf8_decode(" Banco: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['bancoSav']), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode(" Agência: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['agenciaSav']), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(33, $altura, utf8_decode(" Conta Corrente: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, utf8_decode($_SESSION['contCorrenteSav']), 0, 0, 'L',false);
	  $pdf->Ln(8);
	  
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("III - OBJETIVO DA VIAGEM:"), 0, 0, 'L',true);
	   $pdf->Ln(8);
	   $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','',11);
	  $pdf->MultiCell(0, 4,  $sqlSavImpressao['objetivo'], 0);
	  //$pdf->Cell(0, $altura, , 0, 0, 'L',false);
	  $pdf->Ln(8);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("IV - DESLOCAMENTO:"), 0, 0, 'L',true);
	  $pdf->Ln(8);
	  $pdf->SetTextColor(0,0,0);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(20, $altura, utf8_decode(""), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(40, $altura, utf8_decode("Data"), 0, 0, 'C',false);
	  $pdf->Cell(65, $altura, utf8_decode("Trecho"), 0,0, 'C',false);
	  $pdf->Cell(45, $altura, utf8_decode("Horário"), 0, 0, 'C',false);
	  
	  $sqlPassagemImp=mysql_query("SELECT * FROM savpassagem WHERE idsav='".$numSav."'");
  $countPassagemImp=mysql_num_rows($sqlPassagemImp);
  $countPassagemImpContador=0;
  while($objPassagemImp=mysql_fetch_object($sqlPassagemImp)){
	  if($objPassagemImp->inter<>'itn'){
		  $sqlTrechoNacImpIda=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->origem."'"));
				  $sqlTrechoNacImpVolta=mysql_fetch_array(mysql_query("SELECT municipio,uf FROM municipios WHERE id='".$objPassagemImp->destino."'"));
				  $idaImpressao=$sqlTrechoNacImpIda['municipio']."(".$sqlTrechoNacImpIda['uf'].")";
				  $voltaImpressao=$sqlTrechoNacImpVolta['municipio']."(".$sqlTrechoNacImpVolta['uf'].")";
				  }else{
					  $idaImpressao=$objPassagemImp->cidorigem."(".$objPassagemImp->origem.")";
				  	  $voltaImpressao=$objPassagemImp->ciddestino."(".$objPassagemImp->destino.")";
					  }
		$horarioViagem='';
		
	  $countPassagemImpContador++;
	  if($objPassagemImp->tipo==1){
		  if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
		  if($countPassagemImpContador<$countPassagemImp){
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("IDA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(40, $altura, utf8_decode($objPassagemImp->dtida), 0, 0, 'C',false);
	  $pdf->Cell(65, $altura,  $idaImpressao." x ".$voltaImpressao, 0,'C',false);
	  $pdf->Cell(45, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);	  
		  }else{
			$pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("VOLTA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(40, $altura, utf8_decode($objPassagemImp->dtida), 0, 0, 'C',false);
	  $pdf->Cell(65, $altura,  $idaImpressao." x ".$voltaImpressao, 0,'C',false);
	  $pdf->Cell(45, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);
			}
	 	}else{
			for($i=0;$i<=1;$i++){
			   if($i==0){
			   if($objPassagemImp->horarioida=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
			   
$pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("IDA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(40, $altura, utf8_decode($objPassagemImp->dtida), 0, 0, 'C',false);
	  $pdf->Cell(65, $altura,  $idaImpressao." x ".$voltaImpressao, 0,'C',false);
	  $pdf->Cell(45, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);
			   }else{
				  if($objPassagemImp->horariovolta=='manha'){
			  $horarioViagem='Manhã (4h-12h)';
			  }elseif($objPassagemImp->horariovolta=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horariovolta=='noite'){
			  			$horarioViagem='Noite (18h01-3h59)';
			  }
$pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(20, $altura, utf8_decode("VOLTA"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',9);
	  $pdf->Cell(40, $altura, utf8_decode($objPassagemImp->dtvolta), 0, 0, 'C',false);
	  $pdf->Cell(65, $altura,  $voltaImpressao." x ".$idaImpressao, 0,'C',false);
	  $pdf->Cell(45, $altura, utf8_decode($horarioViagem), 0, 0, 'C',false);				  
				   }
			   }
			}
	  }
	  
$pdf->Ln(8);
	  
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("V - DADOS COMPLEMENTARES:"), 0, 0, 'L',true);
	   $pdf->Ln(8);
	   $pdf->SetTextColor(0,0,0);
	   $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode(" Última Viagem Realizada: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $pdf->Cell(0, $altura, $sqlSavImpressao['ultimaviagem'], 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode(" Devolveu o bilhete: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $devBil='';
	  if($sqlSavImpressao['devbilhete']=='sim'){
	$devBil="(X) Sim                ( ) Não";
	}else{
		$devBil="( ) Sim                (X) Não";
		}
	  $pdf->Cell(0, $altura, utf8_decode($devBil), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode(" Passagens: "), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $solPas='';
	  if($sqlSavImpressao['passagem']=='sim'){
	$solPas="(X) Sim                ( ) Não";
	}else{
		$solPas="( ) Sim                (X) Não";
		}
	  $pdf->Cell(0, $altura, utf8_decode($solPas), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode(" Diárias com hospedagem:"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $solHos='';
	  if($sqlSavImpressao['hospedagem']=='sim'){
	$solHos="(X) Sim                ( ) Não";
	}else{
		$solHos="( ) Sim                (X) Não";
		}
	  $pdf->Cell(0, $altura, utf8_decode($solHos), 0, 0, 'L',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->Cell(60, $altura, utf8_decode(" Translado Intermunicipal:"), 0, 0, 'L',false);
	  $pdf->SetFont('Arial','',11);
	  $solTra='';
	  if($sqlSavImpressao['translado']=='sim'){
	$solTra="(X) Sim                ( ) Não";
	}else{
		$solTra="( ) Sim                (X) Não";
		}
	  $pdf->Cell(0, $altura, utf8_decode($solTra), 0, 0, 'L',false);
	  $pdf->Ln(8);
	  $pdf->SetFont('Arial','B',11);
	  $pdf->SetFillColor(0,32,96);
	  $pdf->SetTextColor(255,255,255);
	  $pdf->Cell(0, $altura, utf8_decode("VI - OBSERVAÇÕES:"), 0, 0, 'L',true);
	   $pdf->Ln(8);
	   $pdf->SetFont('Arial','',11);
	   $pdf->SetTextColor(0,0,0);
	   $pdf->MultiCell(0, 4,  $sqlSavImpressao['observ'], 0);
	   
	   $pdf->Ln(4);
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