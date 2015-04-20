<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DNIT Móvel - Admin</title>
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" type="text/css" href="datatables/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="datatables/dataTables.jqueryui.css">
<link rel="stylesheet" href="colorbox.css" />
<script type="text/javascript" language="javascript" src="datatables/jquery-1.11.1.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="datatables/dataTables.jqueryui.js"></script>
<script src="jscolorb.js"></script>
<script>
			$(document).ready(function(){
				$(".iframe").colorbox({iframe:true, width:900, height:700});
				$(".iframe2").colorbox({iframe:true, width:900, height:700});
				
			});
		</script>
<script type="text/javascript" class="init">

$(document).ready(function() {
	 $('#example').dataTable( {
        "order": [[ 4, "desc" ]],
		"pagingType": "full_numbers"
    } );
} );

	</script>
    <style type="text/css">
  .botao{
        font-size:12px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#06A62C;
        border:0px;
        width:80px;
        height:30px;
		border-radius:20px;
       }
</style>
</head>
<body>
<?php 
  $mensagem=$_GET['msg'];
  echo"
  <h2>Mensagem enviada ao usuário</h2>".$mensagem;
 ?> 
 </body>
 </html>