<?php
//fazemos a inclusão do arquivo com a classe FPDF
require('fpdf/fpdf.php');
include "mb.php";
header('charset=ISO-8859-1');
//criamos uma nova classe, que será uma extensão da classe FPDF
//para que possamos sobrescrever o método Header()
//com a formatação desejada
class PDF extends FPDF
{
   //Método Header que estiliza o cabeçalho da página
   function Header() {
      //insere e posiciona a imagem/logomarca
      $this->Image('imagens/logoDocumento2.png',10,8,20);

      //Informa a fonte, seu estilo e seu tamanho     
      $this->SetFont('Arial','B',16);

      //Informa o tamanho do box que receberá o cabeçalho
      //o texto que ele conterá, suas bordas e o alinhaento do texto
      $this->Cell(30,20,'',0,0,'C');
	  //$this->Cell(155,20,utf8_decode("Relatório de Visualização dos Recibos de PagamentoMês: ".$_POST['mesCh']." / ".$_POST['anoCh']),1,0,'C');
      $this->MultiCell(155,10,utf8_decode("  Relatório de Visualização dos Recibos de Pagamento    ".$_POST['mesCh']." / ".$_POST['anoCh']),1,'C');
	  $this->Ln(10);
   }

   //Método Footer que estiliza o rodapé da página
   function Footer() {

      //posicionamos o rodapé a 1cm do fim da página
      $this->SetY(-10);
      
      //Informamos a fonte, seu estilo e seu tamanho
      $this->SetFont('Arial','I',8);
      //Informamos o tamanho do box que vai receber o conteúdo do rodapé
      //e inserimos o número da página através da função PageNo()
      //além de informar se terá borda e o alinhamento do texto
			  $this->Cell(0,10,utf8_decode('Pág.').$this->PageNo(),0,0,'C');
   }

}
//Criamos o objeto da classe PDF
$pdf=new PDF();
$pdf->AliasNbPages();
//Inserimos a página
	  $pdf->AddPage();
//apontamos a fonte que será utilizada no texto

require("conectsqlserver.php");
require("conexaomysql.php");
$mesCh=$_POST["mesCh"];
$anoCh=$_POST["anoCh"];
$mesAtual=$anoCh."/".$mesCh."/30 00:00:00.000";
$sqlDadosUser=odbc_exec($conCab,"Select
						  dbo.RHESCALAS.DESCRICAO20 As DESCRICAO201,
						  dbo.RHESCALAS.DESCRICAO40 As DESCRICAO401,
						  dbo.RHESCALAS.DESCRICAO60,
						  dbo.RHPESSOAS.PESSOA,
						  dbo.RHPESSOAS.NOME,
						  dbo.RHSETORES.DESCRICAO40,
						  dbo.RHSETORES.DESCRICAO20,
						  dbo.RHCARGOS.DESCRICAO20 As DESCRICAO202,
						  dbo.RHPESSOAS.EMAILCORPORATIVO
						From
						  dbo.RHPESSOAS Inner Join
						  dbo.RHCONTRATOS On dbo.RHCONTRATOS.PESSOA = dbo.RHPESSOAS.PESSOA Inner Join
						  dbo.RHESCALAS On dbo.RHCONTRATOS.ESCALA = dbo.RHESCALAS.ESCALA Inner Join
						  dbo.RHSETORES On RHCONTRATOS.SETOR = RHSETORES.SETOR Inner Join
                          dbo.RHCARGOS On RHCONTRATOS.CARGO = RHCARGOS.CARGO
						  WHERE dbo.RHCONTRATOS.DATARESCISAO IS NULL AND
						  dbo.RHCONTRATOS.DATAADMISSAO<'".$mesAtual."'
						  ORDER BY dbo.RHSETORES.DESCRICAO20,dbo.RHPESSOAS.NOME");
//Aquí escribimos lo que deseamos mostrar...
	  $altura=7;
	  //$largura=30;
	  $contador=0;
	  $listaEmail='';
	  while($objFunc=odbc_fetch_object($sqlDadosUser)){
	   $contador++;
	   $pdf->SetFont('Arial','B',12);
	  $altura2=9;
	  $largura=30;
	  if($contador==1){
	  // criando os cabeçalhos para 5 colunas
	  $pdf->SetFillColor(205,205,205);
	  $pdf->Cell(15, $altura2, 'Mat.', 1, 0, 'L',true);
	  $pdf->Cell(60, $altura2, 'Nome', 1, 0, 'L',true);
	  $pdf->Cell(40, $altura2, 'Cargo', 1, 0, 'L',true);
	  $pdf->Cell(30, $altura2, 'Setor', 1, 0, 'L',true);
	  $pdf->Cell(40, $altura2, utf8_decode('Situação'), 1, 0, 'C',true);
	  $pdf->Ln();
	  }
	  if($contador==32){
		  $contador=0;
		  }
	      $pdf->SetFillColor(217,217,25);
		  $pdf->SetFont('Arial','',7);
		  $color=false;
		  $sqlStatus=mysql_query("SELECT dtvisualiza FROM listach WHERE pessoa='".$objFunc->PESSOA."' AND mes='".$mesCh."/".$anoCh."'");
		  $arrayStatus=mysql_fetch_array($sqlStatus);
		  $numLinhas=mysql_num_rows($sqlStatus);
		  $dtVisualiza=$arrayStatus['dtvisualiza'];
		  if($numLinhas==0){
			  if(empty($listaEmail)){
				   if(!empty($objFunc->EMAILCORPORATIVO)){
			$listaEmail=$objFunc->EMAILCORPORATIVO."; ";
				      }
				  }else{
					  if(!empty($objFunc->EMAILCORPORATIVO)){
		  $listaEmail=$listaEmail.$objFunc->EMAILCORPORATIVO."; ";
					  }
				  }
		  $color=true;
		  $dtVisualiza=utf8_decode('NÃO VISUALIZADO');
		  }
	  // criando os cabeçalhos para 5 colunas
	  $pdf->Cell(15, $altura, $objFunc->PESSOA, 1, 0, 'L',$color);
	  $pdf->Cell(60, $altura, $objFunc->NOME, 1, 0, 'L',$color);
	  $pdf->Cell(40, $altura, $objFunc->DESCRICAO202, 1, 0, 'L',$color);
	  $pdf->Cell(30, $altura, $objFunc->DESCRICAO20, 1, 0, 'L',$color);
	  $pdf->Cell(40, $altura, $dtVisualiza, 1, 0, 'C',$color);
	  $pdf->Ln();
	  }
	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',12);
	  $pdf->Cell(185, 20,utf8_decode('Relatório de E-mails Pendentes'), 1, 0, 'C');
	  $pdf->Ln();
	  $pdf->SetFont('Arial','',7);
	  $pdf->MultiCell(185,5,utf8_decode($listaEmail),1,1); 
	  //$pdf->Cell(185, 20,, 1, 0, 'L');
//geramos a página
$pdf->Output('relatorio_visualizacao_ch.php','I');
?>