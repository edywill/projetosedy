<?php 
session_start();
	  require('../../fpdf/class_multitag.php');
	  require "../../conectsqlserverci.php";
	  require "../../conect.php";
/*	  
	  if(!empty($_GET['gest'])){
		 $_SESSION['numSav']=$_GET['gest'];
		  $sqlSavImpressaoGestor=mysql_fetch_array(mysql_query("SELECT * FROM savregistros WHERE id='".$_SESSION['numSav']."'"));
		  $_SESSION['numCiSav']=$sqlSavImpressaoGestor['numci'];	  
		  }
	  $numSav=$_SESSION['numSav'];
	  $numCi=$_SESSION['numCiSav'];
	  include "buscaDadosOrdem.php";
	*/  
//
class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;

function PDF($orientation='P', $unit='mm', $size='A4')
{
    // Call parent constructor
    $this->FPDF($orientation,$unit,$size);
    // Initialization
    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';
}

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
function WriteHtmlCellB($cellWidth, $html){        
    $rm = $this->rMargin;
    $this->SetRightMargin($this->w - $this->GetX() - $cellWidth);
    $this->WriteHtml($html);
    $this->SetRightMargin($rm);
}
   //Método Header que estiliza o cabeçalho da página
   function Header() {
      //insere e posiciona a imagem/logomarca
      $this->Image('../../imagens/logoDocumento2.png',94,12,20);

      //Informa a fonte, seu estilo e seu tamanho     
	 $this->SetFont('Arial','B',11);
   }

   //Método Footer que estiliza o rodapé da página
   function Footer() {

      //posicionamos o rodapé a 1cm do fim da página
      $this->SetY(-10);
      
      //Informamos a fonte, seu estilo e seu tamanho
     // $this->AddFont('Verdana');
	  $this->SetFont('Arial','I',10);
	  $this->Cell(0,10,$this->PageNo(),0,0,'R');
   }

}
//Criamos o objeto da classe PDF
$pdf=new FPDF_MULTICELLTAG();
$pdf->AliasNbPages();
//Inserimos a página
	  $pdf->AddPage();
	  $pdf->SetMargins(20,45,20);
	  $pdf->SetFont('Arial','',11);
	  $meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
	$mesNum=(int)date('m');
	$dataHoje=date("d")." de ".$meses[$mesNum]." de ".date("Y");
	$pdf->Ln(10);
	$pdf->Ln(10);
	$pdf->Ln(10);
	$pdf->Cell(0,10,utf8_decode("Brasília-DF, ".$dataHoje."."),0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(0,10,utf8_decode("Ordem de Serviço/Compra n.º: ".$_SESSION['idOsImpSession']."/".$_SESSION['anoOsImpSession']."."),0,0,'R');
	$pdf->Ln(10);
	$pdf->Cell(43,10,utf8_decode("Departamento Emissor: "),0,0,'L');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,10,utf8_decode("DEAC."),0,0,'L');
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(7);
	$pdf->Cell(43,10,utf8_decode("Prestador de Serviços: "),0,0,'L');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(0,10,str_replace("?","-",utf8_decode("SAL DA TERRA.")),0,0,'L');
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(10);


	$html1="1. Documento Interno Referência: <t3>proc. 0528/13 – CI Nº 7162/14 1234567890 1234567 111 111 222</t3>";
	//$pdf->WriteHTML(utf8_decode($html1),$parsed);
	///$pdf->MultiCell(0,10,$parsed,1,'L',0);
	  //$pdf->WriteHtmlCellB(180, $html1);
	  $pdf->SetStyle2("t3","arial","B",11,"0,0,255");
	  $pdf->MultiCellTag(150, 5, $html1, 1, "L", 1, 5, 5, 5, 5);
	  /*
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
			  $horarioViagem='Manhã (6h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h)';
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
			  $horarioViagem='Manhã (6h-12h)';
			  }elseif($objPassagemImp->horarioida=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horarioida=='noite'){
			  			$horarioViagem='Noite (18h01-3h)';
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
			  $horarioViagem='Manhã (6h-12h)';
			  }elseif($objPassagemImp->horariovolta=='tarde'){
			  			$horarioViagem='Tarde (12h01-18h)';
			  }elseif($objPassagemImp->horariovolta=='noite'){
			  			$horarioViagem='Noite (18h01-3h)';
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
	   $pdf->SetFont('Arial','I',9);
	   $pdf->Cell(90, $altura, utf8_decode($assinadoSuper), 0, 0, 'C',false);
	   $pdf->Cell(70, $altura, utf8_decode($assinadoPresi), 0, 0, 'C',false);
	   $pdf->Ln(2);
	    $pdf->SetFont('Arial','',11);
	   $pdf->Cell(90, $altura, utf8_decode("________________________________"), 0, 0, 'C',false);
	  $pdf->Cell(90, $altura,utf8_decode("____________________________________"), 0,'C',false);
	   $pdf->Ln(5);
	   $pdf->SetFont('Arial','B',11);
	   $pdf->Cell(95, $altura, utf8_decode($superintendente), 0, 0, 'C',false);
	  $pdf->Cell(90, $altura,utf8_decode("".$presidente), 0,'C',false);
	  $pdf->Ln(5);
	  $pdf->SetFont('Arial','',10);
	  $pdf->Cell(97, $altura, utf8_decode("PROPONENTE"), 0, 0, 'C',false);
	  $pdf->Cell(90, $altura,utf8_decode("  AUTORIZAÇÃO DA PRESIDÊNCIA"), 0,'C',false);
	  */
ob_start ();
$pdf->Output('Ordem de Servico.pdf','I');

?>